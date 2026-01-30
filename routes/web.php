<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserContoller;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('landing_page');
});

Route::get('/login', [LoginController::class, 'userLoginForm'])->name('user.login');
Route::post('/login', [LoginController::class, 'userLogin']);
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('user.register');
Route::post('/register', [LoginController::class, 'register']);
Route::get('/admin/login', [LoginController::class, 'adminLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'adminLogin']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    });
    Route::middleware(['role:user'])->group(function () {
        Route::get('/user/dashboard', [UserContoller::class, 'userDashboard'])->name('user.dashboard');
    });
});