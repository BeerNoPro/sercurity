<?php

namespace App\Models\Sercurity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingRoom extends Model
{
    use HasFactory;

    protected $table = 'training_room';

    protected $fillable = [
        'training_id',
        'member_id',
        'date_start',
        'date_completed',
        'result',
        'note',
        'deleted_at'
    ];

    // Get trainer name
    public function training() {
        return $this->belongsTo('App\Models\Sercurity\Training', 'training_id')
        ->join('member', 'member.id', '=', 'training.trainer')
        ->join('project', 'project.id', '=', 'training.project_id')
        ->select('training.*', 'member.name as trainer_name', 'project.name as project_name');
    }

    // Get trained name
    public function trained() {
        return $this->belongsTo('App\Models\Sercurity\Member', 'member_id')
        ->select('member.id', 'member.name');
    }

    // Get content member detail
    public function member() {
        return $this->belongsTo('App\Models\Sercurity\Member')
        ->join('company', 'company.id', '=', 'member.company_id')
        ->select('member.*', 'company.id as company_parent_id', 'company.name as company_name', 'company.address as company_address', 'company.email as company_email');
    }
    
}
