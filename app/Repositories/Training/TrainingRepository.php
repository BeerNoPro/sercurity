<?php
namespace App\Repositories\Training;

use App\Models\Sercurity\Training;
use App\Repositories\EloquentRepository;

class TrainingRepository extends EloquentRepository
{
    public function getModel()
    {
        return Training::class;
    }

    public function getAll()
    {
        $data = Training::with('project')->with('member')->paginate(6);
        return $data ? $data : false;
    }

    public function edit($id, $trainer_id = false, $project_id = false)
    {
        if ($trainer_id && $project_id == false) {
            $data = Training::with('member')
            ->where('training.id', $id)
            ->where('training.trainer', $trainer_id)
            ->get();
            return $data ? $data : false;
        } else if ($project_id) {
            $data = Training::with('project')
            ->where('training.id', $id)
            ->where('training.project_id', $project_id)
            ->get();
            return $data ? $data : false;
        } else {
            $data = Training::with('member')->with('project')
            ->where('training.id', $id)
            ->get();
            return $data ? $data : false;
        }
    }

    public function search($name)
    {
        $data = Training::query()->with([
            'member' => function ($query) use ($name) {
                $query->where('member.name','like','%'.$name.'%');
            }
        ])->get();
    
        // Filter value == null
        function filterResult($data)
        {
            for ($i = 0; $i < sizeof($data); $i++) {
                if (is_null($data[$i]->member)) unset($data[$i]);
            }
            return $data;
        }
        filterResult($data);
        return $data ? $data : false;
    }
    
}
