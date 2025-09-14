<?php

namespace App\Models\Admin;

use App\Models\Admin\Mdata;
use Illuminate\Database\Eloquent\Model;

class Mgambar extends Model
{
    protected $table = 'tb_mgambar';
    protected $fillable = [
        'mdata_id',
        'foto_body',
        'keterangan',
        'status',
    ];

    public function mdata() 
    { 
        return $this->belongsTo(Mdata::class, 'mdata_id'); 
    }
}
