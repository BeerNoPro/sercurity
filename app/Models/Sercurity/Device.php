<?php

namespace App\Models\Sercurity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Device extends Model
{
    use HasFactory;

    protected $table = 'device';

    protected $fillable = [
        'ip_address',
        'ip_mac',
        'user_login',
        'version_win',
        'version_virus',
        'update_win',
        'member_id',
        'deleted_at'
    ];

    // Get content member
    public function member() {
        return $this->belongsTo('App\Models\Sercurity\Member')
        ->join('company', 'company.id', '=', 'member.company_id')
        ->select('member.*', 'company.id as company_parent_id', 'company.name as company_name', 'company.address as company_address', 'company.email as company_email');
    }
    
}
