<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'tb_accounts';

    protected $fillable = [
        'user_id',
        'employee_id',
        'customer_id',
        'role_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
