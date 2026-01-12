<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopulationStat extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika sesuai konvensi, tapi baik untuk ketegasan)
    protected $table = 'population_stats';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'city_id',
        'year',
        'total_population',
        'density'
    ];

    /**
     * Relasi: Data statistik ini milik satu Kota.
     * (Inverse One-to-Many)
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}