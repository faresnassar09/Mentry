<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{

    public function index()
    {

        $user = Auth::user();

        return response()->json([

            'success' => true,
            'message' => 'user information retrieved successfully',
            'data' => new ProfileResource($user),
        ]);
    }

    public function update(Request $request, User $user)
    {



        try {

            $user->fill($request->only(['name', 'email']));

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($user->isDirty()) {
                $user->save();
            }
            $changedFilds = $user->getChanges();
            $changedFilds['password'] = 'hedden';
            $changedFilds['email'] = 'hedden';


            Log::channel('userapi')->info('user info changed successfully', [

                'user_id' => Auth::id(),
                'user_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'filds_changed' => $changedFilds,
            ]);


            return response()->json([

                'success' => true,
                'message' => 'user info changed successfully',
                'data' => new ProfileResource($user),
            ], 200);
        } catch (\Exception $e) {

            Log::channel('userapi')->info('erroe occurred while changing user info', [

                'user_id' => Auth::id(),
                'user_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'exception_details' => $e->getMessage(),
            ]);
        }

        return response()->json([

            'success' => false,
            'message' => 'erroe occurred while changing user info',
            'data' => [],
        ], 500);
    }

    public function destroy(Request $request, User $user)
    {


        try {

            $user = Auth::user();

            $user->currentAccessToken()->delete();
            
            $user->delete();

            Log::channel('userapi')->info('user deleted successfully', [

                'user_name' => $user->name,

            ]);

            return response()->json([

                'success' => true,
                'message' => 'user deleted successfully',
                'data' => [],
            ]);
        } catch (\Exception $e) {



            Log::channel('userapi')->info('error occurred while deleting user', [

                'user_id' => $user->id,
                'exception_details' => $e->getMessage(),

            ]);

            return response()->json([

                'success' => true,
                'message' => 'error occurred while deleting user',
                'data' => [],
            ]);
        }
    }
}
