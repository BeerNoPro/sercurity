<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Models\Sercurity\TrainingRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TrainingRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = DB::table('training_room')
        ->join('training', 'training.id', '=', 'training_room.training_id')
        ->join('member', 'member.id', '=', 'training_room.member_id')
        ->select('training_room.*', 'member.id as trained_id', 'member.name as trained_name', 'training.trainer as trainer_id');

        $data2 = DB::table('member')
        ->joinSub($data, 'training_room', function ($join) {
            $join->on('member.id', '=', 'training_room.trainer_id');
        })
        ->select('training_room.*', 'member.name as trainer_name')
        ->paginate(6);

        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }
        $index = ($page - 1) * 6 + 1;

        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Training rooms list.',
                'data' => $data2,
                'index' => $index,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Training room not found.'
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
        $validator = Validator::make($data, [
            'training_id' => 'required',
            'member_id' => 'required',
            'date_start' => 'required',
            'date_completed' => 'required',
            'result' => 'required',
            'note' => 'required',
        ]);
        if($validator->fails()){ 
            return response()->json([
                'status' => 400,
                'message' => 'Please fill out the information completely.',
                'error' => $validator->errors()
            ]);
        } else {
            if (is_null($request->training_id) || is_null($request->member_id)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Check registered project or member, please!'
                ]);
            } else {
                $result = TrainingRoom::create($request->all());
                if ($result) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Training room created successfully.',
                        'data' => $data,
                        'result' => $result
                    ]);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Training room created fail.'
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
        $data = DB::table('training_room')
        ->join('training', 'training.id', '=', 'training_room.training_id')
        ->join('member', 'member.id', '=', 'training_room.member_id')
        ->select('training_room.*', 'member.id as trained_id', 'member.name as trained_name', 'training.trainer as trainer_id')
        ->where('training_room.training_id', $request->training_id)
        ->where('training_room.member_id', $request->member_id);

        $data2 = DB::table('member')
        ->joinSub($data, 'training_room', function ($join) {
            $join->on('member.id', '=', 'training_room.trainer_id');
        })
        ->select('training_room.*', 'member.name as trainer_name')
        ->get();

        if ($data2->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Training room not found.'
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Training room content detail.',
                'data' => $data2
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
    public function save(Request $request, $id1, $id2)
    {
        $training_id = $request->training_id;
        $member_id = $request->member_id;
        $data = DB::table('training_room')
        ->where('training_id', $id1)
        ->where('member_id', $id2)
        ->get();
        if ($data->isNotEmpty()) {
            $input = $request->all();
            $validator = Validator::make($input, [
                'training_id' => 'required',
                'member_id' => 'required',
                'date_start' => 'required',
                'date_completed' => 'required',
                'result' => 'required',
                'note' => 'required',
            ]);
            if($validator->fails()){ 
                return response()->json([
                    'status' => 400,
                    'message' => 'Please fill out the information completely.',
                    'error' => $validator->errors()
                ]);
            } else {
                $result = TrainingRoom::where('training_id', $training_id)
                ->where('member_id', $member_id)
                ->update([
                    'training_id' => $request->training_id,
                    'member_id' => $request->member_id,
                    'date_start' => $request->date_start,
                    'date_completed' => $request->date_completed,
                    'result' => $request->result,
                    'note' => $request->note
                ]);
                if ($result) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Training room updated successfully.',
                    ]);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Training room update fail.',
                        'data' => $data,
                        'input' => $input,
                        'result' => $result,
                    ]);
                }
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Training room not found.',
                'data' => $data,
                'request' => $request->all(),
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
        $data = DB::table('training_room')
        ->join('training', 'training.id', '=', 'training_room.training_id')
        ->join('member', 'member.id', '=', 'training_room.member_id')
        ->select('training_room.*', 'member.id as trained_id', 'member.name as trained_name', 'training.trainer as trainer_id');
        $data2 = DB::table('member')
        ->joinSub($data, 'training_room', function ($join) {
            $join->on('member.id', '=', 'training_room.trainer_id');
        })
        ->select('training_room.*', 'member.name as trainer_name')
        ->where('member.name', 'like', '%'.$name.'%')
        ->get();

        if ($data2->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Training room content detail.',
                'data' => $data2
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Training room not found.'
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

    public function showForeignKeySubQuery()
    {
        $data = DB::table('training')
        ->join('member', 'member.id', '=', 'training.trainer')
        ->select('training.*', 'member.name as trainer_name')->get();
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Data content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data content not found.',
            ]);
        }
    }
}
