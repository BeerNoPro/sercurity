<?php
namespace App\Repositories\Cabinet;

use App\Models\Sercurity\Carbinet;
use App\Repositories\EloquentRepository;

class CabinetRepository extends EloquentRepository
{
    public function getModel()
    {
        return Carbinet::class;
    }

    public function getAll()
    {
        $data = Carbinet::with('workRoom')->with('member')->paginate(6);
        return $data ? $data : false;
    }

    public function edit($id, $work_room_id = false, $member_id = false)
    {
        if ($work_room_id && $member_id == false) {
            $data = Carbinet::with('workRoom')
            ->where('carbinet.id', $id)
            ->where('carbinet.work_room_id', $work_room_id)
            ->get();
            return $data ? $data : false;
        } else if ($member_id) {
            $data = Carbinet::with('member')
            ->where('carbinet.id', $id)
            ->where('carbinet.member_id', $member_id)
            ->get();
            return $data ? $data : false;
        } else {
            $data = Carbinet::with('workRoom')->with('member')
            ->where('carbinet.id', $id)
            ->get();
            return $data ? $data : false;
        }
    }

    public function search($name)
    {
        $data = Carbinet::with('workRoom')->with('member')
        ->where('carbinet.name','like','%'.$name.'%')
        ->get();
        return $data ? $data : false;
    }
}
