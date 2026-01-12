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
        Schema::create('public_facilities', function (Blueprint $table) {
            $table->id();
            
            // RELASI: Menghubungkan fasilitas ke tabel cities (kota)
            // constrained('cities') artinya id ini harus ada di tabel cities
            // onDelete('cascade') artinya jika kota dihapus, fasilitas di dalamnya ikut terhapus
            $table->foreignId('city_id')
                  ->constrained('cities')
                  ->onDelete('cascade');

            $table->string('name'); // Nama fasilitas, misal: RSUD Mataram

            // Pilihan tipe fasilitas yang tersedia
            $table->enum('type', [
                'education',    // Sekolah/Kampus
                'health',       // Rumah Sakit/Puskesmas
                'worship',      // Tempat Ibadah
                'security',     // Kantor Polisi/Militer
                'transport',    // Terminal/Bandara/Pelabuhan
                'public_space'  // Taman/Alun-alun
            ]);

            $table->text('address')->nullable(); // Alamat boleh kosong

            $table->timestamps(); // Created_at & Updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_facilities');
    }
};