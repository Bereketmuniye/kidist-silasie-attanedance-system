<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Student;
use App\Models\ClassModel;
use App\Services\ToasterService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StudentManagement extends Component
{
    use WithPagination;

    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $student_id;
    public $grade;
    public $section;
    public $date_of_birth;
    public $address;
    public $is_active = true;

    public $selectedStudentId = null;  // store ID only, not the model
    public $showModal = false;
    public $isEditing = false;
    public $search = '';
    public $filterGrade = '';
    public $filterSection = '';

    public function render()
    {
        $query = Student::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('last_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('student_id', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterGrade) {
            $query->where('grade', $this->filterGrade);
        }

        if ($this->filterSection) {
            $query->where('section', $this->filterSection);
        }

        $students = $query->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(15);

        $grades   = Student::distinct()->pluck('grade')->filter()->sort();
        $sections = Student::distinct()->pluck('section')->filter()->sort();

        return view('livewire.student-management', compact('students', 'grades', 'sections'));
    }

    public function createStudent()
    {
        $this->resetFields();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function editStudent($id)
    {
        $student = Student::findOrFail($id);

        $this->selectedStudentId = $id;
        $this->first_name        = $student->first_name;
        $this->last_name         = $student->last_name;
        $this->email             = $student->email;
        $this->phone             = $student->phone;
        $this->student_id        = $student->student_id;
        $this->grade             = $student->grade;
        $this->section           = $student->section;
        $this->date_of_birth     = $student->date_of_birth
            ? Carbon::parse($student->date_of_birth)->format('Y-m-d')
            : null;
        $this->address           = $student->address;
        $this->is_active         = (bool) $student->is_active;
        $this->isEditing         = true;
        $this->showModal         = true;
    }

    public function saveStudent()
    {
        // Build rules before validating so unique ignores work on edit
        $ignoreId = $this->isEditing ? ',' . $this->selectedStudentId : '';

        $this->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:students,email' . $ignoreId,
            'phone'         => 'nullable|string|max:20',
            'student_id'    => 'required|string|unique:students,student_id' . $ignoreId,
            'grade'         => 'nullable|string|max:50',
            'section'       => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
            'address'       => 'nullable|string|max:500',
            'is_active'     => 'boolean',
        ]);

        $data = [
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'student_id'    => $this->student_id,
            'grade'         => $this->grade,
            'section'       => $this->section,
            'date_of_birth' => $this->date_of_birth ?: null,
            'address'       => $this->address,
            'is_active'     => $this->is_active,
        ];

        if ($this->isEditing) {
            Student::findOrFail($this->selectedStudentId)->update($data);
            $this->dispatch('notify', ['message' => 'Student updated successfully!', 'type' => 'success']);
        } else {
            Student::create($data);
            $this->dispatch('notify', ['message' => 'Student created successfully!', 'type' => 'success']);
        }

        $this->showModal = false;
        $this->resetFields();
    }

    public function deleteStudent($id)
    {
        Student::findOrFail($id)->delete();
        $this->dispatch('notify', ['message' => 'Student deleted successfully!', 'type' => 'success']);
    }

    public function toggleStudentStatus($id)
    {
        $student = Student::findOrFail($id);
        $student->is_active = !$student->is_active;
        $student->save();
        $this->dispatch('notify', ['message' => 'Student status updated successfully!', 'type' => 'success']);
    }

    private function resetFields()
    {
        $this->reset([
            'first_name', 'last_name', 'email', 'phone', 'student_id',
            'grade', 'section', 'date_of_birth', 'address',
            'selectedStudentId', 'isEditing',
        ]);
        $this->is_active = true; // keep default as active for new students
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetFields();
    }
}
