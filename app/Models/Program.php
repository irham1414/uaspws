<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    // Jika nama tabel bukan default "programs"
    protected $table = 'program';

    // Jika primary key bukan "id"
    protected $primaryKey = 'program_id';

    protected $fillable = [
        'title',
        'description',
        'year'
    ];

    // Jika kolom year bertipe integer
    protected $casts = [
        'year' => 'integer'
    ];
}
