<?php
namespace App\Repositories\Project;

use App\Models\Sercurity\Project;
use App\Repositories\EloquentRepository;

class ProjectRepository extends EloquentRepository
{
    public function getModel()
    {
        return Project::class;
    }

    public function getAll()
    {
        $data = Project::with('company')->with('workRoom')->paginate(6);
        return $data ? $data : false;
    }

    public function edit($id, $company_id = false, $work_room_id = false)
    {
        if ($company_id && $work_room_id == false) {
            $data = Project::with('company')->with('workRoom')
            ->where('project.id', $id)
            ->where('project.company_id', $company_id)
            ->get();
            return $data ? $data : false;
        } else if ($work_room_id) {
            $data = Project::with('company')->with('workRoom')
            ->where('project.id', $id)
            ->where('project.work_room_id', $work_room_id)
            ->get();
            return $data ? $data : false;
        } else {
            $data = Project::with('company')->with('workRoom')
            ->where('project.id', $id)
            ->get();
            return $data ? $data : false;
        }
    }

    public function search($name)
    {
        $data = Project::with('company')->with('workRoom')
        ->where('project.name','like','%'.$name.'%')
        ->get();
        return $data ? $data : false;
    }
}
