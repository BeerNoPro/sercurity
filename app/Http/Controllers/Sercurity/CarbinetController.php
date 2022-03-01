<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Models\Sercurity\Carbinet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CarbinetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = DB::table('carbinet')
        ->join('work_room', 'work_room.id', '=', 'carbinet.work_room_id')
        ->join('member', 'member.id', '=', 'carbinet.member_id')
        ->select('carbinet.*', 'member.name as member_name', 'work_room.name as work_room_name')
        ->paginate(6);
        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }
        $index = ($page - 1) * 6 + 1;

        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Cabinets content list.',
                'data' => $data,
                'index' => $index
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Cabinet content not found.'
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
        $check = Carbinet::where('name', $request->name)
                        ->where('work_room_id', $request->work_room_id)
                        ->where('member_id', $request->member_id)
                        ->count();
        if($check > 0 ) { 
            return response()->json([
                'status' => 200,
                'message' => 'Cabinet content created successfully.',
                'data' => $data
            ]);
        } else { 
            $validator = Validator::make($data, [
                'name' => 'required',
                'work_room_id' => 'required',
                'member_id' => 'required',
            ]);
            if($validator->fails()){ 
                return response()->json([
                    'status' => 400,
                    'message' => 'Please fill out the information completely.',
                    'error' => $validator->errors()
                ]);
            } else {
                if (is_null($request->member_id)) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Member or work room not found. Register member or work room please!',
                    ]);
                } else {
                    $data = Carbinet::create($data);
                    if ($data) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Carbinet content created successfully.',
                            'data' => $data
                        ]);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => 'Carbinet content created fail.'
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
    public function show($id)
    {
        $data = DB::table('carbinet')
        ->join('work_room', 'work_room.id', '=', 'carbinet.work_room_id')
        ->join('member', 'member.id', '=', 'carbinet.member_id')
        ->select('carbinet.*', 'member.name as member_name', 'work_room.name as work_room_name')
        ->where('carbinet.id', $id)
        ->get();
        if (is_null($data)) {
            return response()->json([
                'status' => 404,
                'message' => 'Cabinet content not found.'
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Cabinet content detail.',
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
        $data = Carbinet::find($id);
        if ($data) {
            // check record exists in database?
            $check = Carbinet::where('name', $request->name)
                            ->where('work_room_id', $request->work_room_id)
                            ->where('member_id', $request->member_id)
                            ->count();
            if ($check > 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Carbinet updated successfully.',
                    'data' => $data,
                ]);
            } else {
                $input = $request->all();
                $validator = Validator::make($input, [
                    'name' => 'required',
                    'work_room_id' => 'required',
                    'member_id' => 'required',
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
                            'message' => 'Carbinet updated successfully.',
                            'data' => $data,
                        ]);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => 'Carbinet updated fail.'
                        ]);
                    }
                }
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Carbinet content not found.'
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
        // $data = Carbinet::where('name','like','%'.$name.'%')->get();
        $data = DB::table('carbinet')
        ->join('work_room', 'work_room.id', '=', 'carbinet.work_room_id')
        ->join('member', 'member.id', '=', 'carbinet.member_id')
        ->select('carbinet.*', 'member.name as member_name', 'work_room.name as work_room_name')
        ->where('carbinet.name','like','%'.$name.'%')
        ->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Carbinet content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Carbinet content not found.',
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
