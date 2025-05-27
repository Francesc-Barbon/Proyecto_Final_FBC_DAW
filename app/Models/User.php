<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'hourly_rate',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relaciones

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function workHours()
    {
        return $this->hasMany(WorkHour::class);
    }

}
