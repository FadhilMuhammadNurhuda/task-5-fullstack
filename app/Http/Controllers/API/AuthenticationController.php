<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// use \App\Models\;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::attempt($login)) {
            $msg = 'invalid credential';
            return response()->json($msg);
        }

        $accessToken = Auth::user()->createToken('accessToken')->accessToken;
        return response()->json([
            'user' => Auth::user(),
            'access_token' => $accessToken
        ]);
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            $msg = 'invalid username or password';
            return response()->json($msg);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $accessToken = $user->createToken('accessToken')->accessToken;

        return response()->json([
            'access_token' => $accessToken
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        // dd($token);
        $token->revoke();

        $msg = 'you have been success to logout';
        return response()->json(
            $msg
        );
    }
}
