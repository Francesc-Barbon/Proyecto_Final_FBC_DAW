<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'job_id',
        'user_id',
        'quantity',
        'movement_type',
        'date',
    ];

    // Relaciones

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
