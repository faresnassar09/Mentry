<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\DashboardResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function dashboard(){

        $user = User::with([
            'studyNotes',
            'userBooks',
            'studyMaterials',
            'userNotes',
            'userSnippets',
        ])->find(Auth::id());

         return response()->json([

            'success' => true,
            'message' => 'dashboard infotmation retrived successfully',
            'data' =>new DashboardResource($user),
         ]);
    }



}
