<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\MemberProject\MemberProjectRepository;
use App\Http\Requests\SecurityRequest\MemberProjectRequest;

class MemberProjectController extends Controller
{
    protected $memberProjectRepository;

    public function __construct(MemberProjectRepository $memberProjectRepository)
    {
        $this->memberProjectRepository = $memberProjectRepository;
    }

    public function index(Request $request)
    {
        $data = $this->memberProjectRepository->getAll();
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

    public function showForeignKey($name)
    {
        $data = $this->memberProjectRepository->showForeignKey($name);
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

    public function edit($project_id, $member_id)
    {
        $data = $this->memberProjectRepository->edit($project_id, $member_id);
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

    public function store(MemberProjectRequest $request)
    {
        $data = $request->all();
        $result = $this->memberProjectRepository->create($data);
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

    public function update(MemberProjectRequest $request, $project_id, $member_id)
    {
        $data = $request->all();
        $result = $this->memberProjectRepository->save($project_id, $member_id, $data);
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

    public function search($name)
    {
        $data = $this->memberProjectRepository->search($name);
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
