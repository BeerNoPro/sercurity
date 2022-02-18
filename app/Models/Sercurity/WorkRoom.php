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
}
