<?php

namespace App\Models\Admin;

use App\Models\Admin\Mdata;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'tb_vehicles';
    protected $fillable = [
        'name', 
        'status'
    ];

    public function mdata() 
    { 
        return $this->hasMany(Mdata::class, 'vehicle_id'); 
    }
}
