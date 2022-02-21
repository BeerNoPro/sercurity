<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Models\Sercurity\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Member::all();
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Members list.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member not found.'
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
        $check = Member::where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('address', $request->address)
                        ->where('date_join_company', $request->date_join_company)
                        ->count();
        if($check > 0 ) {
            return response()->json([
                'status' => 200,
                'message' => 'Member created successfully.',
                'data' => $data
            ]);
        } else { 
            $validator = Validator::make($data, [
                'name' => 'required',
                'email' => 'required',
                'address' => 'required',
                'phone_number' => 'required',
                'work_position' => 'required',
                'date_join_company' => 'required',
            ]);
            if($validator->fails()){ 
                return response()->json([
                    'status' => 400,
                    'message' => 'Please fill out the information completely',
                    'error' => $validator->errors()
                ]);
            } else {
                if (is_null($request->company_id)) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Company not found. Register company please!',
                    ]);
                } else {
                    $data = Member::create($data);
                    if ($data) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Member created successfully.',
                            'data' => $data
                        ]);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => 'Member created fail.',
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
        $data = Member::find($id);
        if (is_null($data)) {
            return response()->json([
                'status' => 404,
                'message' => 'Member not found.'
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Member content detail.',
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
        $data = Member::find($id);
        if ($data) {
            $result = $data->update($request->all());
            if ($result) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Member updated successfully.',
                    'data' => $data,
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Member update fail.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member not found.'
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
        $data = Member::where('name','like','%'.$name.'%')->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Member content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member not found.'
            ]);
        }
    }
}
