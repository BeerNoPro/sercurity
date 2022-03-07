<?php

namespace App\Models\Sercurity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberProject extends Model
{
    use HasFactory;

    protected $table = 'member_project';

    protected $fillable = [
        'project_id',
        'member_id',
        'role',
        'time_member_join',
        'time_member_completed',
        'deleted_at'
    ];

    // Get content member
    public function member() {
        return $this->belongsTo('App\Models\Sercurity\Member');
    }

    // Get content project
    public function project() {
        return $this->belongsTo('App\Models\Sercurity\Project');
    }
    
}
