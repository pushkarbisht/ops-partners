<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Mail\TestMail;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User registration route
Route::match(['post', 'get'],'/register', [AuthController::class, 'register']);
Route::post('/set-password', [AuthController::class, 'setPassword']);
Route::post('/login', [AuthController::class, 'login']);
Route::match(['post', 'get'], '/generate-otp', [AuthController::class, 'generateOTP']);
Route::match(['post', 'get'], '/checktoke', [AuthController::class, 'checktoke']);

// Route::get('/test-mail', function () {
//     try {
//         return response()->json(['message' => 'Failed to send test email'], 500);
//         // Send a test email
//         Mail::to('saurav43@yopmail.com')->send(new TestMail());

//         // Check if the mail was sent successfully
//         if (Mail::failures()) {
//             // Mail sending failed
//             return response()->json(['message' => 'Failed to send test email'], 500);
//         } else {
//             // Mail sent successfully
//             return response()->json(['message' => 'Test email sent successfully'], 200);
//         }
//     } catch (\Exception $e) {
//         // Log the exception
//         Log::error($e);

//         // Return an error response
//         return response()->json(['error' => 'An unexpected error occurred'], 500);
//     }
// });
