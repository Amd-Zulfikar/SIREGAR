<?php

namespace App\Models;

use App\Models\Admin\Chassis;
use App\Models\Admin\Vehicle;
use App\Models\Admin\Customer;
use App\Models\Admin\Employee;
use App\Models\Admin\Submission;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $table = 'tb_transaction';

    protected $fillable = [
        'order_no',
        'customer_id',
        'nomor_kementrian',
        'status_kementrian',
        'status_internal',
        'prioritas',
        'chassis_id',
        'vehicle_id',
        'drafter_id',
        'checker_id',
        'submission_id',
        'tanggal_masuk',
    ];

    // Relasi
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function chassis()
    {
        return $this->belongsTo(Chassis::class, 'chassis_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function drafter()
    {
        return $this->belongsTo(Employee::class, 'drafter_id');
    }

    public function checker()
    {
        return $this->belongsTo(Employee::class, 'checker_id');
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class, 'submission_id');
    }
}
