<?php
namespace App\Repositories\WorkRoom;

use App\Models\Sercurity\WorkRoom;
use App\Repositories\EloquentRepository;

class WorkRoomRepository extends EloquentRepository
{
    public function getModel()
    {
        return WorkRoom::class;
    }
}
