<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * PERBAIKAN 1: Hapus properti $table dan $primaryKey.
     * Karena di database nama tabelnya 'cities' (jamak) dan kuncinya 'id',
     * Laravel sudah otomatis tahu. Tidak perlu ditulis manual.
     */

    /**
     * PERBAIKAN 2: $fillable
     * Sesuaikan dengan nama kolom di screenshot database: 'province_id' dan 'name'.
     * JANGAN gunakan 'city_name'.
     */
    protected $fillable = [
        'province_id',
        'name'
    ];

    /**
     * Relasi: City milik satu Province
     */
    public function province()
    {
        // Parameter tambahan dihapus karena nama foreign key sudah standar (province_id)
        return $this->belongsTo(Province::class);
    }

    /**
     * Relasi: City memiliki banyak District
     */
    public function districts()
    {
        // Parameter tambahan dihapus karena asumsi tabel districts juga standar
        return $this->hasMany(District::class);
    }
}
// izamadd