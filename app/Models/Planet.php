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

    public static function getTotalCount()
    {
        return self::count();
    }

    public static function getLargestPlanets($limit = 10)
    {
        return self::where('diameter', '>', 0)
            ->orderBy('diameter', 'desc')
            ->take($limit)
            ->get(['name', 'diameter']);
    }

    /**
     * Parse terrain string from DB and calculate percentages according to types.
     *
     * @return array
     */
    public static function getTerrainDistribution()
    {
        $terrains = [];
        $total = self::getTotalCount();

        self::all()->each(function ($planet) use (&$terrains) {
            $types = explode(',', $planet->terrain);
            foreach ($types as $type) {
                $type = trim(strtolower($type));
                if (!empty($type)) {
                    if (!isset($terrains[$type])) {
                        $terrains[$type] = 0;
                    }
                    $terrains[$type]++;
                }
            }
        });

        $percentages = [];
        foreach ($terrains as $type => $count) {
            $percentages[$type] = round(($count / $total) * 100, 2);
        }

        return $percentages;
    }
}
