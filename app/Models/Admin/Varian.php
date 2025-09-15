<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Varian extends Model
{
    protected $table = 'tb_varians';
    protected $fillable = [
        'name',
    ];

    public function workspace()
    {
        return $this->hasMany(Workspace::class, 'varian_id');
    }
}
