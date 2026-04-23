<?php
use App\Http\Controllers\TransportUnitController;


Route::get('/transport-units', [TransportUnitController::class, 'index']);
Route::post('/transport-units', [TransportUnitController::class, 'store']);