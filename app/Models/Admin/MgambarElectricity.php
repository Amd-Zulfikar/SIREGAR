<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class MgambarElectricity extends Model
{
    protected $table = 'tb_mgambar_electricity';
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
