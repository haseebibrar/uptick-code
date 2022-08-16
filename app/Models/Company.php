<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'phone', 'bank_hours', 'remaining_bank_hours', 'total_bank_hours', 'allocated_date'
    ];

    public function students()
    {
        return $this->hasMany(User::class);
    }
}