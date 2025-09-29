<?php

namespace App\Models\Admin;


use App\Models\Drafter\Workspace;
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
    public $timestamps = true;

    public function workspaces()
    {
        return $this->hasMany(Workspace::class, 'employee_id');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
