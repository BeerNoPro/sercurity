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
                'message' => 'Member project list',
                'data' => $data
            ]);

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member project not found'
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
                'message' => 'Please fill out the information completely',
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
                return response()->json([
                    'status' => 200,
                    'message' => 'Member project created successfully.',
                    'data' => $data
                ]);
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
    // public function save(Request $request, $project_id, $member_id)
    // {
    //     $data = MemberProject::where('project_id', $project_id)
    //                             ->where('member_id', $member_id)
    //                             ->get();
    //     if ($data->isNotEmpty()) {
    //         MemberProject::where('project_id', $project_id)
    //                             ->where('member_id', $member_id)
    //                             ->update(['role' => $request->role]);
    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'Member project updated successfully.',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 404,
    //             'message' => 'Member project update fail.'
    //         ]);
    //     }
    // }
    public function save(Request $request)
    {
        $project_id = $request->project_id;
        $member_id = $request->member_id;
        $data = MemberProject::where('project_id', $project_id)
                                ->where('member_id', $member_id)
                                ->get();
        if ($data->isNotEmpty()) {
            MemberProject::where('project_id', $project_id)
                                ->where('member_id', $member_id)
                                ->update(['role' => $request->role]);
            return response()->json([
                'status' => 200,
                'message' => 'Member project updated successfully.',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member project update fail.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $project_id = $request->project_id;
        $member_id = $request->member_id;
        $data = MemberProject::where('project_id', $project_id)
                                ->where('member_id', $member_id)
                                ->get();
        if ($data->isNotEmpty()) {
            MemberProject::where('project_id', $project_id)
                                ->where('member_id', $member_id)
                                ->update(['deleted_at' => 1]);
            return response()->json([
                'status' => 200,
                'message' => 'Member project deleted successfully.',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member project deleted fail.'
            ]);
        }
    }
}
