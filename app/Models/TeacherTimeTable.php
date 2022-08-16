<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TeacherTimeTable extends Authenticatable
{
    use Notifiable;

    protected $guard = 'teacher';

    protected $fillable = [
        'teacher_id',
        'availableday',
        'availabletime',
    ];

    public function teacher_data()
    {
        return $this->belongsTo(Teacher::class);
    }
}
