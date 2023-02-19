<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Comment;
use App\Models\Todo;
// use Illuminate\Support\Facades\Storage;

class TestFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function processFileInput(Request $request)
    {

        // $input_file = $request->getContent();  // [for accepting binary file content from postman]

        $input_file =  $request->file('input_file'); // [for accepting form data file request postman]

        $data = [
            'real_path' => $input_file->getRealPath(),
            'client_original_file_name' => $input_file->getClientOriginalName(),
            'client_original_extension' => $input_file->getClientOriginalExtension(),
            'file_size' => $input_file->getSize(),
            'mime_type' => $input_file->getMimeType()
        ];

        $input_file->move(storage_path('app'), 'new_file_upload.txt');

        // Storage::disk('s3')->size($file_path);

        return response()->json([
            "message" => "Got file object",
            "data"    => $data
        ], 200);


        // sample output

        // {
        //     "message": "Got file object",
        //     "data": {
        //         "real_path": "/tmp/phpsmbyrU",
        //         "client_original_file_name": "todo.txt",
        //         "client_original_extension": "txt",
        //         "file_size": 1645,                          // bytes
        //         "mime_type": "text/plain"
        //     }
        // }

    }

}
