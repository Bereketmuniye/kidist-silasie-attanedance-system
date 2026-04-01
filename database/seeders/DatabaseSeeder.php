<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create sample teachers
        $teacher1 = Teacher::create([
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'john.smith@school.edu',
            'phone' => '+1-555-0123',
            'employee_id' => 'T001',
            'department' => 'Mathematics',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        $teacher2 = Teacher::create([
            'first_name' => 'Sarah',
            'last_name' => 'Johnson',
            'email' => 'sarah.johnson@school.edu',
            'phone' => '+1-555-0124',
            'employee_id' => 'T002',
            'department' => 'Science',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        // Create sample students
        $students = [
            ['Alice', 'Williams', 'S001', '10A'],
            ['Bob', 'Brown', 'S002', '10A'],
            ['Charlie', 'Davis', 'S003', '10B'],
            ['Diana', 'Miller', 'S004', '10B'],
            ['Edward', 'Wilson', 'S005', '11A'],
            ['Fiona', 'Moore', 'S006', '11A'],
            ['George', 'Taylor', 'S007', '11B'],
            ['Hannah', 'Anderson', 'S008', '11B'],
            ['Ian', 'Thomas', 'S009', '12A'],
            ['Julia', 'Jackson', 'S010', '12A'],
        ];

        $createdStudents = [];
        foreach ($students as [$firstName, $lastName, $studentId, $grade]) {
            $student = Student::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => strtolower($firstName . '.' . $lastName) . '@student.school.edu',
                'phone' => '+1-555-' . str_pad(substr($studentId, 1), 4, '0', STR_PAD_LEFT),
                'student_id' => $studentId,
                'grade' => substr($grade, 0, 2),
                'section' => substr($grade, 2),
                'date_of_birth' => now()->subYears(rand(15, 18))->format('Y-m-d'),
                'address' => rand(100, 999) . ' School Street, Education City',
                'is_active' => true,
            ]);
            $createdStudents[] = $student;
        }

        // Create sample classes
        $class1 = ClassModel::create([
            'name' => 'Advanced Mathematics',
            'code' => 'MATH301',
            'description' => 'Advanced mathematical concepts and problem solving',
            'teacher_id' => $teacher1->id,
            'schedule' => 'Mon, Wed, Fri - 9:00 AM',
            'room' => 'Room 101',
            'is_active' => true,
        ]);

        $class2 = ClassModel::create([
            'name' => 'Physics Fundamentals',
            'code' => 'PHYS201',
            'description' => 'Introduction to physics principles',
            'teacher_id' => $teacher2->id,
            'schedule' => 'Tue, Thu - 10:30 AM',
            'room' => 'Room 205',
            'is_active' => true,
        ]);

        // Enroll students in classes
        // First 6 students in Math class
        for ($i = 0; $i < 6; $i++) {
            $class1->students()->attach($createdStudents[$i]->id, [
                'enrolled_at' => now()->subMonths(3),
            ]);
        }

        // Last 6 students in Physics class
        for ($i = 4; $i < 10; $i++) {
            $class2->students()->attach($createdStudents[$i]->id, [
                'enrolled_at' => now()->subMonths(3),
            ]);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Teacher login: john.smith@school.edu / password');
        $this->command->info('Teacher login: sarah.johnson@school.edu / password');
    }
}
