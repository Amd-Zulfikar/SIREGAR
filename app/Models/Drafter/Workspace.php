<?php

namespace App\Models\Drafter;

use App\Models\Admin\Mdata;
use App\Models\Admin\Varian;
use App\Models\Admin\Customer;
use App\Models\Admin\Employee;
use App\Models\Admin\Submission;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    protected $table = 'tb_workspaces';

    protected $fillable = [
        'no_transaksi',
        'customer_id',
        'employee_id',
        'submission_id',
        'varian_id',
        'keterangan',
        'jumlah_gambar',
    ];

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relasi ke Employee (Drafter)
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // Relasi ke Submission
    public function submission()
    {
        return $this->belongsTo(Submission::class, 'submission_id');
    }

    // Relasi ke Varian
    public function varian()
    {
        return $this->belongsTo(Varian::class, 'varian_id');
    }

    // Relasi ke WorkspaceGambar (multi-gambar)
    public function workspaceGambar()
    {
        return $this->hasMany(WorkspaceGambar::class, 'workspace_id', 'id');
    }
}
