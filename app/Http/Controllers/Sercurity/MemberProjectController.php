<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Models\Sercurity\MemberProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MemberProject::all();
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Member projects list.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member project not found.'
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'project_id' => 'required',
            'member_id' => 'required',
            'role' => 'required',
            'time_member_join' => 'required',
            'time_member_completed' => 'required',
        ]);
        if($validator->fails()){ 
            return response()->json([
                'status' => 400,
                'message' => 'Please fill out the information completely.',
                'error' => $validator->errors()
            ]);
        } else {
            if (is_null($request->project_id) || is_null($request->member_id)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Check registered project or member, please!',
                ]);
            } else {
                $data = MemberProject::create($input);
                if ($data) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Member project created successfully.',
                        'data' => $data
                    ]);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Member project created fail.',
                    ]);
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
    public function edit(Request $request)
    {
        $data = MemberProject::where('member_id', $request->member_id)
                            ->where('project_id', $request->project_id)
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $project_id = $request->project_id;
        $member_id = $request->member_id;
        $data = MemberProject::where('project_id', $project_id)
                                ->where('member_id', $member_id)
                                ->get();
        if ($data->isNotEmpty()) {
            $data = MemberProject::where('project_id', $project_id)
                                ->where('member_id', $member_id)
                                ->update($request->all());
            if ($data) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Member project updated successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Member project update fail.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member project not found.'
            ]);
        }
    }

    /**
     * Search the specified resource from storage.
     *
     * @param  int  $name
     * @return \Illuminate\Http\Response
     */
    public function search($role)
    {
        $data = MemberProject::where('role','like','%'.$role.'%')->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Member project content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member project not found.'
            ]);
        }
    }
}
