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
                        $q->where('students.first_name', 'like', '%' . $this->search . '%')
                          ->orWhere('students.last_name', 'like', '%' . $this->search . '%')
                          ->orWhere('students.student_id', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy('last_name')
                ->orderBy('first_name')
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
                'check_in_time' => $attendance ? $attendance->check_in_time : null,
                'check_out_time' => $attendance ? $attendance->check_out_time : null,
                'notes' => $attendance ? $attendance->notes : '',
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
                    'check_in_time' => $data['check_in_time'],
                    'check_out_time' => $data['check_out_time'],
                    'notes' => $data['notes'],
                ]);
            } else {
                // Create new record
                AttendanceRecord::create([
                    'student_id' => $studentId,
                    'attendance_date' => $this->selectedDate,
                    'teacher_id' => $teacher->id,
                    'status' => $data['status'],
                    'check_in_time' => $data['check_in_time'],
                    'check_out_time' => $data['check_out_time'],
                    'notes' => $data['notes'],
                ]);
            }
        }

        $this->dispatch('attendanceUpdated');
        $this->dispatch('notify', ['message' => 'Attendance marked successfully!', 'type' => 'success']);
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
