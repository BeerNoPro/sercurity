<?php
namespace App\Repositories\MemberProject;

use App\Models\Sercurity\MemberProject;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\DB;

class MemberProjectRepository extends EloquentRepository
{
    public function getModel()
    {
        return MemberProject::class;
    }

    public function getAll()
    {
        $data = MemberProject::with('project')->with('member')->paginate(6);
        return $data ? $data : false;
    }

    public function edit($project_id, $member_id)
    {
        $data = MemberProject::with('project')->with('member')
        ->where('member_project.project_id', $project_id)
        ->where('member_project.member_id', $member_id)
        ->get();
        return $data ? $data : false;
    }

    public function save($project_id, $member_id, array $data)
    {
        $result = MemberProject::where('project_id', $project_id)->where('member_id', $member_id);
        if ($result) {
            $result->update($data);
            return $result;
        }
        return false;
    }

    public function search($name)
    {
        $data = MemberProject::query()->with([
            'project' => function ($query) use ($name) {
                $query->where('project.name','like','%'.$name.'%');
            }
        ])->with('member')->get();

        // Filter value == null
        function filterResult($data)
        {
            for ($i = 0; $i < sizeof($data); $i++) {
                if (is_null($data[$i]->project)) unset($data[$i]);
            }
            return $data;
        }
        filterResult($data);
        return $data ? $data : false;
    }
}
