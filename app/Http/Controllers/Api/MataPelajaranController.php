<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\MataPelajaran;
class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mapel = MataPelajaran::all();

        if(count($mapel) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $mapel
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->all();

        // $validate = Validator::make($storeData,
        $request->validate([
            'mataPelajaran' => 'required',
            'pengajar' => 'required',
        ]);

        // if($validate->fails()){
        //     return response(['message' => $validate->errors()], 400);
        // }
        $mapel = MataPelajaran::create($storeData);

        return response([
            'message' => 'Add Mata Pelajaran Success',
            'data'=> $mapel
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mapel = MataPelajaran::find($id);

        if(!is_null($mapel)){
            return response([
                'message' => 'Retrieve Mata Pelajaran Success',
                'data' => $mapel
            ], 200);
        }

        return response([
            'message' => 'Mata Pelajaran Not Found',
            'data' => null
        ], 404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mapel = MataPelajaran::find($id);

        if(is_null($mapel)){
            return response([
                'message' => 'Mata Pelajaran Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();

        // $validate = Validator::make($updateData,
        $request->validate([
            'mataPelajaran' => 'required',
            'pengajar' => 'required',
        ]);

        // if($validate->fails()){
        //     return response(['message' => $validate->errors()], 400);
        // }

        $mapel->mataPelajaran = $updateData['mataPelajaran'];
        $mapel->pengajar = $updateData['pengajar'];

        if($mapel->save()){
            return response([
                'message' => 'Update Mata Pelajaran Success',
                'data' => $mapel
            ], 200);
        }


        return response([
            'message' => 'Update Buku Failed',
            'data' => null
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mapel = MataPelajaran::find($id);

        if(is_null($mapel)){
            return response([
                'message' => 'Buku Not Found',
                'data' => null
            ], 404);
        }

        if($mapel->delete()){
            return response([
                'message' => 'Delete Buku Success',
                'data' => $mapel
            ], 200);
        }

        return response([
            'message' => 'Delete Buku Failed',
            'data' => null
        ], 400);
    }
}
