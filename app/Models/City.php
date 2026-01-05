<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini
use Illuminate\Database\Eloquent\Model;
// Pastikan model terkait (Province dan District) juga diimpor di file ini
use App\Models\Province;
use App\Models\District;

class City extends Model
{
    // Tambahkan Trait ini jika Anda menggunakan factory
    use HasFactory; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['province_id', 'name'];

    
    // Optional: Jika nama kolom primary key Anda bukan 'id'
    // protected $primaryKey = 'id'; 

    /**
     * Get the province that owns the city.
     */
    public function province()
    {
        // Pastikan Model Province diimpor di bagian atas
        return $this->belongsTo(Province::class, 'province_id'); 
    }

    /**
     * Get the districts for the city.
     */
    public function districts()
    {
        // Pastikan Model District diimpor di bagian atas
        return $this->hasMany(District::class, 'city_id'); 
    }
}