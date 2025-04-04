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
        /*
        Schema::table('lotacao', function (Blueprint $table) {
            $table->foreign('pes_id')->references('pes_id')->on('pessoa');
            $table->foreign('uni_id')->references('uni_id')->on('unidade');
        });

        Schema::table('servidor_efetivo', function (Blueprint $table) {
            $table->foreign('pes_id')->references('pes_id')->on('pessoa');
        });
        Schema::table('servidor_temporario', function (Blueprint $table) {
            $table->foreign('pes_id')->references('pes_id')->on('pessoa');
        });
        Schema::table('foto_pessoa', function (Blueprint $table) {
            $table->foreign('pes_id')->references('pes_id')->on('pessoa');
        });
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
