<?php

namespace App\Http\Controllers;

use App\Models\Planet;
use Illuminate\Http\Request;

class PlanetController extends Controller
{
    public function index(Request $request)
    {
        $query = Planet::query();

        if ($request->filled('diameter')) {
            $query->where('diameter', $request->diameter);
        }

        if ($request->filled('rotation_period')) {
            $query->where('rotation_period', $request->rotation_period);
        }

        if ($request->filled('gravity')) {
            $query->where('gravity', 'LIKE', "%{$request->gravity}%");
        }

        $planets = $query->paginate(10);

        return view('planets.index', compact('planets'));
    }
}
