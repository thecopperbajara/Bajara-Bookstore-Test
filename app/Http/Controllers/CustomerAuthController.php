<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequst;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    public function store(UserLoginRequst $request): Response
    {
        $authUser = $request->authenticate();

        return response([
            'customer' => $authUser['user'],
            'access_token' => $authUser['token'],
            'token_type' => 'bearer',
        ], 200);
    }

    public function profile(Request $request){
        return Auth::guard('customer')->user();
        // return $request->user();
    }

    public function destroy(Request $request): Response
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response(['message'=> 'Successfully Logout'], 200);
    }
}
