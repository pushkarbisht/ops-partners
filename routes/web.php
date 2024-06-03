<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Helpers\AuthHelper;


// use App\Http\Controllers\MailController;

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

Route::get('/dashboard', [DashboardController::class, 'dashboard']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/login', function () {
    return view('login');
});

Route::get('/set-password', function () {
    return view('newpasword');
});

Route::get('/otp', function () {
    return view('emails/otp_notification');
});
