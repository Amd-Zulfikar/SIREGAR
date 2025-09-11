<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table='tb_employees';
    protected $fillable=[
        'name',
        'contact',
        'foto_paraf',
        'status'
    ];
    public function accounts(){ return $this->hasMany(Account::class,'employee_id'); }
}
