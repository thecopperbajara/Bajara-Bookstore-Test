<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequst;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function store(AdminLoginRequst $request): Response
    {
        $authUser = $request->authenticate();

        return response([
            'user' => $authUser['user'],
            'access_token' => $authUser['token'],
            'token_type' => 'bearer',
        ], 200);
    }

    public function profile(Request $request){
        return $request->user();
    }

    public function destroy(Request $request): Response
    {
        Auth::user()->tokens()->delete();

        return response(['message'=> 'Successfully Logout'], 200);
    }

    function fetchAuthors(){
        $users = User::all();
        return response()->json($users);
    }
}
