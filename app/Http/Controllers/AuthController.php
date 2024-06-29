<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProfessionalNetwork;
use App\Models\Opt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmation;
use Illuminate\Support\Facades\Log;
use App\Mail\OTPMail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Exceptions\JWTException;

use Exception;


class AuthController extends Controller
{
    public function generateOTP(Request $request)
    {
        try {
            // Validate email input
            $request->validate([
                'email' => 'required|email|unique:users,email', // Ensure email is unique
            ]);

            $email = $request->email;

            // Generate OTP
            $otp = mt_rand(100000, 999999);

            // Save OTP in the database
            Opt::updateOrCreate(
                ['email' => $email],
                ['otp' => $otp, 'updated_at' => now()] // Update OTP if email exists, or create a new record
            );

            // Send OTP to user's email
            try {
                Mail::to($email)->send(new OTPMail($otp));
            } catch (\Exception $e) {
                Log::error('Failed to send OTP email: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to send OTP'], 500);
            }

            return response()->json(['message' => 'OTP generated and sent successfully.'], 200)
                ->header('Referrer-Policy', 'strict-origin-when-cross-origin');
        } catch (\Exception $e) {
            // Log the exception if needed
            Log::error('Failed to generate OTP: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'Failed to generate and send OTP: ' . $e->getMessage()], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255|unique:users',
                'otp' => 'required|string|min:6|max:6',
                // Add other fields if needed
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $email = $request->email;
            $otp = $request->otp;

            // Retrieve OTP from the database
            $otpRecord = Opt::where('email', $email)->first();

            if ($otpRecord) {
                $storedOtp = $otpRecord->otp;
                $otpCreatedAt = $otpRecord->created_at;

                // Check if OTP is expired (30 minutes expiration time)
                $expirationTime = $otpCreatedAt->addMinutes(30);
                if (now()->greaterThan($expirationTime)) {
                    return response()->json(['error' => 'OTP has expired'], 400);
                }

                if ($otp == $storedOtp) {
                    // OTP is correct, proceed with registration
                    // Create a new user record
                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'dob' => $request->dob,
                        'contact' => $request->contact
                    ]);
                    $user_id = $user->id;

                    if($request->purpose == "Professional Network"){
                        // Create a new professional network record
                    $professionalNetwork = ProfessionalNetwork::create([
                        'following_user_id' => $user->id,
                        'purpose' => $request->purpose,
                        'type' => $request->type,
                        'permanentAddress' => $request->address,
                        'position' => $request->position,
                    ]);
                    }
                    else{

                    }
                    

                    // Remove the OTP from the database
                    $otpRecord->delete();

                    $token = base64_encode($user_id);
                    $user_purpose = $request->purpose;

                    // Send email with congratulations message and token
                    Mail::to($user->email)->send(new RegistrationConfirmation($token , $user_purpose));

                    // Return a response with success message
                    return response()->json(['user' => $user, 'message' => 'User registered successfully. Confirmation email sent.'], 200);
                } else {
                    // Incorrect OTP
                    return response()->json(['error' => 'Incorrect OTP'], 400);
                }
            } else {
                // OTP not found
                return response()->json(['error' => 'OTP not found'], 400);
            }
        } catch (\Exception $e) {
            // Log the exception
            Log::error($e);

            // Return an error response
            return response()->json(['error' => 'Failed to register user: ' . $e->getMessage()], 500);
        }
    }
    public function setPassword(Request $request)
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:6',
                'token' => 'required|string', // JWT token
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Decode JWT token
            $token = $request->token;
            $decodedUserId = base64_decode($token);

            // Find the user by ID
            $user = User::find($decodedUserId);

            // Check if the user exists
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Set password for the user
            $user->password = Hash::make($request->password);
            $user->save();

            // Return success response
            return response()->json(['message' => 'Password set successfully'], 200);
        } catch (\Exception $e) {
            // Log the exception
            // Log::error($e);

            // Return an error response
            return response()->json(['error' => 'Failed to set password'], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Attempt to authenticate the user
            if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Retrieve the authenticated user
            $user = Auth::user();

            // Return JWT token with success message
            $response = response()->json([
                'message' => 'The token has been generated successfully.',
                'token' => 'Bearer ' . $token
            ], 200)->cookie('jwt_token', $token);

            return $response;

        } catch (\Exception $e) {
            // Log the exception
            Log::error($e);

            // Return an error response
            return response()->json(['error' => 'Failed to log in: ' . $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Retrieve the Cookie header
            $cookieHeader = $request->headers->get('Cookie');

            if ($cookieHeader) {
                // Parse the Cookie header to find the jwt_token
                $cookies = explode('; ', $cookieHeader);
                $token = null;
                foreach ($cookies as $cookie) {
                    if (strpos($cookie, 'jwt_token=') === 0) {
                        $token = substr($cookie, strlen('jwt_token='));
                        break;
                    }
                }

                if ($token) {
                    // Set the authorization header with the Bearer token
                    $request->headers->set('Authorization', 'Bearer ' . $token);

                    try {
                        // Authenticate the user using the token
                        if (!$user = JWTAuth::parseToken()->authenticate()) {
                            return response()->json(['error' => 'User not found'], 404);
                        }

                        // Invalidate the token
                        JWTAuth::invalidate(JWTAuth::getToken());

                        // Remove the JWT token cookie
                        return response()->json(['message' => 'Successfully logged out'], 200)
                            ->cookie('jwt_token', null, -1); // Delete the cookie
                    } catch (JWTException $e) {
                        // Handle token parsing/authentication errors
                        return response()->json(['error' => 'Failed to log out: ' . $e->getMessage()], 500);
                    }
                } else {
                    // Token not found in cookies, user is not authenticated
                    return response()->json(['error' => 'User not authenticated'], 401);
                }
            } else {
                // Cookie header not present, user is not authenticated
                return response()->json(['error' => 'User not authenticated'], 401);
            }
        } catch (\Exception $e) {
            // Log the exception
            // Log::error($e);

            // Return an error response
            return response()->json(['error' => 'Failed to log out: ' . $e->getMessage()], 500);
        }
    }
    public function checktoke(Request $request)
    {
        $token = Cookie::get('jwt_token');
        return response()->json(['error' => $token], 401);

    }
}
