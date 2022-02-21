<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Models\Sercurity\TrainingRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainingRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TrainingRoom::all();
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Training rooms list.',
                'data' => $data
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
            if (is_null($request->training_id) || is_null($request->member_id)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Check registered project or member, please!',
                ]);
            } else {
                $data = TrainingRoom::create($input);
                if ($data) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Training room created successfully.',
                        'data' => $data
                    ]);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Training room created fail.',
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
        $data = TrainingRoom::where('training_id', $request->training_id)
                            ->where('member_id', $request->member_id)
                            ->get();
        if ($data->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Training room not found.'
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Training room content detail.',
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
        $training_id = $request->training_id;
        $member_id = $request->member_id;
        $data = TrainingRoom::where('training_id', $training_id)
                                ->where('member_id', $member_id)
                                ->get();
        if ($data->isNotEmpty()) {
            $data = TrainingRoom::where('training_id', $training_id)
                                ->where('member_id', $member_id)
                                ->update($request->all());
            if ($data) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Training room updated successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Training room update fail.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Training room not found.',
            ]);
        }
    }

    /**
     * Search the specified resource from storage.
     *
     * @param  int  $name
     * @return \Illuminate\Http\Response
     */
    public function search($date_start)
    {
        $data = TrainingRoom::where('date_start','like','%'.$date_start.'%')->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Training room content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Training room not found.'
            ]);
        }
    }
}
