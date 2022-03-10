<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Http\Requests\SecurityRequest\WorkRoomRequest;
use Illuminate\Http\Request;
use App\Repositories\WorkRoom\WorkRoomRepository;

class WorkRoomController extends Controller
{
    protected $workRoomRepository;

    public function __construct(WorkRoomRepository $workRoomRepository)
    {
        $this->workRoomRepository = $workRoomRepository;
    }

    public function index(Request $request)
    {
        $data = $this->workRoomRepository->getAll();
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

    public function show($id)
    {
        $data = $this->workRoomRepository->find($id);
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Data content list detail.',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data content detail not found.',
            ]);
        }
    }

    public function store(WorkRoomRequest $request)
    {
        $data = $request->all();
        $result = $this->workRoomRepository->create($data);
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

    public function update(WorkRoomRequest $request, $id)
    {
        $data = $request->all();
        $result = $this->workRoomRepository->update($id, $data);
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
        $data = $this->workRoomRepository->search($name);
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
