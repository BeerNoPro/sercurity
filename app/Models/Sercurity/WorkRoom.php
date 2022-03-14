<?php

namespace App\Models\Sercurity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkRoom extends Model
{
    use HasFactory;

    protected $table = 'work_room';

    protected $fillable = [
        'name',
        'location',
        'deleted_at'
    ];

    public function project()
    {
        return $this->hasMany(
            'App\Models\Sercurity\Project',
        );

        // return $this->hasManyThrough(
        //     'App\Models\Sercurity\MemberProject',
        //     'App\Models\Sercurity\Project',
        //     // 'work_room_id',
        //     // 'project_id',
        //     // 'id'
        // );
        // ->where('work_room.id', 'project.project_id');
        // ->join('project', 'work_room.id', '=', 'project.project_id');
        // ->select('work_room.*', 'project.*');
        // ->join('member', 'member.id', '=', 'MemberProject.member_id');
    }
}
