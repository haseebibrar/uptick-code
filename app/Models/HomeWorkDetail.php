<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class HomeWorkDetail extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'homework_id',
        'question',
        'answer',
        'final_answer',
    ];

    public function homework()
    {
        return $this->belongsTo(HomeWork::class);
    }
}
