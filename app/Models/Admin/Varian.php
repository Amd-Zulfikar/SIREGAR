<?php

namespace App\Models\Admin;

use App\Models\Drafter\Workspace;
use Illuminate\Database\Eloquent\Model;

class Varian extends Model
{
    protected $table = 'tb_varians';
    protected $fillable = [
        'name_utama',
        'name_terurai',
        'name_kontruksi',
        'name_optional',
    ];

    public function workspace()
    {
        return $this->hasMany(Workspace::class, 'varian_id');
    }
    public function getDisplayNameAttribute()
    {
        return $this->name_utama;
    }
}
