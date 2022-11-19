<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Note;
class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $note= Note::all();

        if(count($note) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $note
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data'=> null
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

        $validate = Validator::make($storeData,[
            'title' => 'required',
            'note' => 'required',
        ]);

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400);
        }
        $note = Note::create($storeData);

        return response([
            'message' => 'Add Note Success',
            'data'=> $note
        ], 200);
    }
    
    public function show($id)
    {
        $note = Note::find($id);

        if(!is_null($note)){
            return response([
                'message' => 'Retrieve User Success',
                'data' => $note
            ], 200);
        }

        return response([
            'message' => 'User Not Found',
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
        $note = Note::find($id);

        if(is_null($note)){
            return response([
                'message' => 'Note Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();

        $validate = Validator::make($updateData,[
            'title' => 'required',
            'note' => 'required',
        ]);

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400);
        }

        $note->title = $updateData['title'];
        $note->note = $updateData['note'];

        if($note->save()){
            return response([
                'message' => 'Update Note Success',
                'data' => $note
            ], 200);
        }


        return response([
            'message' => 'Update Note Failed',
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
        $note = Note::find($id);

        if(is_null($note)){
            return response([
                'message' => 'Note Not Found',
                'data' => null
            ], 404);
        }

        if($note->delete()){
            return response([
                'message' => 'Delete Note Success',
                'data' => $note
            ], 200);
        }


        return response([
            'message' => 'Delete Note Failed',
            'data' => null
        ], 400);
    }
}
