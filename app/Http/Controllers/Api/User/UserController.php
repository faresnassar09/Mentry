<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\DashboardResource;
use App\Models\User;
use App\Service\Api\ResponseHandelerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class UserController extends Controller
{

    public function __construct(public ResponseHandelerService $responseHandelerService){
        
    }

    public function dashboard(){

        $user = User::with([
            'studyNotes',
            'userBooks',
            'studyMaterials',
            'userNotes',
            'userSnippets',
        ])->find(Auth::id());

         return $this->responseHandelerService->successResponse(

            'User Dashboard information retrieved successfully',
            new DashboardResource($user),
            200
         );
    }



}
