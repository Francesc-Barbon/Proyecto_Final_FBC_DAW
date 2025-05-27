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
        'material_code',
        'unit_price',
    ];
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
