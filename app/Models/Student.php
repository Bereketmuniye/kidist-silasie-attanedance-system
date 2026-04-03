<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'baptismal_name',
        'phone_number',
        'address',
        'common_confessor_father',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(ClassModel::class, 'class_student', 'student_id', 'class_id')
            ->withPivot('enrolled_at')
            ->withTimestamps();
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function getAttendanceForDate($date)
    {
        return $this->attendanceRecords()
            ->where('attendance_date', $date)
            ->first();
    }
}
