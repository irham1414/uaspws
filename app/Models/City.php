<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    // Jika nama tabel bukan default "cities"
    protected $table = 'city';

    // Jika primary key bukan "id"
    protected $primaryKey = 'city_id';

    protected $fillable = [
        'province_id',
        'city_name'
    ];

    /**
     * Relasi: City milik satu Province
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    /**
     * Relasi: City memiliki banyak District
     */
    public function districts()
    {
        return $this->hasMany(District::class, 'city_id', 'city_id');
    }
}
