<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class FocusAreaTeacher extends Authenticatable
{
    use Notifiable;

    protected $guard = 'teacher';

    protected $fillable = [
        'focusarea_id',
        'teacher_id',
        'lesson_id',
        'embeded_url',
    ];

    public function lessonsubject()
    {
        return $this->belongsTo(LessonSubject::class);
    }

    public function focusareateachers()
    {
        return $this->belongsTo(FocusArea::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
