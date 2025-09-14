<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Chassis extends Model
{
    protected $table = 'tb_chassiss';
    protected $fillable = [
        'name', 
        'status',
    ];

    public function mdata() 
    { 
        return $this->hasMany(Mdata::class, 'chassis_id'); 
    }
}
