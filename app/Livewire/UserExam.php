<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamResult;
use App\Models\ExamAnswer;
use Carbon\Carbon;

class UserExam extends Component
{
    public $examId;
    public $exam;
    public $questions;
    public $currentQuestionIndex = 0;
    public $answers = [];
    public $timeRemaining;
    public $examStarted = false;
    public $examCompleted = false;
    public $studentName;
    public $studentPhone;
    public $examResult;
    public $showResult = false;

    protected $listeners = ['timerExpired'];

    public function mount($examId = null)
    {
        if ($examId) {
            $this->examId = $examId;
            $this->loadExam();
        }
    }

    public function loadExam()
    {
        try {
            $this->exam = Exam::with('questions')->findOrFail($this->examId);
            
            if (!$this->exam->is_active) {
                $this->dispatch('notify', ['message' => 'ይህ ፈተና ንቁ አይደለም!', 'type' => 'error']);
                return;
            }

            if ($this->exam->questions->count() === 0) {
                $this->dispatch('notify', ['message' => 'ይህ ፈተና ጥያቄዎች የሉትም!', 'type' => 'error']);
                return;
            }

            $this->questions = $this->exam->questions->shuffle();
            $this->resetExam();
            
            // Debug: Log question count
            \Log::info('Loaded exam: ' . $this->exam->title . ' with ' . $this->questions->count() . ' questions');
            
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'ፈተናውን መመለስ አልተቻለህ: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function resetExam()
    {
        $this->currentQuestionIndex = 0;
        $this->answers = [];
        $this->timeRemaining = $this->exam->duration_minutes * 60;
        $this->examStarted = false;
        $this->examCompleted = false;
        $this->studentName = '';
        $this->studentPhone = '';
        $this->examResult = null;
        $this->showResult = false;
    }

    public function startExam()
    {
        $this->validate([
            'studentName' => 'required|string|max:255',
            'studentPhone' => 'required|string|regex:/^[0-9]{10,15}$/',
        ], [
            'studentName.required' => 'ስምዎን መሙላት ግዴታ ነው!',
            'studentPhone.required' => 'ስልክ ቁጥር መሙላት ግዴታ ነው!',
            'studentPhone.regex' => 'ስልክ ቁጥር ትክር ቁጥር መሆኑ ነው!',
        ]);

        // Check if phone number already took this exam
        $existingResult = ExamResult::where('exam_id', $this->examId)
            ->where('student_phone', $this->studentPhone)
            ->first();

        if ($existingResult) {
            $this->dispatch('notify', [
                'message' => 'ይህ ስልክ ቁጥር ይህ ፈተናውን አልተገልዋል! ውጤትዎ: ' . $existingResult->percentage . '%',
                'type' => 'error'
            ]);
            return;
        }

        $this->examStarted = true;
        
        // Create exam result record
        $this->examResult = ExamResult::create([
            'exam_id' => $this->examId,
            'student_name' => $this->studentName,
            'student_phone' => $this->studentPhone,
            'total_questions' => $this->questions->count(),
            'correct_answers' => 0,
            'score' => 0,
            'started_at' => now(),
        ]);

        // Start timer
        $this->dispatch('startTimer', ['duration' => $this->timeRemaining]);
    }

    public function selectAnswer($answer)
    {
        $this->answers[$this->currentQuestionIndex] = $answer;
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < $this->questions->count() - 1) {
            $this->currentQuestionIndex++;
        } else {
            $this->submitExam();
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
        }
    }

    public function submitExam()
    {
        if (!$this->examStarted) {
            return;
        }

        $correctAnswers = 0;
        $totalScore = 0;

        foreach ($this->questions as $index => $question) {
            $selectedAnswer = $this->answers[$index] ?? null;
            $isCorrect = $selectedAnswer === $question->correct_answer;
            
            if ($isCorrect) {
                $correctAnswers++;
                $totalScore += $question->points;
            }

            // Save answer
            ExamAnswer::create([
                'exam_result_id' => $this->examResult->id,
                'exam_question_id' => $question->id,
                'selected_answer' => $selectedAnswer,
                'is_correct' => $isCorrect,
            ]);
        }

        // Update exam result
        $this->examResult->update([
            'correct_answers' => $correctAnswers,
            'score' => $totalScore,
            'completed_at' => now(),
        ]);

        $this->examCompleted = true;
        $this->showResult = true;
        $this->dispatch('stopTimer');
    }

    public function timerExpired()
    {
        if ($this->examStarted && !$this->examCompleted) {
            $this->submitExam();
        }
    }

    public function getProgressProperty()
    {
        if ($this->questions->count() === 0) return 0;
        return (($this->currentQuestionIndex + 1) / $this->questions->count()) * 100;
    }

    public function getAnsweredCountProperty()
    {
        return count(array_filter($this->answers, function($answer) {
            return $answer !== null;
        }));
    }

    public function formatTime($seconds)
    {
        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function retakeExam()
    {
        $this->resetExam();
    }

    public function backToExams()
    {
        return redirect()->route('exams.list');
    }

    public function render()
    {
        return view('livewire.user-exam');
    }
}
