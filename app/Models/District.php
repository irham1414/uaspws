<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    // Jika nama tabel bukan default "districts"
    protected $table = 'district';

    // Jika primary key bukan "id"
    protected $primaryKey = 'district_id';

    protected $fillable = [
        'city_id',
        'district_code',
        'district_name'
    ];

    /**
     * Relasi: District milik satu City
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }
}
