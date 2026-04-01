<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AttendanceRecord;
use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceReports extends Component
{
    use WithPagination;

    public $selectedClass = null;
    public $selectedStudent = null;
    public $startDate;
    public $endDate;
    public $reportType = 'summary';
    public $groupBy = 'daily';

    protected $listeners = ['refreshReports' => '$refresh'];

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $teacher = Auth::guard('teacher')->user();
        
        $classes = ClassModel::where('teacher_id', $teacher->id)
            ->where('is_active', true)
            ->get();

        $students = [];
        if ($this->selectedClass) {
            $students = ClassModel::find($this->selectedClass)
                ->students()
                ->where('is_active', true)
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get();
        }

        $reportData = $this->generateReport();

        return view('livewire.attendance-reports', compact('classes', 'students', 'reportData'));
    }

    private function generateReport()
    {
        $teacher = Auth::guard('teacher')->user();
        
        $query = AttendanceRecord::where('teacher_id', $teacher->id)
            ->whereBetween('attendance_date', [$this->startDate, $this->endDate]);

        if ($this->selectedClass) {
            $studentIds = ClassModel::find($this->selectedClass)
                ->students()
                ->pluck('students.id');
            $query->whereIn('student_id', $studentIds);
        }

        if ($this->selectedStudent) {
            $query->where('student_id', $this->selectedStudent);
        }

        switch ($this->reportType) {
            case 'summary':
                return $this->generateSummaryReport($query);
            case 'detailed':
                return $this->generateDetailedReport($query);
            case 'analytics':
                return $this->generateAnalyticsReport($query);
            default:
                return [];
        }
    }

    private function generateSummaryReport($query)
    {
        // Get total first in PHP to avoid correlated subquery issues with strict GROUP BY
        $total = (clone $query)->count();
        $uniqueStudents = (clone $query)->distinct('student_id')->count('student_id');

        $data = (clone $query)
            ->selectRaw('status, COUNT(*) as count, ROUND(COUNT(*) * 100.0 / ?, 2) as percentage', [$total ?: 1])
            ->groupBy('status')
            ->get();

        return [
            'summary'        => $data,
            'total_records'  => $total,
            'unique_students'=> $uniqueStudents,
            'date_range'     => [
                'start' => $this->startDate,
                'end'   => $this->endDate,
                'days'  => Carbon::parse($this->startDate)->diffInDays(Carbon::parse($this->endDate)) + 1,
            ],
        ];
    }

    private function generateDetailedReport($query)
    {
        return $query->with(['student', 'teacher'])
            ->orderBy('attendance_date', 'desc')
            ->orderBy('student_id')
            ->paginate(50);
    }

    private function generateAnalyticsReport($query)
    {
        $dailyStats = $query->selectRaw('
                attendance_date,
                status,
                COUNT(*) as count
            ')
            ->groupBy('attendance_date', 'status')
            ->orderBy('attendance_date')
            ->get()
            ->groupBy('attendance_date');

        $studentStats = $query->selectRaw('
                student_id,
                status,
                COUNT(*) as count
            ')
            ->with('student')
            ->groupBy('student_id', 'status')
            ->get()
            ->groupBy('student_id');

        $trends = [];
        foreach ($dailyStats as $date => $stats) {
            $trends[] = [
                'date' => $date,
                'present' => $stats->where('status', 'present')->sum('count'),
                'absent' => $stats->where('status', 'absent')->sum('count'),
                'late' => $stats->where('status', 'late')->sum('count'),
                'excused' => $stats->where('status', 'excused')->sum('count'),
            ];
        }

        return [
            'daily_trends' => $trends,
            'student_performance' => $studentStats,
        ];
    }

    public function exportReport()
    {
        // This would implement CSV/PDF export functionality
        session()->flash('message', 'Export functionality will be implemented soon!');
    }

    public function getAttendanceRate($studentId)
    {
        $total = AttendanceRecord::where('student_id', $studentId)
            ->whereBetween('attendance_date', [$this->startDate, $this->endDate])
            ->count();

        $present = AttendanceRecord::where('student_id', $studentId)
            ->whereBetween('attendance_date', [$this->startDate, $this->endDate])
            ->whereIn('status', ['present', 'late'])
            ->count();

        return $total > 0 ? round(($present / $total) * 100, 2) : 0;
    }
}
