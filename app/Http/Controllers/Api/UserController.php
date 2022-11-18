<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();

        if(count($user) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($id)
    {
        $user = User::find($id);

        if(!is_null($user)){
            return response([
                'message' => 'Retrieve User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if(is_null($user)){
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[
            'nama' => 'required',
            'username' => 'required',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required',
            'konfirmasiPassword' => 'required',
            'tglLahir' => 'required',
            'telp' => 'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
        
        $user->nama = $updateData['nama'];
        $user->username = $updateData['username'];
        $user->email = $updateData['email'];
        $user->password = $updateData['password'];
        $user->konformasiPassword = $updateData['konfirmasiPassword'];
        $user->tglLahir = $updateData['tglLahir'];
        $user->telp = $updateData['telp'];

        if($user->save()){
            return response([
                'message' => 'Update user Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update user Failed',
            'data' => null
        ], 400);
    }

}
