<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = [
        'exam_id',
        'student_name',
        'student_phone',
        'total_questions',
        'correct_answers',
        'score',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers()
    {
        return $this->hasMany(ExamAnswer::class);
    }

    public function getPercentageAttribute()
    {
        if ($this->total_questions == 0) return 0;
        return round(($this->correct_answers / $this->total_questions) * 100, 2);
    }
}
