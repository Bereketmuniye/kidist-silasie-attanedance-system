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

    public $full_name;
    public $baptismal_name;
    public $phone_number;
    public $address;
    public $common_confessor_father;
    public $is_active = true;

    public $selectedStudentId = null;  // store ID only, not the model
    public $showModal = false;
    public $isEditing = false;
    public $search = '';

    public function render()
    {
        $query = Student::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('full_name', 'like', '%' . $this->search . '%')
                  ->orWhere('baptismal_name', 'like', '%' . $this->search . '%')
                  ->orWhere('phone_number', 'like', '%' . $this->search . '%')
                  ->orWhere('common_confessor_father', 'like', '%' . $this->search . '%');
            });
        }

        $students = $query->orderBy('full_name')->paginate(15);

        return view('livewire.student-management', compact('students'));
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
        $this->full_name = $student->full_name;
        $this->baptismal_name = $student->baptismal_name;
        $this->phone_number = $student->phone_number;
        $this->address = $student->address;
        $this->common_confessor_father = $student->common_confessor_father;
        $this->is_active = (bool) $student->is_active;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveStudent()
    {
        // Build rules before validating so unique ignores work on edit
        $ignoreId = $this->isEditing ? ',' . $this->selectedStudentId : '';

        $this->validate([
            'full_name' => 'required|string|max:255',
            'baptismal_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'common_confessor_father' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = [
            'full_name' => $this->full_name,
            'baptismal_name' => $this->baptismal_name,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'common_confessor_father' => $this->common_confessor_father,
            'is_active' => $this->is_active,
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
            'full_name', 'baptismal_name', 'phone_number', 'address',
            'common_confessor_father', 'selectedStudentId', 'isEditing',
        ]);
        $this->is_active = true; // keep default as active for new students
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetFields();
    }
}
