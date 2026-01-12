<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('population_stats', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key ke tabel cities
            // Pastikan tabel 'cities' sudah ada sebelumnya
            $table->foreignId('city_id')
                  ->constrained('cities')
                  ->onDelete('cascade'); // Data hapus jika kotanya dihapus

            $table->year('year'); // Tahun pendataan (misal: 2024)
            $table->bigInteger('total_population'); // Jumlah penduduk
            $table->float('density')->nullable(); // Kepadatan (opsional)
            
            $table->timestamps();

            // Opsional: Mencegah duplikasi data tahun yang sama untuk kota yang sama
            $table->unique(['city_id', 'year']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('population_stats');
    }
};