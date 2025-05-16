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
        Schema::table('materials', function (Blueprint $table) {
            //$table->string('material_code')->nullable()->unique()->after('id');
            //$table->unique('material_code');
        });
    }

    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('material_code');
        });
    }
};
