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
        return $this->hasMany('App\Models\Sercurity\Project', 'work_room_id');
    }

    public function member()
    {
        return $this->hasManyThrough(
            'App\Models\Sercurity\MemberProject',
            'App\Models\Sercurity\Project',
            'work_room_id',
            'project_id',
            'id'
        )
        ->join('member', 'member.id', '=', 'member_project.member_id')
        ->join('company', 'company.id', '=', 'member.company_id')
        ->select('project.work_room_id', 'project.id as project_id', 'member_project.member_id', 'member.name as member_name', 'member.company_id', 'company.name as company_name');
    }
}
