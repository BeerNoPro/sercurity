<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Project\ProjectRepository;
use App\Http\Requests\SecurityRequest\ProjectRequest;

class ProjectController extends Controller
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function index(Request $request)
    {
        $data = $this->projectRepository->getAll();
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
        $data = $this->projectRepository->showForeignKey($name);
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

    public function edit($id, $company_id = false, $work_room_id = false)
    {
        $data = $this->projectRepository->edit($id, $company_id = false, $work_room_id = false);
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

    public function store(ProjectRequest $request)
    {
        $data = $request->all();
        $result = $this->projectRepository->create($data);
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

    public function update(ProjectRequest $request, $id)
    {
        $data = $request->all();
        $result = $this->projectRepository->update($id, $data);
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
        $data = $this->projectRepository->search($name);
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
