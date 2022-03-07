<?php

namespace App\Models\Sercurity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carbinet extends Model
{
    use HasFactory;

    protected $table = 'carbinet';

    protected $fillable = [
        'name',
        'work_room_id',
        'member_id',
        'deleted_at'
    ];

    // Get content work room
    public function workRoom() {
        return $this->belongsTo('App\Models\Sercurity\WorkRoom');
    }

    // Get content member
    public function member() {
        return $this->belongsTo('App\Models\Sercurity\Member')
        ->join('company', 'company.id', '=', 'member.company_id')
        ->select('member.*', 'company.id as company_parent_id', 'company.name as company_name', 'company.address as company_address', 'company.email as company_email');
    }
}
