<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rotation_period',
        'orbital_period',
        'diameter',
        'climate',
        'gravity',
        'terrain',
        'surface_water',
        'population',
    ];

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }

    public static function getLargestPlanets($limit = 10) {
        return self::where('diameter', '>', 0)
            ->orderBy('diameter', 'desc')
            ->take($limit)
            ->get(['name', 'diameter']);
    }

}
