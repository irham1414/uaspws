<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_implementations', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel programs (Master Program)
            $table->foreignId('program_id')
                  ->constrained('programs')
                  ->onDelete('cascade');

            // Relasi ke tabel cities (Lokasi Program)
            $table->foreignId('city_id')
                  ->constrained('cities')
                  ->onDelete('cascade');

            // Detail Pelaksanaan
            $table->date('start_date'); // Tanggal mulai
            $table->date('end_date')->nullable(); // Tanggal selesai (bisa kosong jika belum selesai)
            
            // Status program: Direncanakan, Berjalan, atau Selesai
            $table->enum('status', ['planned', 'ongoing', 'completed'])->default('planned');
            
            // Opsional: Anggaran khusus untuk kota tersebut
            $table->decimal('budget_allocation', 15, 2)->nullable(); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_implementations');
    }
};