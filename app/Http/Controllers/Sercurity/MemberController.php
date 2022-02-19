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
                'message' => 'Member list',
                'data' => $data
            ]);

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member not found'
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
        $check = Member::where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('address', $request->address)
                        ->where('date_join_company', $request->date_join_company)
                        ->count();

        if($check > 0 ) {
            return response()->json([
                'status' => 400,
                'message' => 'Member already exists.'
            ]);
        } else { 
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'email' => 'required',
                'passwork' => '',
                'address' => 'required',
                'phone_number' => 'required',
                'work_position' => 'required',
                'date_join_company' => 'required',
                'date_left_company' => '',
                'company_id' => '',
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
                    $data = Member::create($input);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Member created successfully.',
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
        $data = Member::find($id);
        if ($data) {
            // check record exists in database?
            $check = Member::where('name', $request->name)
                        ->where('email', $request->email)
                        ->where('address', $request->address)
                        ->where('date_join_company', $request->date_join_company)
                        ->count();
            if ($check > 0) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Member already exists.',
                ]);
            } else {
                $data->update($request->all());
                return response()->json([
                    'status' => 200,
                    'message' => 'Member updated successfully.',
                    'data' => $data,
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member update fail'
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
        $data = Member::find($id); 
        if ($data) {
            $data = Member::where('id', $id)->update(['deleted_at' => 1]);
            if ($data) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Member deleted successfully.'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Member deleted fail'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member deleted fail'
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
        $data = Member::where('name','like','%'.$name.'%')
                    ->whereNull('deleted_at')
                    ->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Member detail',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member not found'
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
        $data = Member::where('id', $id)
                    ->get();
        if ($data->isNotEmpty()) {
            $restore = Member::where('deleted_at', 1)->update(['deleted_at' => null]);
            if ($restore) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Member restore success',
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Member not found.',
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member not found.'
            ]);
        }
    }
}
