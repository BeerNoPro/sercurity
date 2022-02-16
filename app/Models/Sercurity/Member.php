<?php

namespace App\Models\Sercurity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'member';

    protected $fillable = [
        'name',
        'email',
        'passwork',
        'address',
        'phone_number',
        'work_position',
        'date_join_company',
        'date_left_company',
        'company_id'
    ];
}
