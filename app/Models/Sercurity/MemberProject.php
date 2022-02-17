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
    ];
}
