<?php

namespace App\Models\Admin;


use App\Models\Drafter\Workspace;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'tb_customers';

    protected $fillable = [
        'name',
        'direktur',
        'foto_paraf',
        'status',
    ];

    public function workspaces()
    {
        return $this->hasMany(Workspace::class, 'customer_id');
    }
}
