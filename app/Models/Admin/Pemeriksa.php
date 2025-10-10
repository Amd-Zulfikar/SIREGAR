<?php

namespace App\Models\Admin;

use App\Models\Drafter\Workspace;
use Illuminate\Database\Eloquent\Model;

class Pemeriksa extends Model
{
    protected $table = 'tb_pemeriksa';

    protected $fillable = [
        'name',
        'foto_paraf',
    ];
    public $timestamps = true;

    public function workspaces()
    {
        return $this->hasMany(Workspace::class, 'pemeriksa_id');
    }
}
