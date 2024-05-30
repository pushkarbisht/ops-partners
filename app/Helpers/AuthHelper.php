<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use JWTAuth;
use Log;

class AuthHelper
{
    public static function authenticateUser()
    {
        try {
            // Get token from cookie
            $token = Cookie::get('jwt_token');

            // If token not found in cookie, try to get it from session
            if (!$token) {
                $token = Session::get('jwt_token');
                Log::info('Retrieved token from session', ['token' => $token]);
            } else {
                Log::info('Retrieved token from cookie', ['token' => $token]);
            }

            if (!$token) {
                throw new \Exception('Token not found');
            }

            // Decode the token and get the user
            $user = JWTAuth::setToken($token)->toUser();
            Log::info('User authenticated', ['user' => $user]);

            return $user;

        } catch (\Exception $e) {
            Log::error('Authentication failed', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
