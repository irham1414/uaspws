<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * $fillable
     * Sesuaikan dengan nama kolom di screenshot database: 'province_id' dan 'name'.
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
        return $this->belongsTo(Province::class);
    }

    /**
     * Relasi: City memiliki banyak District
     */
    public function districts()
    {
        return $this->hasMany(District::class);
    }

    /**
     * BARU: Relasi ke data statistik penduduk
     * (One-to-Many: Satu kota punya banyak riwayat data penduduk)
     */
    public function populationStats()
    {
        return $this->hasMany(PopulationStat::class);
    }

    /**
     * BARU: Relasi ke program yang berjalan di kota ini
     * (One-to-Many: Satu kota punya banyak program berjalan)
     */
    public function programImplementations()
    {
        return $this->hasMany(ProgramImplementation::class);
    }
}