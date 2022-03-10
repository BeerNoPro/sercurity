<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use App\Http\Requests\SecurityRequest\CompanyRequest;
use Illuminate\Http\Request;
use App\Repositories\Company\CompanyRepository;

class CompanyController extends Controller
{
    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index(Request $request)
    {
        $data = $this->companyRepository->getAll();
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
        $data = $this->companyRepository->find($id);
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

    public function store(CompanyRequest $request)
    {
        $data = $request->all();
        $result = $this->companyRepository->create($data);
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

    public function update(CompanyRequest $request, $id)
    {
        $data = $request->all();
        $result = $this->companyRepository->update($id, $data);
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
        $data = $this->companyRepository->search($name);
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
