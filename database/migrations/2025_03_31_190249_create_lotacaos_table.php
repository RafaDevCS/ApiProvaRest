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
        Schema::create('lotacaos', function (Blueprint $table) {
            $table->id('lot_id');
            $table->foreignId('pes_id');
            $table->foreignId('uni_id');
            $table->string('lt_data_lotacao', length: 20);
            $table->string('lt_data_remocao', length: 20);
            $table->string('lt_portaria', length: 200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotacaos');
    }
};
