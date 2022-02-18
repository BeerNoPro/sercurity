<?php

namespace App\Models\Sercurity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
