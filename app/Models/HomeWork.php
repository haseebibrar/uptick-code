<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class HomeWork extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'focusarea_id',
        'lesson_id',
        'name',
        'instructions_text'
    ];

    public function focusareas()
    {
        return $this->belongsTo(FocusArea::class);
    }

    public function lessonsubject()
    {
        return $this->belongsTo(LessonSubject::class);
    }

    public function homeworkdetails()
    {
        return $this->hasMany(HomeWorkDetail::class, 'homework_id')->orderBy('id');
    }

    public function homeworkstudents()
    {
        return $this->hasMany(HomeWorkDetailsStudent::class, 'homework_id')->orderBy('id');
    }
}
