<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Auth;

class ExamManagement extends Component
{
    use WithPagination;

    public $title;
    public $description;
    public $duration_minutes = 30;
    public $is_active = true;

    public $selectedExamId = null;
    public $showModal = false;
    public $isEditing = false;
    public $search = '';
    public $showQuestionsList = false;

    // Question management
    public $questions = [];
    public $question;
    public $option_a;
    public $option_b;
    public $option_c;
    public $option_d;
    public $correct_answer = 'A';
    public $points = 1;
    public $selectedQuestionId = null;
    public $showQuestionModal = false;
    public $isEditingQuestion = false;

    public function render()
    {
        $query = Exam::query();

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        $exams = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.exam-management', compact('exams'));
    }

    public function createExam()
    {
        $this->resetExamFields();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function editExam($id)
    {
        $exam = Exam::findOrFail($id);

        $this->selectedExamId = $id;
        $this->title = $exam->title;
        $this->description = $exam->description;
        $this->duration_minutes = $exam->duration_minutes;
        $this->is_active = (bool) $exam->is_active;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveExam()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:5|max:180',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'duration_minutes' => $this->duration_minutes,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditing) {
            Exam::findOrFail($this->selectedExamId)->update($data);
            $this->dispatch('notify', ['message' => 'ፈተና ተሻሽለፋል!', 'type' => 'success']);
        } else {
            Exam::create($data);
            $this->dispatch('notify', ['message' => 'ፈተና ተፈጠረ!', 'type' => 'success']);
        }

        $this->showModal = false;
        $this->resetExamFields();
    }

    public function deleteExam($id)
    {
        $exam = Exam::findOrFail($id);
        
        // Check if exam has results
        if ($exam->results()->count() > 0) {
            $this->dispatch('notify', ['message' => 'ይህ ፈተና ውጤቶች አሉት! መሰረዝ አይችልም!', 'type' => 'error']);
            return;
        }

        $exam->delete();
        $this->dispatch('notify', ['message' => 'ፈተና ተሰረዘ!', 'type' => 'success']);
    }

    public function toggleExamStatus($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->is_active = !$exam->is_active;
        $exam->save();
        $this->dispatch('notify', ['message' => 'ሁኔታው ተሻሻለ!', 'type' => 'success']);
    }

    // Question Management
    public function manageQuestions($examId)
    {
        $this->selectedExamId = $examId;
        $exam = Exam::findOrFail($examId);
        $this->questions = $exam->questions()->get();
        $this->showQuestionsList = true;
    }

    public function addQuestion()
    {
        $this->resetQuestionFields();
        $this->isEditingQuestion = false;
        $this->showQuestionModal = true;
    }

    public function editQuestion($index)
    {
        $question = $this->questions[$index];
        $this->selectedQuestionId = $question['id'];
        $this->question = $question['question'];
        $this->option_a = $question['option_a'];
        $this->option_b = $question['option_b'];
        $this->option_c = $question['option_c'];
        $this->option_d = $question['option_d'];
        $this->correct_answer = $question['correct_answer'];
        $this->points = $question['points'];
        $this->isEditingQuestion = true;
        $this->showQuestionModal = true;
    }

    public function saveQuestion()
    {
        $this->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
            'points' => 'required|integer|min:1|max:10',
        ]);

        $data = [
            'exam_id' => $this->selectedExamId,
            'question' => $this->question,
            'option_a' => $this->option_a,
            'option_b' => $this->option_b,
            'option_c' => $this->option_c,
            'option_d' => $this->option_d,
            'correct_answer' => $this->correct_answer,
            'points' => $this->points,
        ];

        if ($this->isEditingQuestion) {
            ExamQuestion::findOrFail($this->selectedQuestionId)->update($data);
            $this->dispatch('notify', ['message' => 'ጥያቄ ተሻሽለፋል!', 'type' => 'success']);
        } else {
            ExamQuestion::create($data);
            $this->dispatch('notify', ['message' => 'ጥያቄ ተጨምረፋል!', 'type' => 'success']);
        }

        $this->showQuestionModal = false;
        $this->resetQuestionFields();
        $this->manageQuestions($this->selectedExamId); // Refresh questions
    }

    public function deleteQuestion($index)
    {
        $question = $this->questions[$index];
        ExamQuestion::findOrFail($question['id'])->delete();
        $this->dispatch('notify', ['message' => 'ጥያቄ ተሰረዘ!', 'type' => 'success']);
        $this->manageQuestions($this->selectedExamId); // Refresh questions
    }

    public function viewResults($examId)
    {
        // This will be implemented to show exam results
        $this->dispatch('showResults', ['examId' => $examId]);
    }

    private function resetExamFields()
    {
        $this->reset([
            'title', 'description', 'duration_minutes', 'selectedExamId', 'isEditing',
        ]);
        $this->is_active = true;
        $this->duration_minutes = 30;
    }

    private function resetQuestionFields()
    {
        $this->reset([
            'question', 'option_a', 'option_b', 'option_c', 'option_d',
            'correct_answer', 'points', 'selectedQuestionId', 'isEditingQuestion',
        ]);
        $this->correct_answer = 'A';
        $this->points = 1;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetExamFields();
    }

    public function closeQuestionModal()
    {
        $this->showQuestionModal = false;
        $this->resetQuestionFields();
    }

    public function closeQuestionsList()
    {
        $this->showQuestionsList = false;
    }
}
