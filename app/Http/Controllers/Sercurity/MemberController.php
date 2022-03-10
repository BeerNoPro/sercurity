<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Http\Requests\SecurityRequest\MemberRequest;
use Illuminate\Http\Request;
use App\Repositories\Member\MemberRepository;

class MemberController extends Controller
{
    protected $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function index(Request $request)
    {
        $data = $this->memberRepository->getAll();
        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }
        $index = ($page - 1) * 6 + 1;
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Data lists content.',
                'data' => $data,
                'index' => $index,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data not found.'
            ]);
        }
    }

    public function showForeignKey()
    {
        $data = $this->memberRepository->showForeignKey();
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Data lists content.',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data not found.'
            ]);
        }
    }

    public function edit($id, $company_id = false)
    {
        $data = $this->memberRepository->edit($id, $company_id = false);
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Data lists content.',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data not found.'
            ]);
        }
    }

    public function store(MemberRequest $request)
    {
        $data = $request->all();
        $result = $this->memberRepository->create($data);
        if ($result) {
            return response()->json([
                'status' => 200,
                'message' => 'Data created success.',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data created fail.'
            ]);
        }
    }

    public function update(MemberRequest $request, $id)
    {
        $data = $request->all();
        $result = $this->memberRepository->update($id, $data);
        if ($result) {
            return response()->json([
                'status' => 200,
                'message' => 'Data updated success.',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data updated fail.',
            ]);
        }
    }

    public function search($name) 
    {
        $data = $this->memberRepository->search($name);
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Data content detail list.',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data content detail not found.'
            ]);
        }
    }
}
