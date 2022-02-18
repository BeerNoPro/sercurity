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
}
