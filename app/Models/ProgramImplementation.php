<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramImplementation extends Model
{
    use HasFactory;

    protected $table = 'program_implementations';

    protected $fillable = [
        'program_id',
        'city_id',
        'start_date',
        'end_date',
        'status', // planned, ongoing, completed
        'budget_allocation'
    ];

    /**
     * Relasi: Implementasi ini milik satu Program tertentu.
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Relasi: Implementasi ini terjadi di satu Kota tertentu.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}