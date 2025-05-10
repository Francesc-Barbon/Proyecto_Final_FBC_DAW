<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Eliminar la clave foránea anterior
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropForeign(['material_id']);
        });

        // Crear la clave foránea con ON DELETE CASCADE
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Revertir la operación: eliminar la opción ON DELETE CASCADE
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropForeign(['material_id']);
        });

        Schema::table('stock_movements', function (Blueprint $table) {
            $table->foreign('material_id')->references('id')->on('materials');
        });
    }
};
