<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicFacility extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id', 
        'name', 
        'type', 
        'address'
    ];

    /**
     * Relasi: Fasilitas ini milik satu Kota
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}