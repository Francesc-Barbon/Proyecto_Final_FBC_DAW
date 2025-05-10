<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovementView extends Model
{
    protected $table = 'stock_movements_view';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = [];


}
