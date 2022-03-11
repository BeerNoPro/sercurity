<?php
namespace App\Repositories\TrainingRoom;

use App\Models\Sercurity\TrainingRoom;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\DB;

class TrainingRoomRepository extends EloquentRepository
{
    public function getModel()
    {
        return TrainingRoom::class;
    }

    public function getAll()
    {
        $data = TrainingRoom::with('training')->with('trained')->paginate(6);
        return $data ? $data : false;
    }

    public function showForeignKeySubQuery()
    {
        $data = DB::table('training')
        ->join('member', 'member.id', '=', 'training.trainer')
        ->select('training.*', 'member.name as trainer_name')->get();
        return $data ? $data : false;
    }

    public function edit($training_id, $member_id)
    {
        $data = TrainingRoom::with('training')
        ->with('trained')
        ->where('training_room.training_id', $training_id)
        ->where('training_room.member_id', $member_id)
        ->get();
        return $data ? $data : false;
    }

    public function save($training_id, $member_id, array $data)
    {
        $result = TrainingRoom::where('training_id', $training_id)->where('member_id', $member_id);
        if ($result) {
            $result->update($data);
            return $result;
        }
        return false;
    }

    public function search($name)
    {
        $data = TrainingRoom::query()->with([
            'training' => function ($query) use ($name) {
                $query->where('member.name','like','%'.$name.'%');
            }
        ])->get();

        // Filter value == null
        function filterResult($data)
        {
            for ($i = 0; $i < sizeof($data); $i++) {
                if (is_null($data[$i]->training)) unset($data[$i]);
            }
            return array($data);
        }
        filterResult($data);
        return $data ? $data : false;
    }
}
