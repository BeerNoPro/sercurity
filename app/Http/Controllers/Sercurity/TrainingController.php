<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Models\Sercurity\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Training::all();
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Training list',
                'data' => $data
            ]);

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Training not found'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check record exists in database?
        $check = Training::where('trainer', $request->trainer)
                        ->where('content', $request->content)
                        ->where('project_id', $request->project_id)
                        ->where('deleted_at','<>','null')
                        ->count();

        if($check > 0 ) { 
            // $checkDelete = Training::where('deleted_at','<>','null')->count();
            // $null = $checkDelete->deleted_at;
            return response()->json([
                'status' => 400,
                'message' => 'Training already exists.',
                'checkDelete' => $check,
                // 'null' => $null
            ]);
        } else { 
            $input = $request->all();
            $validator = Validator::make($input, [
                'trainer' => '',
                'content' => 'required',
                'project_id' => '',
            ]);
            if($validator->fails()){ 
                return response()->json([
                    'status' => 400,
                    'message' => 'Please fill out the information completely',
                    'error' => $validator->errors()
                ]);
            } else {
                if (is_null($request->trainer) || is_null($request->project_id)) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Member trainer or project not found. Register member or project please!',
                    ]);
                } else {
                    // $data = Training::create($input);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Training created successfully.',
                        'data' => $input
                    ]);
                }
            }
        }
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $data = Training::find($id);
    //     if ($data) {
    //         // check record exists in database?
    //         $check = Training::where('trainer', $request->trainer)
    //                         ->where('content', $request->content)
    //                         ->count();
    //         if ($check > 0) {
    //             return response()->json([
    //                 'status' => 400,
    //                 'message' => 'Training already exists.',
    //             ]);
    //         } else {
    //             $data->update($request->all());
    //             return response()->json([
    //                 'status' => 200,
    //                 'message' => 'Training updated successfully.',
    //                 'data' => $data,
    //             ]);
    //         }

    //     } else {
    //         return response()->json([
    //             'status' => 404,
    //             'message' => 'Project update fail'
    //         ]);
    //     }
    // }
}
