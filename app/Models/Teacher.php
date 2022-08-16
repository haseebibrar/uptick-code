<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use Notifiable;

    protected $guard = 'teacher';

    protected $fillable = [
        'name', 'email', 'password', 'image', 'expertise', 'phone', 'zoom_link',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function timetable()
    {
        return $this->hasMany(TeacherTimeTable::class, 'teacher_id')->orderBy('id');
    }

    public function teachers()
    {
        return $this->hasMany(FocusAreaTeacher::class, 'teacher_id');
    }
}