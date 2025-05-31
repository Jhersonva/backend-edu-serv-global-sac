<?php
use App\Http\Controllers\Api\Customer\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Home\HomeController;
use App\Http\Controllers\Api\Blog\BlogController;
use App\Http\Controllers\Api\TeamInformation\TeamInformationController;

//rutas de la api home
Route::get('homes', [HomeController::class, 'index']);
Route::post('homes', [HomeController::class, 'store']);
Route::get('homes/{id}', [HomeController::class, 'show']);
Route::put('homes/{id}', [HomeController::class, 'update']);
Route::delete('homes/{id}', [HomeController::class, 'destroy']);

//Route Api Customers
Route::get('customers', [CustomerController::class, 'index']);
Route::post('customers', [CustomerController::class, 'store']);
Route::get('customers/{id}', [CustomerController::class, 'show']);
Route::put('customers/{id}', [CustomerController::class, 'update']);
Route::delete('customers/{id}', [CustomerController::class, 'destroy']);

// Rutas de la API Blog
Route::get('blogs', [BlogController::class, 'index']);            
Route::post('blogs', [BlogController::class, 'store']);          
Route::get('blogs/{id}', [BlogController::class, 'show']);       
Route::put('blogs/{id}', [BlogController::class, 'update']);      
Route::delete('blogs/{id}', [BlogController::class, 'destroy']); 

// Rutas de la API TeamInformation
Route::get('team-information', [TeamInformationController::class, 'index']);
Route::post('team-information', [TeamInformationController::class, 'store']);
Route::get('team-information/{id}', [TeamInformationController::class, 'show']);
Route::put('team-information/{id}', [TeamInformationController::class, 'update']);
Route::delete('team-information/{id}', [TeamInformationController::class, 'destroy']);