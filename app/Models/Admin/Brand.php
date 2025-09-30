<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'tb_brands';
    protected $fillable = [
        'name',
    ];

    public function mdata()
    {
        return $this->hasMany(Mdata::class, 'brand_id');
    }
}
