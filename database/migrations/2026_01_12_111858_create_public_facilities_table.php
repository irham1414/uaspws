<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('public_facilities', function (Blueprint $table) {
            $table->id();
            
            // Relasi: Fasilitas ini ada di Kota mana?
            $table->foreignId('city_id')
                  ->constrained('cities')
                  ->onDelete('cascade'); // Jika kota dihapus, fasilitas ikut terhapus

            $table->string('name'); // Contoh: "RSUD Mataram"
            
            // Jenis Fasilitas (Enum agar datanya seragam)
            $table->enum('type', [
                'education', // Sekolah/Kampus
                'health',    // Rumah Sakit/Puskesmas
                'worship',   // Masjid/Gereja/Pura
                'security',  // Kantor Polisi/Kodim
                'transport', // Terminal/Stasiun
                'public_space' // Taman/Alun-alun
            ]);

            $table->text('address')->nullable(); // Alamat lengkap
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('public_facilities');
    }
};