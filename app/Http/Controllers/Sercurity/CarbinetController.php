<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Cabinet\CabinetRepository;
use App\Http\Requests\SecurityRequest\CabinetRequest;

class CarbinetController extends Controller
{
    protected $cabinetRepository;

    public function __construct(CabinetRepository $cabinetRepository)
    {
        $this->cabinetRepository = $cabinetRepository;
    }

    public function index(Request $request)
    {
        $data = $this->cabinetRepository->getAll();
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
        $data = $this->cabinetRepository->showForeignKey($name);
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

    public function edit($id, $work_room_id = false, $member_id = false)
    {
        $data = $this->cabinetRepository->edit($id, $work_room_id = false, $member_id = false);
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

    public function store(CabinetRequest $request)
    {
        $data = $request->all();
        $result = $this->cabinetRepository->create($data);
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

    public function update(CabinetRequest $request, $id)
    {
        $data = $request->all();
        $result = $this->cabinetRepository->update($id, $data);
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
        $data = $this->cabinetRepository->search($name);
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
