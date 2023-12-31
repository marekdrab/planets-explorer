<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'mood' => 'nullable|string',
            'weather' => 'nullable|string',
            'gps_location' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        $logbook = Logbook::create($validatedData);

        return response()->json($logbook, 201); // 201 Created
    }
}
