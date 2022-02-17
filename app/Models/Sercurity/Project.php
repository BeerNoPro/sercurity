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
    ];
}
