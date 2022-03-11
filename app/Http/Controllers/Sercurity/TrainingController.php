<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Training\TrainingRepository;
use App\Http\Requests\SecurityRequest\TrainingRequest;

class TrainingController extends Controller
{
    protected $trainingRepository;

    public function __construct(TrainingRepository $trainingRepository)
    {
        $this->trainingRepository = $trainingRepository;
    }

    public function index(Request $request)
    {
        $data = $this->trainingRepository->getAll();
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
        $data = $this->trainingRepository->showForeignKey($name);
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

    public function edit($id, $trainer_id = false, $project_id = false)
    {
        $data = $this->trainingRepository->edit($id, $trainer_id = false, $project_id = false);
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

    public function store(TrainingRequest $request)
    {
        $data = $request->all();
        $result = $this->trainingRepository->create($data);
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

    public function update(TrainingRequest $request, $id)
    {
        $data = $request->all();
        $result = $this->trainingRepository->update($id, $data);
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
        $data = $this->trainingRepository->search($name);
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
