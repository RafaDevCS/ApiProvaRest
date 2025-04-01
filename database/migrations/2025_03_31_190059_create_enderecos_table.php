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
        Schema::create('endereco', function (Blueprint $table) {
            $table->id('end_id')->primary();
            $table->string('end_tipo_logradouro', length: 50);
            $table->string('end_logradouro', length: 200);
            $table->integer('end_numero');
            $table->string('end_bairro', length: 100);
            //$table->foreign('cid_id')->references('cid_id')->on('cidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endereco');
    }
};
