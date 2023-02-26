<?php

namespace App\Http\Controllers\TestControllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\TestModel\Course;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();
        return response()->json([
            "message" => "successfully fetched all courses data",
            "data"    => $courses
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
        ], [
            'title.required' => 'The title param value is required',
            'description.required' => 'The description param value is required',
        ]);

        if($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()->first()
            ]);
        }

        // Get input values [we need to get user id from jwt]
        $data = [
            'ar_title' => $request->input('title'),
            'ar_user_id' => 1,
            'ar_description' => $request->input('descrption')
        ];

        $course = Course::create($data);

        return response()->json([
            "message" => "Course successfully created",
            "data"    => $course
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
        if(Course::where('ar_id', $id)->exists()) {
            $course = Course::where('ar_id', $id)->first();
        } else {
            return response()->json([
                "message" => "No course for the mentioned id",
                "data" => []
            ], 200);
        }

        return response()->json([
            "message" => "success",
            "data"    => $course
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
        if(!empty($request->input('title'))) $data['ar_title'] = $request->input('title');
        if(!empty($request->input('description'))) $data['ar_description'] = $request->input('description');

        if(Course::where('ar_id', $id)->exists()) {
            Course::where('ar_id', $id)->update($data);
        } else {
            return response()->json([
                "message" => "No course for the mentioned id",
                "data" => []
            ], 200);
        }

        $course_data = Course::where('ar_id', $id)->get();

        return response()->json([
            "message" => "Course updated successfully",
            "data"    => $course_data
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
        if(Course::where('ar_id', $id)->exists()) {
            Course::where('ar_id', $id)->delete();
        } else {
            return response()->json([
                "message" => "No course for the mentioned id",
                "data" => []
            ], 200);
        }

        return response()->json([
            "message" => "course deleted successfully",
        ], 200);
    }
}
