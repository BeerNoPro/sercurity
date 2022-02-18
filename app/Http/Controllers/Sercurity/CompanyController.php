<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Models\Sercurity\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Company::all();
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Company list',
                'data' => $data
            ]);

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Company not found'
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
        $check = Company::where('name', $request->name)
                        ->where('address', $request->address)
                        ->where('email', $request->email)
                        ->count();
        
        if ($check > 0) {
            return response()->json([
                'status' => 400,
                'message' => 'Company already exists.'
            ]);
            
        } else {
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
                    'message' => 'Please fill out the information completely',
                    'error' => $validator->errors()
                ]);
            }
            $data = Company::create($input);
    
            return response()->json([
                'status' => 200,
                'message' => 'Company created successfully.',
                'data' => $data
            ]);
        }

    }

    /**
     * Display the specified resource.
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
            'message' => 'Company retrieved successfully.',
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
            $check = Company::where('name', $request->name)
                        ->where('address', $request->address)
                        ->where('email', $request->email)
                        ->count();
            if ($check > 0) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Company already exists.',
                ]);
            } else {
                $data->update($request->all());
                return response()->json([
                    'status' => 200,
                    'message' => 'Company updated successfully.',
                    'data' => $data,
                ]);
            }

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Company update fail'
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
        $company = Company::find($id); 
        if ($company) {
            $data = Company::where('id', $id)
                        ->update(['deleted_at' => 1]);
            if ($data) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Company deleted successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Company deleted fail.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Company deleted fail.'
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
        $data = Company::where('name','like','%'.$name.'%')
                    ->whereNull('deleted_at')
                    ->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Company detail',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Company not found'
            ]);
        }
    }
}
