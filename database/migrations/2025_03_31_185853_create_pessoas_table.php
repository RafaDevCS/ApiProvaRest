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
            $table->string('pes_data_nascimento', length: 20);
            $table->string('pes_sexo', length: 9);
            $table->string('pes_mae', length: 200);
            $table->string('pes_pai', length: 200);
            $table->timestamps();
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
