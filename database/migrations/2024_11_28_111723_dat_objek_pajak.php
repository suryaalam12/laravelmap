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
        Schema::create('dat_objek_pajak', function (Blueprint $table) {
            $table->id();
            $table->string('kd_kecamatan');
            $table->string('kd_kelurahan');
            $table->string('kd_blok');
            $table->string('no_urut');
            $table->string('kd_jns_op');
            $table->magellanPolygon('geometry')->nullable(); // Allow NULL values
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
