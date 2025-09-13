<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'tb_employees';

    protected $fillable = [
        'name',
        'contact',
        'foto_paraf',
        'status',
    ];
}
