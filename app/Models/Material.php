<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'quantity',
    ];

    // Relaciones

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
