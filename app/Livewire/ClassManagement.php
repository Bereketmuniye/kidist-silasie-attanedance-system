<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ClassModel;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class ClassManagement extends Component
{
    use WithPagination;

    public $name;
    public $code;
    public $description;
    public $teacher_id;
    public $schedule;
    public $room;
    public $is_active = true;
    public $selected_students = [];
    public $selectAll = false;

    public $selectedClassId = null;
    public $showModal = false;
    public $isEditing = false;
    public $search = '';

    protected $listeners = ['classUpdated' => '$refresh'];

    public function render()
    {
        $teacher = Auth::guard('teacher')->user();
        
        $query = ClassModel::with(['teacher', 'students' => function($query) {
            $query->where('is_active', true);
        }]);

        // If not admin, only show classes for the current teacher
        if (!$teacher->is_admin) {
            $query->where('teacher_id', $teacher->id);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('code', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $classes = $query->orderBy('name')->paginate(10);
        $teachers = Teacher::where('is_active', true)->get();
        $students = Student::where('is_active', true)->orderBy('full_name')->get();

        return view('livewire.class-management', compact('classes', 'teachers', 'students'));
    }

    public function createClass()
    {
        $this->resetFields();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function editClass($id)
    {
        $class = ClassModel::findOrFail($id);

        $this->selectedClassId = $id;
        $this->name = $class->name;
        $this->code = $class->code;
        $this->description = $class->description;
        $this->teacher_id = $class->teacher_id;
        $this->schedule = $class->schedule;
        $this->room = $class->room;
        $this->is_active = (bool) $class->is_active;
        $this->selected_students = $class->students()->pluck('student_id')->toArray();
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveClass()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:classes,code,' . $this->selectedClassId,
            'description' => 'nullable|string|max:1000',
            'teacher_id' => 'required|exists:teachers,id',
            'schedule' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'selected_students' => 'nullable|array',
            'selected_students.*' => 'exists:students,id',
        ]);

        $data = [
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'teacher_id' => $this->teacher_id,
            'schedule' => $this->schedule,
            'room' => $this->room,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditing) {
            $class = ClassModel::findOrFail($this->selectedClassId);
            $class->update($data);
            
            // Sync student assignments
            $class->students()->sync($this->selected_students ?? []);
            
            $this->dispatch('notify', ['message' => 'Class updated successfully!', 'type' => 'success']);
        } else {
            $class = ClassModel::create($data);
            
            // Attach selected students
            if (!empty($this->selected_students)) {
                $class->students()->attach($this->selected_students, ['enrolled_at' => now()]);
            }
            
            $this->dispatch('notify', ['message' => 'Class created successfully!', 'type' => 'success']);
        }

        $this->showModal = false;
        $this->resetFields();
        $this->dispatch('classUpdated');
    }

    public function deleteClass($id)
    {
        $class = ClassModel::findOrFail($id);
        
        // Check if class has students
        if ($class->students()->count() > 0) {
            $this->dispatch('notify', ['message' => 'Cannot delete class with enrolled students!', 'type' => 'error']);
            return;
        }
        
        $class->delete();
        $this->dispatch('notify', ['message' => 'Class deleted successfully!', 'type' => 'success']);
        $this->dispatch('classUpdated');
    }

    public function toggleClassStatus($id)
    {
        $class = ClassModel::findOrFail($id);
        $class->is_active = !$class->is_active;
        $class->save();
        $this->dispatch('notify', ['message' => 'Class status updated successfully!', 'type' => 'success']);
        $this->dispatch('classUpdated');
    }

    private function resetFields()
    {
        $this->reset([
            'name', 'code', 'description', 'teacher_id', 'schedule', 'room',
            'selected_students', 'selectAll', 'selectedClassId', 'isEditing',
        ]);
        $this->is_active = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetFields();
    }

    public function toggleSelectAll()
    {
        $students = Student::where('is_active', true)->pluck('id')->toArray();
        
        if ($this->selectAll) {
            $this->selected_students = $students;
        } else {
            $this->selected_students = [];
        }
    }

    public function updatedSelectedStudents()
    {
        $students = Student::where('is_active', true)->pluck('id')->toArray();
        $this->selectAll = count($this->selected_students) === count($students);
    }
}
