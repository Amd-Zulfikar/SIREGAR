<?php

namespace App\Models\Admin;


use App\Models\Drafter\WorkspaceGambar;
use Illuminate\Database\Eloquent\Model;

class Mgambar extends Model
{
    protected $table = 'tb_mgambar';
    protected $fillable = [
        'mdata_id',
        'foto_utama',
        'foto_terurai',
        'foto_kontruksi',
        'foto_optional',
        'keterangan',
    ];

    // protected $casts = [
    //     'foto_body' => 'array',
    // ];

    public function mdata()
    {
        return $this->belongsTo(Mdata::class, 'mdata_id');
    }

    public function workspaceGambar()
    {
        return $this->hasMany(WorkspaceGambar::class, 'mgambar_id');
    }
}
