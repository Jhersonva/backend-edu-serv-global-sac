<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Home\HomeController;

//rutas de la api home
Route::get('homes', [HomeController::class, 'index']);
Route::post('homes', [HomeController::class, 'store']);
Route::get('homes/{id}', [HomeController::class, 'show']);
Route::put('homes/{id}', [HomeController::class, 'update']);
Route::delete('homes/{id}', [HomeController::class, 'destroy']);