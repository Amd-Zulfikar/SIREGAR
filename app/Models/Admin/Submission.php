<?php

namespace App\Models\Admin;


use App\Models\Drafter\Workspace;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'tb_submissions';
    protected $fillable = [
        'name',
    ];

    public function workspace()
    {
        return $this->hasMany(Workspace::class, 'submission_id');
    }
}
