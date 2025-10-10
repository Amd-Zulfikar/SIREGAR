<?php

namespace App\Models\Admin;

use App\Models\Admin\Mgambar;
use Illuminate\Database\Eloquent\Model;

class MgambarOptional extends Model
{
    protected $table = 'tb_mgambar_optional';
    protected $fillable = [
        'mdata_id',
        'file_name',
        'file_path',
        'description',
    ];

    public function mdata()
    {
        return $this->belongsTo(Mdata::class, 'mdata_id');
    }
}
