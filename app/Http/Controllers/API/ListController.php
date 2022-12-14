<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $lists = Lista::all();
        $lists = DB::select('select * from lists ',);
        return response()->json(['lists' => $lists]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 404);
        }

        // Lista::create($data);
        DB::insert('insert into lists (name, description) values (?, ?)', [$data['name'], $data['description']]);

        return response()->json([], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $list = Lista::find($id);
        $list = DB::select('select * from lists where id = ?', [$id]);

        return response()->json(['data' => $list[0]], 200);
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
        // $list = Lista::find($id);
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 404);
        }

        // $list->update($data);
        DB::update('update lists set name = ?, description = ? where id = ?', [$data['name'],$data['description'], $id]);
        return response()->json(['data' => []], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $list = Lista::find($id);
        $list->delete();

        return response()->json(["operacion" => "seses"], 200);
    }
}
