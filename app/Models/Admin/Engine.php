<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    protected $table = 'tb_engines';
    protected $fillable = [
        'name', 
        'status',
    ];

    public function mdata()
    {
        return $this->hasMany(Mdata::class, 'engine_id');
    }
    
}
