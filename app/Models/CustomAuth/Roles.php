<?php

namespace App\Models\CustomAuth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'role_id',
        'role_name',
        'role_description'
    ];

    public function users() {
        return $this->belongsTo('App\Models\User');
    }
}
