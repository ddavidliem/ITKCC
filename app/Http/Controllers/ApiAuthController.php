<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Blacklist;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('alamat_email', 'password');

        if ($token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(compact('token'));
        }

        return response()->json(['error' => 'Credentials Invalid'], 401);
    }


    public function logout()
    {
        JWTAuth::invalidate();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
