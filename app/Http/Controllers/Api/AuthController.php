<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request){
        $registrationData = $request->all();

        $validate = Validator::make($registrationData, [
            'nama' => 'required',
            'username' => 'required',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required',
            'konfirmasiPassword' => 'required',
            'tglLahir' => 'date|required',
            'telp' => 'required|number',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
        
        $registrationData['password'] = bcrypt($request->password);

        $user = User::create($registrationData);

        return response([
            'message' => 'Register Success',
            'user' => $user
        ], 200);
    }

    public function login(Request $request){
        $loginData = $request->all();

        $validate = Validator::make($loginData, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
        
        if(!Auth::attempt($loginData))
            return response(['message' => 'Invalid Credentials'], 401);

        $user = Auth::user();
        $token = $user->createToken('Autentication Token')->accessToken;

        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);

    }

    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
