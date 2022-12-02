<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Buku;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buku = Buku::all();

        if(count($buku) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $buku
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
            'judul' => 'required',
            'penerbit' => 'required',
            'tahunTerbit' => 'required|regex:/^[0-9]{4}$/',
            'pengarang' => 'required',
            'jumlahHalaman' => 'required|numeric|min:1',
            'isbn' => 'required|min:13',
        ]);

        // if($validate->fails()){
        //     return response(['message' => $validate->errors()], 400);
        // }
        $buku = Buku::create($storeData);

        return response([
            'message' => 'Add Buku Success',
            'data'=> $buku
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
        $buku = Buku::find($id);

        if(!is_null($buku)){
            return response([
                'message' => 'Retrieve Buku Success',
                'data' => $buku
            ], 200);
        }

        return response([
            'message' => 'Buku Not Found',
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
        $buku = Buku::find($id);

        if(is_null($buku)){
            return response([
                'message' => 'Buku Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();

        // $validate = Validator::make($updateData,
        $request->validate([
            'judul' => 'required',
            'penerbit' => 'required',
            'tahunTerbit' => 'required',
            'pengarang' => 'required',
            'jumlahHalaman' => 'required|numeric|min:1',
            'isbn' => 'required|min:13',
        ]);

        // if($validate->fails()){
        //     return response(['message' => $validate->errors()], 400);
        // }

        $buku->judul = $updateData['judul'];
        $buku->penerbit = $updateData['penerbit'];
        $buku->tahunTerbit = $updateData['tahunTerbit'];
        $buku->pengarang = $updateData['pengarang'];
        $buku->jumlahHalaman = $updateData['jumlahHalaman'];
        $buku->isbn = $updateData['isbn'];

        if($buku->save()){
            return response([
                'message' => 'Update Buku Success',
                'data' => $buku
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
        $buku = Buku::find($id);

        if(is_null($buku)){
            return response([
                'message' => 'Buku Not Found',
                'data' => null
            ], 404);
        }

        if($buku->delete()){
            return response([
                'message' => 'Delete Buku Success',
                'data' => $buku
            ], 200);
        }

        return response([
            'message' => 'Delete Buku Failed',
            'data' => null
        ], 400);
    }
}
