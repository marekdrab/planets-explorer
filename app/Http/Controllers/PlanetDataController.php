<?php

namespace App\Http\Controllers;

use App\Models\Planet;
use Illuminate\Http\Request;

class PlanetDataController extends Controller
{
    public function largestPlanets()
    {
        return response()->json(Planet::getLargestPlanets());
    }}
