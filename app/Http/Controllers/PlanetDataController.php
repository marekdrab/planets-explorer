<?php

namespace App\Http\Controllers;

use App\Models\Planet;

class PlanetDataController extends Controller
{
    public function largestPlanets()
    {
        return response()->json(Planet::getLargestPlanets());
    }

    public function terrainDistribution()
    {
        return response()->json(Planet::getTerrainDistribution());
    }
}

