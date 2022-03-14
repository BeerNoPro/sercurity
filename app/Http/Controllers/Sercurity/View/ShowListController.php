<?php

namespace App\Http\Controllers\Sercurity\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Home\HomeRepository;

class ShowListController extends Controller
{
    // Function show all list content view
    protected $homeRepository;

    public function __construct(HomeRepository $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    public function index()
    {
        // $data = $this->homeRepository->getAll($id = false);
        $data = $this->homeRepository->getWorkRoom();
        $member = $this->homeRepository->getMember();
        
        return response()->json([
            'status' => 200,
            'data' => $data,
            // 'member' => $member,
        ]); die();

        // if ($data) {
        //     return response()->json([
        //         'status' => 200,
        //         'message' => 'Data lists content.',
        //         'data' => $data,
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => 404,
        //         'message' => 'Data not found.'
        //     ]);
        // }
    }
}
