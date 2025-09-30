<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Mdata extends Model
{
    protected $table = 'tb_mdata';
    protected $fillable = [
        'engine_id',
        'brand_id',
        'chassis_id',
        'vehicle_id',
    ];

    public function engine()
    {
        return $this->belongsTo(Engine::class, 'engine_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class,  'brand_id');
    }

    public function chassis()
    {
        return $this->belongsTo(Chassis::class, 'chassis_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function mgambars()
    {
        return $this->hasMany(Mgambar::class, 'mdata_id');
    }
}
