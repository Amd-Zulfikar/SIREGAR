<?php

namespace App\Models\Drafter;

use App\Models\Admin\Mdata;
use App\Models\Admin\Mgambar;
use Illuminate\Database\Eloquent\Model;

class WorkspaceGambar extends Model
{
    protected $table = 'tb_workspace_gambar';

    protected $fillable = [
        'workspace_id',
        'engine',
        'brand',
        'chassis',
        'vehicle',
        'keterangan',
        'foto_body',
    ];

    // Relasi ke Workspace
    public function workspace()
    {
        return $this->belongsTo(Workspace::class, 'workspace_id');
    }

    // Relasi ke Mgambar
    public function mgambar()
    {
        return $this->belongsTo(Mgambar::class, 'mgambar_id');
    }

    public function mdata()
    {
        return $this->belongsTo(Mdata::class, 'engine', 'id');
    }
}
