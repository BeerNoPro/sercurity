<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Models\Sercurity\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = DB::table('company')->paginate(6);
        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }
        $index = ($page - 1) * 6 + 1;
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Companies list.',
                'data' => $data,
                'index' => $index
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Company not found.'
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
        $check = Company::where('name', $request->name)
                        ->where('address', $request->address)
                        ->where('email', $request->email)
                        ->count();
        if ($check > 0) {
            return response()->json([
                'status' => 200,
                'message' => 'Company created successfully.',
                'data' => $data
            ]);
        } else {
            $validator = Validator::make($data, [
                'name' => 'required',
                'address' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'date_incorporation' => 'required',
            ]);
            if($validator->fails()){ 
                return response()->json([
                    'status' => 400,
                    'message' => 'Please fill out the information completely.',
                    'error' => $validator->errors()
                ]);
            }
            $data = Company::create($data);
            if ($data) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Company created successfully.',
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Company created fail.'
                ]);
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
        $data = Company::find($id);
        if (is_null($data)) {
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
        $data = Company::find($id);
        if ($data) {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'address' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'date_incorporation' => 'required',
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
                        'message' => 'Company updated successfully.',
                        'data' => $data,
                    ]);
                } else {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Company updated fail.',
                    ]);
                }
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Company not found.'
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
        $data = Company::where('name','like','%'.$name.'%')->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Company content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Company not found.'
            ]);
        }
    }
}
