<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ParkingSlotsController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/slot-count', [ParkingSlotsController::class, 'fetchSlots']);
Route::post('/park-vehicle', [ParkingSlotsController::class, 'parkVehicle']);
Route::post('/unpark-vehicle', [ParkingSlotsController::class, 'unparkVehicle']);


