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
}
