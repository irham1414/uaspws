<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    /**
     * PERBAIKAN:
     * 1. Hapus $table = 'program' (Karena tabel aslinya 'programs')
     * 2. Hapus $primaryKey = 'program_id' (Karena PK aslinya 'id')
     */

    /**
     * PERBAIKAN FILLABLE:
     * Sesuaikan dengan kolom di screenshot: 'name' dan 'description'.
     * HAPUS 'title' dan 'year' karena tidak ada di database.
     */
    protected $fillable = [
        'name',
        'description'
    ];

    // Hapus $casts 'year' karena kolom tahun tidak ada.
}