<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    // Nama tabel jika bukan default "provinces"
    protected $table = 'province';

    // Primary key jika bukan "id"
    protected $primaryKey = 'province_id';

    // Jika primary key bukan auto increment integer
    // public $incrementing = true;
    // protected $keyType = 'int';

    protected $fillable = [
        'province_code',
        'province_name'
    ];

    public function cities()
    {
        return $this->hasMany(City::class, 'province_id', 'province_id');
    }
}
