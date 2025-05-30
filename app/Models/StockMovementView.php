<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/*
 * Vista para mostrar los movimientos de stock
 * de forma ordenada
 * */
class StockMovementView extends Model
{
    protected $table = 'stock_movements_view';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = [];


}
