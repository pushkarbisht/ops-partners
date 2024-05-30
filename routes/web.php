<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    $user = AuthHelper::authenticateUser();

    if (!$user) {
        return redirect('/login'); // Redirect to login if not authenticated
    }

    return view('welcome', ['user' => $user]);
});

Route::get('/test-auth', function () {
    $user = AuthHelper::authenticateUser();

    if ($user) {
        return response()->json(['success' => true, 'user' => $user]);
    } else {
        return response()->json(['success' => false, 'message' => 'Authentication failed']);
    }
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/set-password', function () {
    return view('newpasword');
});

Route::get('/otp', function () {
    return view('emails/otp_notification');
});
// Route::get ('/',[MailController::class,'mailform']);
// Route::post ('/send-mail',[MailController::class,'maildata'])->name('send_mail');
