<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\ProfileResource;
use App\Models\User;
use App\Service\Api\ResponseHandelerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{

    public function __construct(public ResponseHandelerService $responseHandelerService,){


    }

    public function index()
    {

        $user = Auth::user();

        return $this->responseHandelerService->successResponse(

            'user information retrieved successfully',
            new ProfileResource($user),
            200
        );
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


            return $this->responseHandelerService->successResponse(

                'user info changed successfully',
                new ProfileResource($user),
                200
            );

        } catch (\Exception $e) {

            Log::channel('userapi')->info('erroe occurred while changing user info', [

                'user_id' => Auth::id(),
                'user_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'exception_details' => $e->getMessage(),
            ]);
        }

        return $this->responseHandelerService->failedResponse(

            'Unexpected Erroe occurred while changing user info',
            [],
            500
        );
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

            return $this->responseHandelerService->failedResponse(

                'user deleted successfully',
                [],
                200
            );

        } catch (\Exception $e) {



            Log::channel('userapi')->info('error occurred while deleting user', [

                'user_id' => $user->id,
                'exception_details' => $e->getMessage(),

            ]);

            return $this->responseHandelerService->failedResponse(

                'Unexpected Error occurred while deleting user',
                [],
                500
            );
        }
    }
}
