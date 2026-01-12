<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    /**
     * PERBAIKAN 1: Tabel
     * Karena nama tabel Anda 'provinces' (jamak), ini sudah standar Laravel.
     * Baris ini boleh ada, boleh tidak.
     */
    protected $table = 'provinces';

    /**
     * PERBAIKAN 2: Primary Key (KRUSIAL!)
     * Di gambar database, kolom kunci Anda adalah 'id'.
     * JANGAN definisikan 'province_id' di sini, atau akan Error SQL.
     * Kita hapus baris protected $primaryKey agar kembali ke default 'id'.
     */

    /**
     * PERBAIKAN 3: Fillable
     * Sesuaikan dengan nama kolom di screenshot database Anda: 'code' dan 'name'.
     * Jangan pakai 'province_code' atau 'province_name'.
     */
    protected $fillable = [
        'code',
        'name'
    ];

    /**
     * Relasi ke City
     */
    public function cities()
    {
        // Parameter 2: Foreign Key di tabel cities (biasanya 'province_id')
        // Parameter 3: Local Key di tabel ini (id) -> Tidak perlu ditulis karena sudah default
        return $this->hasMany(City::class, 'province_id');
    }
}
// izamadd