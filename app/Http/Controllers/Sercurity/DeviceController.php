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
                'message' => 'Device list',
                'data' => $data
            ]);

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Device not found'
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
        $check = Device::where('ip_address', $request->ip_address)
                        ->where('ip_mac', $request->ip_mac)
                        ->where('user_login', $request->user_login)
                        ->where('member_id', $request->member_id)
                        ->count();
        if($check > 0 ) { 
            return response()->json([
                'status' => 400,
                'message' => 'Device already exists.',
            ]);
        } else { 
            $input = $request->all();
            $validator = Validator::make($input, [
                'ip_address' => 'required',
                'ip_mac' => '',
                'user_login' => 'required',
                'version_win' => '',
                'version_virus' => 'required',
                'update_win' => '',
                'member_id' => 'required',
            ]);
            if($validator->fails()){ 
                return response()->json([
                    'status' => 400,
                    'message' => 'Please fill out the information completely',
                    'error' => $validator->errors()
                ]);
            } else {
                if (is_null($request->member_id)) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Member not found. Register member please!',
                    ]);
                } else {
                    $data = Device::create($input);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Device content created successfully.',
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
        $data = Device::find($id);
        if ($data) {
            // check record exists in database?
            $check = Device::where('ip_address', $request->ip_address)
                            ->where('user_login', $request->user_login)
                            ->where('member_id', $request->member_id)
                            ->count();
            if ($check > 0) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Device already exists.',
                ]);
            } else {
                $data->update($request->all());
                return response()->json([
                    'status' => 200,
                    'message' => 'Device updated successfully.',
                    'data' => $data,
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Device content update fail.'
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
        $data = Device::find($id); 
        if ($data) {
            $data = Device::where('id', $id)->update(['deleted_at' => 1]);
            if ($data) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Device content deleted successfully.'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Device content deleted fail'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Device content deleted fail'
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
        $data = Device::where('user_login','like','%'.$user_login.'%')
                        ->whereNull('deleted_at')
                        ->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Device content detail',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Device not found.',
            ]);
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $data = Device::where('id', $id)
                    ->get();
        if ($data->isNotEmpty()) {
            $restore = Device::where('deleted_at', 1)->update(['deleted_at' => null]);
            if ($restore) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Device restore success',
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Device not found.',
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Device not found.'
            ]);
        }
    }
}
