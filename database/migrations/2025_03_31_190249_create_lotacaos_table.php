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
        Schema::create('lotacao', function (Blueprint $table) {
            $table->id('lot_id');
            $table->unsignedBigInteger('pes_id');
            $table->unsignedBigInteger('unid_id');
            $table->date('lot_data_lotacao');
            $table->date('lot_data_remocao');
            $table->string('lot_portaria', length: 200);
            $table->timestamps();
            $table->foreign('pes_id')->references('pes_id')->on('pessoa');
            $table->foreign('unid_id')->references('unid_id')->on('unidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotacao');
    }
};
