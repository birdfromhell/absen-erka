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
        Schema::create('absens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('username');
            $table->string('hari');
            $table->string('kegiatan')->nullable();
            $table->dateTime('masuk');
            $table->dateTime('keluar')->nullable();
            $table->enum('status', ['Hadir', 'Terlambat', 'Sakit', 'Izin', 'Alpha'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absens');
    }
};
