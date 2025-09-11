<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index() {
        $accounts =User::paginate(5);
        
        return view ('admin.account.index',[
            'title' =>'Data accounts',
            'accounts'=>$accounts,
        ]);
    }
}
