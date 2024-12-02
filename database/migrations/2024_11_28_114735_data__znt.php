<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('desa', function (Blueprint $table) {
            $table->id();
            $table->string('kec')->nullable();
            $table->string('desa')->nullable();
            $table->string('blok')->nullable();
            $table->string('nop')->nullable();
            $table->string('nul')->nullable();
            $table->string('znt_edit')->nullable();
            $table->string('nir_edit')->nullable();
            $table->magellanMultiPolygon('geom')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
