<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW stock_movements_view AS
            SELECT
                sm.id,
                sm.material_id,
                m.name AS material_name,
                sm.user_id,
                u.name AS user_name,
                sm.quantity,
                sm.movement_type,
                sm.date,
                sm.job_id,
                sm.created_at,
                sm.updated_at
            FROM stock_movements sm
            LEFT JOIN materials m ON sm.material_id = m.id
            LEFT JOIN users u ON sm.user_id = u.id;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS stock_movements_view;");
    }
};
