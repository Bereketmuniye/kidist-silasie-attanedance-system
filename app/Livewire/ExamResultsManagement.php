<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ExamResult;
use App\Models\Exam;
use App\Models\ExamAnswer;

class ExamResultsManagement extends Component
{
    use WithPagination;

    public $selectedExamId = null;
    public $search = '';
    public $showDetails = false;
    public $selectedResult = null;
    public $examFilter = 'all'; // all, passed, failed

    public function render()
    {
        $query = ExamResult::with(['exam', 'answers.question'])
            ->when($this->selectedExamId, function ($query) {
                return $query->where('exam_id', $this->selectedExamId);
            })
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('student_name', 'like', '%' . $this->search . '%')
                      ->orWhere('student_phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->examFilter !== 'all', function ($query) {
                if ($this->examFilter === 'passed') {
                    return $query->whereRaw('(correct_answers * 100 / total_questions) >= 60');
                } elseif ($this->examFilter === 'failed') {
                    return $query->whereRaw('(correct_answers * 100 / total_questions) < 60');
                }
            })
            ->orderBy('completed_at', 'desc');

        $results = $query->paginate(15);
        $exams = Exam::orderBy('title')->get();

        return view('livewire.exam-results-management', compact('results', 'exams'));
    }

    public function viewDetails($resultId)
    {
        $this->selectedResult = ExamResult::with(['exam', 'answers.question'])->findOrFail($resultId);
        $this->showDetails = true;
    }

    public function closeDetails()
    {
        $this->showDetails = false;
        $this->selectedResult = null;
    }

    public function deleteResult($resultId)
    {
        $result = ExamResult::findOrFail($resultId);
        $result->delete();
        $this->dispatch('notify', ['message' => 'ውጤት ተሰረዘ!', 'type' => 'success']);
    }

    public function exportResults()
    {
        // This would generate a CSV or Excel export
        // For now, just show a message
        $this->dispatch('notify', ['message' => 'ኤውግት በማርጣ እዚልል!', 'type' => 'info']);
    }

    public function getStatistics()
    {
        $query = ExamResult::query();
        
        if ($this->selectedExamId) {
            $query->where('exam_id', $this->selectedExamId);
        }

        $total = $query->count();
        $passed = $query->whereRaw('(correct_answers * 100 / total_questions) >= 60')->count();
        $failed = $total - $passed;
        
        // Calculate average manually
        $results = $query->get();
        $average = $results->avg(function ($result) {
            return ($result->correct_answers / $result->total_questions) * 100;
        });

        return [
            'total' => $total,
            'passed' => $passed,
            'failed' => $failed,
            'average' => round($average, 2)
        ];
    }

    public function getExamStatistics($examId)
    {
        $query = ExamResult::where('exam_id', $examId);
        
        $total = $query->count();
        $passed = $query->whereRaw('(correct_answers * 100 / total_questions) >= 60')->count();
        $failed = $total - $passed;
        
        // Calculate average manually
        $results = $query->get();
        $average = $results->avg(function ($result) {
            return ($result->correct_answers / $result->total_questions) * 100;
        });

        return [
            'total' => $total,
            'passed' => $passed,
            'failed' => $failed,
            'average' => round($average, 2)
        ];
    }
}
