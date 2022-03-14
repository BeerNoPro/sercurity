<?php
namespace App\Repositories\Home;

use App\Models\Sercurity\Project;
use App\Models\Sercurity\WorkRoom;
use Illuminate\Support\Facades\DB;

class HomeRepository 
{
    public function getAll($id = false)
    {
        if ($id) {
            $data = Project::with('company')
            ->with('member')
            ->with('workRoom')
            ->where('project.id', $id)
            ->get();
            return $data ? $data : false;
        } else {
            $data = Project::with('company')
            ->with('member')
            ->with('workRoom')
            ->get();
            return $data ? $data : false;
        }
    }

    public function getWorkRoom() {
        // $data = DB::table('work_room')->get();
        $data = WorkRoom::with('project')
        ->get();
        return $data ? $data : false;
    }

    public function getMember() {
        $data =Project::with('member')->get();
        return $data ? $data : false;
    }
}
