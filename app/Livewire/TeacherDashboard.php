<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ClassModel;
use App\Models\AttendanceRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class TeacherDashboard extends Component
{
    public $selectedClass = null;
    public $selectedDate  = null;
    public $attendanceData = [];
    public $search = '';

    protected $listeners = ['attendanceUpdated' => '$refresh'];

    public function mount()
    {
        $this->selectedDate  = now()->format('Y-m-d');
        $this->attendanceData = [];
    }

    // ── Lifecycle hooks ──────────────────────────────────────────────────────────

    public function updatedSelectedClass()
    {
        $this->search = '';
        $this->attendanceData = [];
        $this->loadAttendanceForCurrentStudents();
    }

    public function updatedSelectedDate()
    {
        $this->attendanceData = [];
        $this->loadAttendanceForCurrentStudents();
    }

    public function updatedSearch()
    {
        $this->loadAttendanceForCurrentStudents();
    }

    // ── Helpers ──────────────────────────────────────────────────────────────────

    private function loadAttendanceForCurrentStudents(): void
    {
        if (! $this->selectedClass) {
            $this->attendanceData = [];
            return;
        }
        $this->loadAttendanceData($this->getFilteredStudents());
    }

    private function getFilteredStudents(): Collection
    {
        $class = ClassModel::find($this->selectedClass);
        if (! $class) return collect();

        return $class->students()
            ->where('students.is_active', true)
            ->when($this->search, fn($q) =>
                $q->where(fn($q2) =>
                    $q2->where('students.full_name', 'like', "%{$this->search}%")
                       ->orWhere('students.baptismal_name', 'like', "%{$this->search}%")
                       ->orWhere('students.phone_number', 'like', "%{$this->search}%")
                )
            )
            ->orderBy('full_name')
            ->get();
    }

    private function loadAttendanceData(Collection $students): void
    {
        $data = [];
        foreach ($students as $student) {
            $existing = $this->attendanceData[$student->id] ?? null;
            if ($existing) {
                $data[$student->id] = $existing;
                continue;
            }
            $record = $student->getAttendanceForDate($this->selectedDate);
            $data[$student->id] = [
                'status'         => $record?->status         ?? 'present',
                'check_in_time'  => $record?->check_in_time  ?? null,
                'check_out_time' => $record?->check_out_time ?? null,
                'notes'          => $record?->notes          ?? '',
            ];
        }
        $this->attendanceData = $data;
    }

    // ── Render ───────────────────────────────────────────────────────────────────

    public function render()
    {
        $teacher = Auth::guard('teacher')->user();

        $classes = ClassModel::where('teacher_id', $teacher->id)
            ->where('is_active', true)
            ->withCount('students')
            ->get();

        $students = collect();
        if ($this->selectedClass) {
            $students = $this->getFilteredStudents();
            if (empty($this->attendanceData)) {
                $this->loadAttendanceData($students);
            }
        }

        $recentAttendance = AttendanceRecord::where('teacher_id', $teacher->id)
            ->with('student')
            ->orderBy('attendance_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $stats = $this->getStatistics();

        return view('livewire.teacher-dashboard', compact('classes', 'students', 'recentAttendance', 'stats'));
    }

    // ── Actions ──────────────────────────────────────────────────────────────────

    public function markAttendance()
    {
        $teacher = Auth::guard('teacher')->user();

        foreach ($this->attendanceData as $studentId => $data) {
            AttendanceRecord::updateOrCreate(
                ['student_id' => $studentId, 'attendance_date' => $this->selectedDate, 'teacher_id' => $teacher->id],
                [
                    'status'          => $data['status'],
                    'check_in_time'   => $data['check_in_time']  ?? null,
                    'check_out_time'  => $data['check_out_time'] ?? null,
                    'notes'           => $data['notes']          ?? '',
                ]
            );
        }

        $this->dispatch('attendanceUpdated');
        $this->dispatch('notify', ['message' => 'Attendance saved successfully!', 'type' => 'success']);
    }

    public function exportReport()
    {
        $teacher = Auth::guard('teacher')->user();

        if (! $this->selectedClass || ! $this->selectedDate) {
            $this->dispatch('notify', ['message' => 'Please select a class and date first.', 'type' => 'error']);
            return;
        }

        try {
            $class    = ClassModel::find($this->selectedClass);
            $students = $class->students()
                ->where('students.is_active', true)
                ->with(['attendanceRecords' => fn($q) =>
                    $q->where('attendance_date', $this->selectedDate)->where('teacher_id', $teacher->id)
                ])
                ->orderBy('full_name')
                ->get();

            $rows = ['Full Name,Baptismal Name,Phone Number,Status,Check In,Check Out,Notes'];
            foreach ($students as $s) {
                $r = $s->attendanceRecords->first();
                $rows[] = implode(',', [
                    '"'.str_replace('"', '""', $s->full_name).'"',
                    '"'.str_replace('"', '""', $s->baptismal_name ?? '').'"',
                    $s->phone_number ?? '',
                    $r ? $r->status : 'Not Marked',
                    $r ? ($r->check_in_time  ?? '') : '',
                    $r ? ($r->check_out_time ?? '') : '',
                    '"'.str_replace('"', '""', $r?->notes ?? '').'"',
                ]);
            }

            $filename = 'attendance_'.preg_replace('/[^a-zA-Z0-9]/', '_', $class->name).'_'.date('Y-m-d', strtotime($this->selectedDate)).'.csv';
            session(['export_data' => implode("\n", $rows), 'export_filename' => $filename]);

            return redirect()->route('teacher.download.export');

        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Export failed: '.$e->getMessage(), 'type' => 'error']);
        }
    }

    // ── Computed ─────────────────────────────────────────────────────────────────

    public function getStatistics(): array
    {
        $stats = AttendanceRecord::where('teacher_id', Auth::guard('teacher')->id())
            ->where('attendance_date', now()->format('Y-m-d'))
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return [
            'present' => $stats['present'] ?? 0,
            'absent'  => $stats['absent']  ?? 0,
            'late'    => $stats['late']    ?? 0,
            'excused' => $stats['excused'] ?? 0,
        ];
    }
}