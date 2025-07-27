<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Resources\User\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{

    
    public function register(RegistrationRequest $request){


try {
    
   $user =  User::create([

    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),

   ]);

   Log::channel('userapi')->info('user created successfully',[

    'user_id' => $user->id,
    'user_ip' => $request->ip(),
    'user_agent' => $request->userAgent(),
   ]);
  
   Auth::login($user);

    $token = $user->createToken('Api Token')->plainTextToken;

   return response()->json([

    'success' => true,
    'message' => 'userAgent',
    'data' => [],
    'token' => $token,
   ]);
    
} catch (\Exception $e) {


    Log::channel('userapi')->info('error occurred while creating user',[

        'user_ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'exception_details' => $e->getMessage(),
       ]);


       return response()->json([

        'success' => false,
        'message' => 'error occurred while creating user',
        'data' => [],
       ],500);

}

    }

    public function login(LoginRequest $request)
    {


        $info = $request->only('email', 'password');

        if (Auth::attempt($info)) {

            $user = Auth::user();



            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json(
                [

                    'success' => true,
                    'message' => 'login successful',
                    'data' => new ProfileResource($user),
                    'token' => $token
                ],
                200
            );
        } else {


            return response()->json(
                [

                    'success' => false,
                    'message' => 'invalid credentials'
                ],
                401
            );
        }
    }

    public function logout(Request $request)
    {

        if (!Auth::guard('sanctum')->check()) {

            return response()->json(
                [
                    'success' => false,
                    'message' => 'user is not logged in',
                ],
                401
            );
        }

        $user = Auth::guard('sanctum')->user();

        $user->currentAccessToken()->delete();

        return response()->json(
            [

                'success' => true,
                'message' => 'logged out successfully',

            ],
            200 
        );
    }
}
