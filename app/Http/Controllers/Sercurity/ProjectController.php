<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Models\Sercurity\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Project::with('company')->with('workRoom')->paginate(6);
        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }
        $index = ($page - 1) * 6 + 1;
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Projects list.',
                'data' => $data,
                'index' => $index,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Project not found.'
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
        $data = $request->all();
        // Check record exists in database?
        $check = Project::where('name', $request->name)
        ->where('time_start', $request->time_start)
        ->where('company_id', $request->company_id)
        ->where('work_room_id', $request->work_room_id)
        ->count();
        if($check > 0 ) { 
            return response()->json([
                'status' => 200,
                'message' => 'Project created successfully.',
                'data' => $data
            ]);
        } else { 
            $validator = Validator::make($data, [
                'name' => 'required',
                'time_start' => 'required',
                'time_completed' => 'required',
                'company_id' => 'required',
                'work_room_id' => 'required',
            ]);
            if($validator->fails()){ 
                return response()->json([
                    'status' => 400,
                    'message' => 'Please fill out the information completely.',
                    'error' => $validator->errors()
                ]);
            } else {
                if (is_null($request->company_id) || is_null($request->work_room_id)) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Check registered company or work room, please!',
                    ]);
                } else {
                    $data = Project::create($data);
                    if ($data) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Project created successfully.',
                            'data' => $data
                        ]);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => 'Project created fail.'
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $company_id = false, $work_room_id = false)
    {
        if ($company_id && $work_room_id == false) {
            $data = Project::with('company')->with('workRoom')
            ->where('project.id', $id)
            ->where('project.company_id', $company_id)
            ->get();
            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Company not found.'
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Company content detail.',
                'data' => $data
            ]);
        } else if ($work_room_id) {
            $data = Project::with('company')->with('workRoom')
            ->where('project.id', $id)
            ->where('project.work_room_id', $work_room_id)
            ->get();
            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Work room not found.'
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Work room content detail.',
                'data' => $data
            ]);
        } else {
            $data = Project::with('company')->with('workRoom')
            ->where('project.id', $id)
            ->get();
            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Project not found.'
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Project content detail.',
                'data' => $data
            ]);
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
                    'status' => 200,
                    'message' => 'Project updated successfully.',
                ]);
            } else {
                $input = $request->all();
                $validator = Validator::make($input, [
                    'name' => 'required',
                    'time_start' => 'required',
                    'time_completed' => 'required',
                    'company_id' => 'required',
                    'work_room_id' => 'required',
                ]);
                if($validator->fails()){ 
                    return response()->json([
                        'status' => 400,
                        'message' => 'Please fill out the information completely.',
                        'error' => $validator->errors()
                    ]);
                } else {
                    $result = $data->update($request->all());
                    if ($result) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Project updated successfully.'
                        ]);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => 'Project updated fail.'
                        ]);
                    }
                }
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Project not found.'
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
        $data = Project::with('company')->with('workRoom')
        ->where('project.name','like','%'.$name.'%')
        ->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Project content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Project not found.'
            ]);
        }
    }

    /**
     * Select the specified resource from storage.
     *
     * @param  int  $name
     * @return \Illuminate\Http\Response
     */
    public function showForeignKey($name)
    {
        $data = DB::table($name)
        ->select($name . '.name', $name . '.id')
        ->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => $name . ' content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => $name . ' not found.',
            ]);
        }
    }
}
