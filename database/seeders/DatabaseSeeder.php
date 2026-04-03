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

        // Create sample students with Ethiopian names
        $students = [
            [
                'full_name' => 'Abebe Kebede',
                'baptismal_name' => 'Michael',
                'phone_number' => '+251 911 234 567',
                'address' => 'Bole, Addis Ababa, Ethiopia',
                'common_confessor_father' => 'Father Samuel',
            ],
            [
                'full_name' => 'Tigist Haile',
                'baptismal_name' => 'Hanna',
                'phone_number' => '+251 922 345 678',
                'address' => 'Kirkos, Addis Ababa, Ethiopia',
                'common_confessor_father' => 'Father Teklehaimanot',
            ],
            [
                'full_name' => 'Dawit Yohannes',
                'baptismal_name' => 'Gabriel',
                'phone_number' => '+251 933 456 789',
                'address' => 'Mekane Yesus, Addis Ababa, Ethiopia',
                'common_confessor_father' => 'Father Yohannes',
            ],
            [
                'full_name' => 'Marta Tesfaye',
                'baptismal_name' => 'Mariam',
                'phone_number' => '+251 944 567 890',
                'address' => 'Piassa, Addis Ababa, Ethiopia',
                'common_confessor_father' => 'Father Petros',
            ],
            [
                'full_name' => 'Kaleb Mengistu',
                'baptismal_name' => 'Paulos',
                'phone_number' => '+251 955 678 901',
                'address' => 'Kazanchis, Addis Ababa, Ethiopia',
                'common_confessor_father' => 'Father Markos',
            ],
            [
                'full_name' => 'Sena Alemu',
                'baptismal_name' => 'Elizabeth',
                'phone_number' => '+251 966 789 012',
                'address' => 'Saris, Addis Ababa, Ethiopia',
                'common_confessor_father' => 'Father Girma',
            ],
            [
                'full_name' => 'Bekele Tadesse',
                'baptismal_name' => 'Yohannes',
                'phone_number' => '+251 977 890 123',
                'address' => 'CMC, Addis Ababa, Ethiopia',
                'common_confessor_father' => 'Father Berhanu',
            ],
            [
                'full_name' => 'Almaz Wondimu',
                'baptismal_name' => 'Sofia',
                'phone_number' => '+251 988 901 234',
                'address' => 'Megenagna, Addis Ababa, Ethiopia',
                'common_confessor_father' => 'Father Tewodros',
            ],
            [
                'full_name' => 'Solomon Tadesse',
                'baptismal_name' => 'David',
                'phone_number' => '+251 999 012 345',
                'address' => 'Hayahulet, Addis Ababa, Ethiopia',
                'common_confessor_father' => 'Father Melaku',
            ],
            [
                'full_name' => 'Hanna Getachew',
                'baptismal_name' => 'Ruth',
                'phone_number' => '+251 910 123 456',
                'address' => 'Lideta, Addis Ababa, Ethiopia',
                'common_confessor_father' => 'Father Habte',
            ],
        ];

        $createdStudents = [];
        foreach ($students as $studentData) {
            $student = Student::create(array_merge($studentData, ['is_active' => true]));
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
