<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Models\Sercurity\WorkRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = WorkRoom::all();
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Work room list',
                'data' => $data
            ]);

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Work room not found'
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
        $check = WorkRoom::where('name', $request->name)
                        ->where('location', $request->location)
                        ->count();

        if($check > 0 ) { 
            return response()->json([
                'status' => 400,
                'message' => 'Work room already exists.'
            ]);

        } else { 
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'location' => 'required',
            ]);
    
            if($validator->fails()){ 
                return response()->json([
                    'status' => 400,
                    'message' => 'Please fill out the information completely',
                    'error' => $validator->errors()
                ]);
            }
            $data = WorkRoom::create($input);
    
            return response()->json([
                'status' => 200,
                'message' => 'Work room created successfully.',
                'data' => $input
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = WorkRoom::find($id);
        if (is_null($data)) {
            return response()->json([
                'status' => 404,
                'message' => 'Work room not found.'
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Work room retrieved successfully.',
            'data' => $data
        ]);
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
        $WorkRoom = WorkRoom::find($id);

        if ($WorkRoom) {
            $WorkRoom->update($request->all());
            return response()->json([
                'status' => 200,
                'message' => 'Work room updated successfully.',
                'data' => $WorkRoom
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Work room update fail'
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $WorkRoom = WorkRoom::find($id); 
        if ($WorkRoom) {
            $WorkRoom->delete($id);
            return response()->json([
                'status' => 200,
                'message' => 'Work room deleted successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Work room deleted faile'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        $data = WorkRoom::where('name','like','%'.$name.'%')->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Work room detail',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Work room not found'
            ]);
        }
    }
}
