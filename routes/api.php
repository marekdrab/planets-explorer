<?php

use App\Http\Controllers\LogbookController;
use App\Http\Controllers\PlanetDataController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/planets/largest', [PlanetDataController::class, 'largestPlanets']);
Route::get('/planets/terrain-distribution', [PlanetDataController::class, 'terrainDistribution']);

Route::post('/logbooks', [LogbookController::class, 'store']);
