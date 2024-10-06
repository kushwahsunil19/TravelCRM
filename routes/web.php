<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{AuthController,ForgotPasswordController,ProfileController,UserController,QuotationController,ItineraryController,PartnerController,BranchController,PackageController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/clear', function () {
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
   return "Cache cleared successfully";
});
Route::controller(AuthController::class)->group(function() {
    Route::get('/', 'login')->name('login');
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
   
});

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::middleware(['auth'])->group(function() {
    Route::resource('profile', ProfileController::class);
    Route::get('/dashboard',[AuthController::class, 'dashboard'] )->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Resource route for users
    Route::resource('users', UserController::class); // Adjust middleware as needed
    Route::get('/users-data', [UserController::class, 'getUsers'])->name('users.data');

    Route::resource('itineraries', ItineraryController::class); // Adjust middleware as needed
    Route::get('/itineraries-data', [ItineraryController::class, 'getdata'])->name('itineraries.data');

    Route::resource('quotations', QuotationController::class); // Adjust middleware as needed
    Route::get('/quotations-data', [QuotationController::class, 'getdata'])->name('quotations.data');

    Route::resource('partners', PartnerController::class); // Adjust middleware as needed
    Route::get('/partners-data', [PartnerController::class, 'getdata'])->name('partners.data');
    Route::resource('branches', BranchController::class);
    Route::resource('packages', PackageController::class);
    Route::get('packages/{id}/details', [PackageController::class, 'getPackageDetails'])->name('packages.details');
    // Optional: Route to restore soft-deleted packages
    Route::post('packages/{id}/restore', [PackageController::class, 'restore'])->name('packages.restore');
    Route::resource('quotations', QuotationController::class); 
    Route::get('/quotation/pdf/{id}', [QuotationController::class, 'generateQuotationPDF'])->name('quotation.estimate');

    Route::post('quotations/{id}/restore', [QuotationController::class, 'restore'])->name('packages.restore');

// Route::get('/users', [UserController::class, 'index'])->name('users.index');
// Route::post('/users', [UserController::class, 'store'])->name('users.store');
// Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
// Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');

// Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::post('/assing-role', [UserController::class, 'updateRole'])->name('users.updateRole');

// Route for fetching users data via AJAX

});