<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
         if (Auth::check()) {
            return view('admin.dashboard.index');
        }
        return redirect()->route('admin.dashboard');
       
    }
}
