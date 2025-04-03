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
        Schema::create('foto_pessoa', function (Blueprint $table) {
            $table->id('ft_id')->primary();
            $table->unsignedBigInteger('pes_id');
            $table->string('ft_data', length: 50);
            $table->string('ft_bucket', length: 50);
            $table->string('ft_hash', length: 50);
            $table->foreign('pes_id')->references('pes_id')->on('pessoa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_pessoa');
    }
};
