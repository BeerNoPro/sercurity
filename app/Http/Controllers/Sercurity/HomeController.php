<?php

namespace App\Http\Controllers\Sercurity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Home\HomeRepository;

class HomeController extends Controller
{
    protected $homeRepository;

    public function __construct(HomeRepository $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    public function index($id = false)
    {
        if ($id) {
            $data = $this->homeRepository->getAll($id);
            if ($data) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data lists content detail.',
                    'data' => $data,
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data not found.'
                ]);
            }
        } else {
            $data = $this->homeRepository->getAll($id);
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
    }
}
