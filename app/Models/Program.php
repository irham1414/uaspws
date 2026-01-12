<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    /**
     * $fillable
     * Sesuai dengan kolom di database: 'name' dan 'description'.
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * BARU: Relasi ke tabel implementasi program.
     * (One-to-Many: Satu jenis program bisa dilaksanakan di banyak kota/wilayah).
     * * Cara panggil: $program->implementations
     */
    public function implementations()
    {
        return $this->hasMany(ProgramImplementation::class);
    }
}