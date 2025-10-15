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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('location');
            $table->enum('category', ['Aksesibilitas', 'Keamanan', 'Fasilitas Rusak']);
            $table->text('description');
            $table->string('photo')->nullable(); // <-- Kolom photo ada di sini
            $table->enum('status', ['Baru', 'Diproses', 'Selesai'])->default('Baru'); // <-- Kolom status di sini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
