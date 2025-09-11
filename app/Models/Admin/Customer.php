<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'tb_customers';

    protected $fillable = [
        'name',
        'direktur',
        'foto_paraf',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'customer_id');
    }
}
