<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class HomeWorkDetailsStudent extends Authenticatable
{
    use Notifiable;

    protected $guard = 'web';

    protected $fillable = [
        'homework_id',
        'student_id',
        'question_id',
        'answer_name',
    ];

    public function homework()
    {
        return $this->belongsTo(HomeWork::class);
    }
}

