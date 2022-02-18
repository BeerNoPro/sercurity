<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Models\Sercurity\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Project::all();
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Project list',
                'data' => $data
            ]);

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Project not found'
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
        $check = Project::where('name', $request->name)
                        ->where('time_start', $request->time_start)
                        ->where('company_id', $request->company_id)
                        ->where('work_room_id', $request->work_room_id)
                        ->count();
        if($check > 0 ) { 
            return response()->json([
                'status' => 400,
                'message' => 'Project already exists.'
            ]);
        } else { 
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'time_start' => 'required',
                'time_completed' => 'required',
                'company_id' => '',
                'work_room_id' => '',
            ]);
            if($validator->fails()){ 
                return response()->json([
                    'status' => 400,
                    'message' => 'Please fill out the information completely',
                    'error' => $validator->errors()
                ]);
            } else {
                if (is_null($request->company_id) || is_null($request->work_room_id)) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Check registered company or work room, please!',
                    ]);
                } else {
                    $data = Project::create($input);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Project created successfully.',
                        'data' => $data
                    ]);
                }
            }
        }
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
        $data = Project::find($id);
        if ($data) {
            // check record exists in database?
            $check = Project::where('name', $request->name)
                            ->where('company_id', $request->company_id)
                            ->where('work_room_id', $request->work_room_id)
                            ->count();
            if ($check > 0) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Project already exists.',
                ]);
            } else {
                $data->update($request->all());
                return response()->json([
                    'status' => 200,
                    'message' => 'Project updated successfully.',
                    'data' => $data,
                ]);
            }

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Project update fail'
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
        $data = Project::find($id); 
        if ($data) {
            // $data->delete($id);
            $data = Project::where('id', $id)->update(['deleted_at' => 1]);
            if ($data) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Project deleted successfully.'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Project deleted fail'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Project deleted fail'
            ]);
        }
    }

    /**
     * Search the specified resource from storage.
     *
     * @param  int  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        $data = Project::where('name','like','%'.$name.'%')
                    ->whereNull('deleted_at')
                    ->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Project detail',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Project not found'
            ]);
        }
    }
}
