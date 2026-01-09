<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    /**
     * PERBAIKAN:
     * 1. Hapus $table = 'district' (Karena tabel aslinya 'districts')
     * 2. Hapus $primaryKey = 'district_id' (Karena PK aslinya 'id')
     */

    protected $fillable = [
        'city_id', // Foreign Key ke tabel cities
        'name'     // Nama Kecamatan (Sesuaikan dengan gambar database)
        // HAPUS 'district_code' karena kolomnya tidak ada di database
    ];

    /**
     * Relasi: District milik satu City
     */
    public function city()
    {
        // Parameter tambahan dihapus karena sudah standar Laravel
        return $this->belongsTo(City::class);
    }
}