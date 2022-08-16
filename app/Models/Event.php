<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Event extends Authenticatable
{
    use Notifiable;

    protected $guard = 'web';

    protected $fillable = [
        'focusarea_id',
        'teacher_id',
        'lesson_id',
        'student_id',
        'title',
        'start',
        'end',
        'class_name',
        'zoom_link',
        'status',
        'file_downloaded',
        'file_sec_down',
        'teacher_complete',
        'teacher_cancel',
        'lesson_url',
        'kajabi_url',
        'lesson_review',
        'lesson_rating',
    ];

    public function event()
    {
        return $this->belongsTo(User::class);
    }
}
