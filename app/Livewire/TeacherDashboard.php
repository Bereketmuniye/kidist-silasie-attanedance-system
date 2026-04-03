<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\AttendanceRecord;
use App\Services\ToasterService;
use Illuminate\Support\Facades\Auth;

class TeacherDashboard extends Component
{
    use WithPagination;

    public $selectedClass = null;
    public $selectedDate = null;
    public $attendanceData = [];
    public $search = '';
    public $showAttendanceForm = false;

    protected $listeners = ['attendanceUpdated' => '$refresh'];

    public function mount()
    {
        $this->selectedDate = now()->format('Y-m-d');
        $this->attendanceData = [];
    }

    public function render()
    {
        $teacher = Auth::guard('teacher')->user();
        
        $classes = ClassModel::where('teacher_id', $teacher->id)
            ->where('is_active', true)
            ->withCount('students')
            ->get();

        $students = [];
        if ($this->selectedClass) {
            $class = ClassModel::find($this->selectedClass);
            $students = $class->students()
                ->where('is_active', true)
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('students.full_name', 'like', '%' . $this->search . '%')
                          ->orWhere('students.baptismal_name', 'like', '%' . $this->search . '%')
                          ->orWhere('students.phone_number', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy('full_name')
                ->get();

            $this->loadAttendanceData($students);
        }

        $recentAttendance = AttendanceRecord::where('teacher_id', $teacher->id)
            ->with('student')
            ->orderBy('attendance_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('livewire.teacher-dashboard', compact('classes', 'students', 'recentAttendance'));
    }

    private function loadAttendanceData($students)
    {
        $this->attendanceData = [];
        
        foreach ($students as $student) {
            $attendance = $student->getAttendanceForDate($this->selectedDate);
            $this->attendanceData[$student->id] = [
                'status' => $attendance ? $attendance->status : 'present',
            ];
        }
    }

    public function markAttendance()
    {
        $teacher = Auth::guard('teacher')->user();
        
        foreach ($this->attendanceData as $studentId => $data) {
            // First, try to find existing record
            $attendance = AttendanceRecord::where('student_id', $studentId)
                ->where('attendance_date', $this->selectedDate)
                ->where('teacher_id', $teacher->id)
                ->first();
            
            if ($attendance) {
                // Update existing record
                $attendance->update([
                    'status' => $data['status'],
                ]);
            } else {
                // Create new record
                AttendanceRecord::create([
                    'student_id' => $studentId,
                    'attendance_date' => $this->selectedDate,
                    'teacher_id' => $teacher->id,
                    'status' => $data['status'],
                ]);
            }
        }

        $this->dispatch('attendanceUpdated');
        $this->dispatch('notify', ['message' => 'Attendance marked successfully!', 'type' => 'success']);
    }

    public function exportReport()
    {
        try {
            $teacher = Auth::guard('teacher')->user();
            
            // Validate inputs
            if (!$this->selectedClass || !$this->selectedDate) {
                $this->dispatch('notify', ['message' => 'Please select a class and date first', 'type' => 'error']);
                return;
            }
            
            // Get attendance data
            $class = ClassModel::find($this->selectedClass);
            $students = $class->students()
                ->where('is_active', true)
                ->with(['attendanceRecords' => function($query) use ($teacher) {
                    $query->where('attendance_date', $this->selectedDate)
                          ->where('teacher_id', $teacher->id);
                }])
                ->orderBy('full_name')
                ->get();
            
            // Prepare CSV data
            $csvLines = [];
            $csvLines[] = 'Full Name,Baptismal Name,Phone Number,Status';
            
            foreach ($students as $student) {
                $attendance = $student->attendanceRecords->first();
                $csvLines[] = implode(',', [
                    $student->full_name,
                    $student->baptismal_name,
                    $student->phone_number,
                    $attendance ? $attendance->status : 'Not Marked'
                ]);
            }
            
            // Generate filename
            $className = preg_replace('/[^a-zA-Z0-9]/', '_', $class->name);
            $dateStr = date('Y-m-d', strtotime($this->selectedDate));
            $filename = "attendance_{$className}_{$dateStr}.csv";
            
            // Create CSV content
            $csvContent = implode("\n", $csvLines);
            
            // Store CSV in session for download
            session(['export_data' => $csvContent, 'export_filename' => $filename]);
            
            // Redirect to download route
            return redirect()->route('teacher.download.export');
            
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Export failed: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function getStatistics()
    {
        $teacher = Auth::guard('teacher')->user();
        
        $today = now()->format('Y-m-d');
        $todayStats = AttendanceRecord::where('teacher_id', $teacher->id)
            ->where('attendance_date', $today)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return [
            'present' => $todayStats['present'] ?? 0,
            'absent' => $todayStats['absent'] ?? 0,
            'late' => $todayStats['late'] ?? 0,
            'excused' => $todayStats['excused'] ?? 0,
        ];
    }
}
