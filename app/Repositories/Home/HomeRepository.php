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
            $data = WorkRoom::with('project')
            ->with('member')
            ->where('work_room.id', $id)
            ->get();
            return $data ? $data : false;
        } else {
            $data = WorkRoom::with('project')
            ->with('member')
            ->get();
            return $data ? $data : false;
        }
    }

    public function member($id) 
    {
        $data = Project::with('memberCompany')
            ->where('project.id', $id)
            ->get();
        return $data ? $data : false;
    }
}
