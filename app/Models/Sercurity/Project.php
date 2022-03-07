<?php

namespace App\Models\Sercurity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'project';

    protected $fillable = [
        'name',
        'time_start',
        'time_completed',
        'company_id',
        'work_room_id',
        'deleted_at'
    ];

    // Get content company
    public function company() {
        return $this->belongsTo('App\Models\Sercurity\Company');
    }

    // Get content work room
    public function workRoom() {
        return $this->belongsTo('App\Models\Sercurity\WorkRoom');
    }

    // Get content member
    public function member() {
        return $this->belongsToMany('App\Models\Sercurity\Member');
    }
}
