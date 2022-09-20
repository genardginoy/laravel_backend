<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::all();
        return response()->json([
            "message" => "successfully fetched all todo data",
            "data"    => $todos 
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required|in:o,h,c,s'
        ], [
            'title.required' => 'The title param value is required',
            'description.required' => 'The description param value is required',
            'status.required' => 'The status param value is required',
            'status.in' => 'Incorrect status value',
        ]);

        if($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()->first()
            ]);
        }

        // Get input values
        $data = [
            'td_title' => $request->input('title'),
            'td_description' => $request->input('description'),
            'td_status' => $request->input('status')
        ];

        $todo = Todo::create($data);

        return response()->json([
            "message" => "Todo item successfully created",
            "data"    => $todo 
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Todo::where('td_id', $id)->exists()) {
            $todo = Todo::where('td_id', $id)->get();
        } else {
            return response()->json([
                "message" => "No todo item for the mentioned id",
                "data" => []
            ], 200);
        }

        return response()->json([
            "message" => "success",
            "data"    => $todo 
        ], 200);
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
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:o,h,c,s'
        ], [
            'status.in' => 'Incorrect status value',
        ]);

        $data = [];

        if(!empty($request->input('title'))) $data['td_title'] = $request->input('title');
        if(!empty($request->input('description'))) $data['td_description'] = $request->input('description');
        if(!empty($request->input('status'))) $data['td_status'] = $request->input('status');

        if(Todo::where('td_id', $id)->exists()) {
            Todo::where('td_id', $id)->update($data);
        } else {
            return response()->json([
                "message" => "No todo item for the mentioned id",
                "data" => []
            ], 200);
        }

        $todo_data = Todo::where('td_id', $id)->get();

        return response()->json([
            "message" => "Todo item updated successfully",
            "data"    => $todo_data 
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Todo::where('td_id', $id)->exists()) {
            Todo::where('td_id', $id)->delete();
        } else {
            return response()->json([
                "message" => "No todo item for the mentioned id",
                "data" => []
            ], 200);
        }

        return response()->json([
            "message" => "Todo item deleted successfully",
        ], 200);
    }
}
