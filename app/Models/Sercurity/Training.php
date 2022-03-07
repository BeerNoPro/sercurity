<?php

namespace App\Models\Sercurity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Training extends Model
{
    use HasFactory;

    protected $table = 'training';

    protected $fillable = [
        'trainer',
        'project_id',
        'content',
        'deleted_at'
    ];

    // Get content member
    public function member()
    {
        return $this->belongsTo('App\Models\Sercurity\Member', 'trainer');
    }

    // Get content project
    public function project() {
        return $this->belongsTo('App\Models\Sercurity\Project');
    }

}
