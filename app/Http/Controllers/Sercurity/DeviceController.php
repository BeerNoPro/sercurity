<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Models\Sercurity\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Device::all();
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Devices content list.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Device content not found.'
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
        $check = Device::where('ip_address', $request->ip_address)
                        ->where('ip_mac', $request->ip_mac)
                        ->where('user_login', $request->user_login)
                        ->where('member_id', $request->member_id)
                        ->count();
        if($check > 0 ) { 
            return response()->json([
                'status' => 200,
                'message' => 'Device content created successfully.',
                'data' => $data
            ]);
        } else { 
            $validator = Validator::make($data, [
                'ip_address' => 'required',
                'user_login' => 'required',
                'version_virus' => 'required',
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
                        'message' => 'Member not found. Register member please!',
                    ]);
                } else {
                    $data = Device::create($data);
                    if ($data) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Device content created successfully.',
                            'data' => $data
                        ]);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => 'Device content created fail.',
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
        $data = Device::find($id);
        if (is_null($data)) {
            return response()->json([
                'status' => 404,
                'message' => 'Device content not found.'
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Device content detail.',
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
        $data = Device::find($id);
        if ($data) {
            // check record exists in database?
            $check = Device::where('ip_address', $request->ip_address)
                            ->where('user_login', $request->user_login)
                            ->where('member_id', $request->member_id)
                            ->count();
            if ($check > 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Device updated successfully.',
                    'data' => $data
                ]);
            } else {
                $result = $data->update($request->all());
                if ($result) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Device updated successfully.',
                        'data' => $data
                    ]);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Device updated fail.'
                    ]);
                }
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Device content not found.'
            ]);
        }
    }

    /**
     * Search the specified resource from storage.
     *
     * @param  int  $name
     * @return \Illuminate\Http\Response
     */
    public function search($user_login)
    {
        $data = Device::where('user_login','like','%'.$user_login.'%')->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Device content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Device content not found.',
            ]);
        }
    }
}
