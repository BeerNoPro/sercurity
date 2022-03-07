<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Models\Sercurity\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Training::with('project')->with('member')
        ->paginate(6);
        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }
        $index = ($page - 1) * 6 + 1;
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Trainings content list.',
                'data' => $data,
                'index' => $index
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Training not found.'
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
        // check record exists in database?
        $check = Training::where('trainer', $request->trainer)
        ->where('project_id', $request->project_id)
        ->where('content', $request->content)
        ->count();
        if($check > 0 ) { 
            return response()->json([
                'status' => 200,
                'message' => 'Training content created successfully.',
                'data' => $data
            ]);
        } else { 
            $validator = Validator::make($data, [
                'trainer' => 'required',
                'content' => 'required',
                'project_id' => 'required',
            ]);
            if($validator->fails()){ 
                return response()->json([
                    'status' => 400,
                    'message' => 'Please fill out the information completely.',
                    'error' => $validator->errors()
                ]);
            } else {
                if (is_null($request->trainer) || is_null($request->project_id)) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Member trainer or project not found. Register member or project please!',
                    ]);
                } else {
                    $result = Training::create($data);
                    if ($result) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Training content created successfully.',
                            'data' => $data
                        ]);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => 'Training content created fail.',
                            'data' => $data
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
    public function edit($id, $trainer_id = false, $project_id = false)
    {
        if ($trainer_id && $project_id == false) {
            $data = Training::with('member')
            ->where('training.id', $id)
            ->where('training.trainer', $trainer_id)
            ->get();
            if (is_null($data)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Trainer not found.'
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Trainer content detail.',
                'data' => $data
            ]);
        } else if ($project_id) {
            $data = Training::with('project')
            ->where('training.id', $id)
            ->where('training.project_id', $project_id)
            ->get();
            if (is_null($data)) {
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
        } else {
            $data = Training::with('member')->with('project')
            ->where('training.id', $id)
            ->get();
            if (is_null($data)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Training not found.'
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Training content detail.',
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
        $data = Training::find($id);
        if ($data) {
            // check record exists in database?
            $check = Training::where('trainer', $request->trainer)
            ->where('project_id', $request->project_id)
            ->where('content', $request->content)
            ->count();
            if ($check > 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Training updated successfully.',
                ]);
            } else {
                $input = $request->all();
                $validator = Validator::make($input, [
                    'trainer' => 'required',
                    'content' => 'required',
                    'project_id' => 'required',
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
                            'message' => 'Training updated successfully.',
                            'data' => $data,
                        ]);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => 'Training updated fail.',
                        ]);
                    }
                }
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Training content not found.'
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
        $data = Training::query()->with([
            'member' => function ($query) use ($name) {
                $query->where('member.name','like','%'.$name.'%');
            }
        ])->get();

        // Filter value == null
        function filterResult($data)
        {
            for ($i = 0; $i < sizeof($data); $i++) {
                if (is_null($data[$i]->member)) unset($data[$i]);
            }
            return $data;
        }
        filterResult($data);

        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Training content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Training content not found.',
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
