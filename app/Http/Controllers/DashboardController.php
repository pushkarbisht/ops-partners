<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\User;
use App\Models\ProfessionalNetwork;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Middleware to handle token and authenticate user
        $this->middleware(function ($request, $next) {
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

                        // Attach the user object to the request
                        $request->merge(['user' => $user]);
                    } catch (JWTException $e) {
                        // Handle token parsing/authentication errors
                        // return response()->json(['error' => 'Unauthorized: ' . $e->getMessage()], 401);
                        return redirect('/login');
                    }
                } else {
                    // Token not found in cookies, redirect to login
                    return redirect('/login');
                }
            } else {
                // Cookie header not present, redirect to login
                return redirect('/login');
            }

            return $next($request);
        });
    }

    // Display the dashboard view if authenticated
    public function dashboard(Request $request)
    {
        // Retrieve the user object from the request
        $user = $request->user;


        $user = User::find($user->id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Fetch professional network data based on user_id
        $professionalNetwork = ProfessionalNetwork::where('following_user_id', $user->Id)->first();

        // Combine user data with professional network data
        $userData = [
            'user' => $user,
            'professional_network' => $professionalNetwork
        ];
        // echo '<pre>';
        // print_r($userData);
        // die();
        // Pass the user object to the view
        return view('user_dashboard', compact('userData'));
    }
}