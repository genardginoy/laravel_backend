<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Todo;
use App\Models\User;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $user =  User::where('id', $user_id)->first();

        return response()->json([
            "message" => "successfully fetched all todo data",
            "data"    => $user->todo()->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id)
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

        $user = User::where('id', $user_id)->first();

        // Get input values
        $todo = new Todo([
            'td_title' => $request->input('title'),
            'td_description' => $request->input('description'),
            'td_status' => $request->input('status')
        ]);

        $user_todo = $user->todo()->save($todo);

        return response()->json([
            "message" => "Todo item successfully created",
            "data"    => $user_todo
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id, $id)
    {
        if(Todo::where('td_id', $id)->exists()) {
            $user = User::where('id', $user_id)->first();
            $user_todo = $user->todo()->where('td_id', $id)->first();
        } else {
            return response()->json([
                "message" => "No todo item for the mentioned id",
                "data" => []
            ], 200);
        }

        return response()->json([
            "message" => "success",
            "data"    => $user_todo
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id, $id)
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
            $user = User::where('id', $user_id)->first();
            $user_todo = $user->todo()->where('td_id', $id)->update($data);
        } else {
            return response()->json([
                "message" => "No todo item for the mentioned id",
                "data" => []
            ], 200);
        }

        $todo_data = Todo::where('td_id', $id)->get();

        return response()->json([
            "message" => "Todo item updated successfully",
            "data"    => $user->todo()->where('td_id', $id)->first()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $id)
    {
        if(Todo::where('td_id', $id)->exists()) {
            $user = User::where('id', $user_id)->first();
            $user->todo()->where('td_id', $id)->delete();
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
