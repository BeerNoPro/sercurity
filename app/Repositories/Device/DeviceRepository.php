<?php
namespace App\Repositories\Device;

use App\Models\Sercurity\Device;
use App\Repositories\EloquentRepository;

class DeviceRepository extends EloquentRepository
{
    public function getModel()
    {
        return Device::class;
    }

    public function getAll()
    {
        $data = Device::with('member')->paginate(6);
        return $data ? $data : false;
    }

    public function edit($id, $member_id = false)
    {
        if ($member_id) {
            $data = Device::with('member')
            ->where('device.id', $id)
            ->where('device.member_id', $member_id)
            ->get();
            return $data ? $data : false;
        } else {
            $data = Device::with('member')
            ->where('device.id', $id)
            ->get();
            return $data ? $data : false;
        }
    }

    public function search($name)
    {
        $data = Device::query()->with([
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
