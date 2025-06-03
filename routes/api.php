<?php
use App\Http\Controllers\Api\Customer\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Home\HomeController;
use App\Http\Controllers\Api\Blog\BlogController;
use App\Http\Controllers\Api\TeamInformation\TeamInformationController;
use App\Http\Controllers\Api\ContactForm\ContactFormController;
use App\Http\Controllers\Api\CompanyContact\CompanyContactController;
use App\Http\Controllers\Api\AboutUs\AboutUsController;
use App\Http\Controllers\Api\AuthUsers\AuthUserController;
use App\Http\Controllers\Api\Servics\ServiceController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\SubCategory\SubCategoryController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUserAuth;
use App\Http\Middleware\NoUserExists;

// Rutas de la API AuthUser
Route::post('register', [AuthUserController::class, 'registerUser'])->middleware(NoUserExists::class);
Route::post('login', [AuthUserController::class, 'loginUser']);

Route::middleware(IsUserAuth::class)->group(function () {

    // Rutas de la API AuthUser Authenticated
    Route::controller(AuthUserController::class)->group(function () {
        Route::post('refresh-token', 'refreshToken');
        Route::post('logout', 'logout');
        Route::get('user', 'getUser');
    });

    // Rutas de la API AuthUser -  Authenticated - Admin
    Route::middleware(IsAdmin::class)->group(function () {
    });
});

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

// Rutas de la API ContactForm
Route::get('contactforms', [ContactFormController::class, 'index']);
Route::post('contactforms', [ContactFormController::class, 'store']);
Route::get('contactforms/{id}', [ContactFormController::class, 'show']);
Route::put('contactforms/{id}', [ContactFormController::class, 'update']);
Route::delete('contactforms/{id}', [ContactFormController::class, 'destroy']);
// Rutas de la API AboutUs
Route::get('about-us', [AboutUsController::class, 'index']);
Route::post('about-us', [AboutUsController::class, 'store']);
Route::get('about-us/{id}', [AboutUsController::class, 'show']);
Route::put('about-us/{id}', [AboutUsController::class, 'update']);
Route::delete('about-us/{id}', [AboutUsController::class, 'destroy']);

// Rutas de la API CompanyContact
Route::get('/company-contact', [CompanyContactController::class, 'index']);
Route::get('/company-contact/{id}', [CompanyContactController::class, 'show']);
Route::put('/company-contact/{id}', [CompanyContactController::class, 'update']);

// Rutas de la API Services
Route::get('services', [ServiceController::class, 'index']);
Route::post('services', [ServiceController::class, 'store']);
Route::get('services/{id}', [ServiceController::class, 'show']);
Route::put('services/{id}', [ServiceController::class, 'update']);
Route::delete('services/{id}', [ServiceController::class, 'destroy']);

// Rutas de la API Categories
Route::get('categories', [CategoryController::class, 'index']);
Route::post('categories', [CategoryController::class, 'store']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::put('categories/{id}', [CategoryController::class, 'update']);
Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

// Rutas de la API SubCategories
Route::get('sub-categories', [SubCategoryController::class, 'index']);
Route::post('sub-categories', [SubCategoryController::class, 'store']);
Route::get('sub-categories/{id}', [SubCategoryController::class, 'show']);
Route::put('sub-categories/{id}', [SubCategoryController::class, 'update']);
Route::delete('sub-categories/{id}', [SubCategoryController::class, 'destroy']);
