<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    // Relaciones

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function workHours()
    {
        return $this->hasMany(WorkHour::class);
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
