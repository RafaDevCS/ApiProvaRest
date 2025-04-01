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
        Schema::create('pessoa', function (Blueprint $table) {
            $table->id('pes_id')->primary();
            $table->string('pes_nome', length: 200);
            $table->date('ps_data_nascimento');
            $table->string('ps_sexo', length: 9);
            $table->string('ps_mae', length: 200);
            $table->string('ps_pai', length: 200);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoa');
    }
};
