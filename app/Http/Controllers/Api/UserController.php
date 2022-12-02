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

    public function store(Request $request){
        $user = $request->all();

        // $validate = Validator::make($user,
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email',
            'password' => 'required|required_with:konfirmasiPassword|same:konfirmasiPassword',
            'konfirmasiPassword' => 'required',
            'tglLahir' => 'required|date_format:d/m/Y',
            'telp' => 'required|min:11|max:12',
        ]);

        // if($validate->fails())
        //     return response(['message' => $validate->errors()], 400);
        
        // $user['password'] = bcrypt($request->password);
        // $user['konfirmasiPassword'] = bcrypt($request->password);

        $user = User::create($user);

        return response([
            'message' => 'Register Success',
            'user' => $user
        ], 200);
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

        // $validate = Validator::make($updateData,
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email',
            'password' => 'required|required_with:konfirmasiPassword|same:konfirmasiPassword',
            'konfirmasiPassword' => 'required',
            'tglLahir' => 'required|date_format:Y-m-d',
            'telp' => 'required|min:11|max:12',
        ]);

        // if($validate->fails())
        //     return response(['message' => $validate->errors()], 400);
        
        $user->nama = $updateData['nama'];
        $user->username = $updateData['username'];
        $user->email = $updateData['email'];
        $user->password = $updateData['password'];
        $user->konfirmasiPassword = $updateData['konfirmasiPassword'];
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
