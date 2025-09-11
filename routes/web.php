<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\EmployeeController;

// Route login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Middleware per role
Route::middleware(['auth', 'role:admin'])->group(function () {

    // route for view controller dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('admin.dashboard');

    // route for view controller role
    Route::get('/admin/role', [RoleController::class, 'index'])->name('index.role');
    Route::get('/admin/role/add', [RoleController::class, 'role_add'])->name('add.role');
    Route::get('/admin/role/edit/{id},', [RoleController::class, 'role_edit'])->name('edit.role');
    // route for function controller role
    Route::post('/admin/role/store', [RoleController::class, 'store'])->name('store.role');
    Route::post('/role/update/{id}', [RoleController::class, 'update'])->name('update.role');
    // Route::get('/role/delete/{id}', 'delete_role')->name('delete.role')
    
    // route for view controller user
    Route::get('/admin/employee', [EmployeeController::class, 'index'])->name('index.employee');
    Route::get('/admin/employee/add', [EmployeeController::class, 'employee_add'])->name('add.employee');
    Route::get('/admin/employee/edit/{id},', [EmployeeController::class, 'employee_edit'])->name('edit.employee');
    // route for function controller role
    Route::post('/admin/employee/store', [EmployeeController::class, 'store'])->name('store.employee');
    Route::post('/admin/employee/update/{id}', [EmployeeController::class, 'update'])->name('update.employee');
    Route::post('/admin/employee/action/{id}', [EmployeeController::class, 'action'])
    ->name('employee.action');
    // Route::get('/role/delete/{id}', 'delete_role')->name('delete.role');

});

Route::middleware(['auth', 'role:drafter'])->group(function () {
    Route::get('/drafter/dashboard', function () {
        return view('drafter.dashboard.index');
    })->name('drafter.dashboard');
});

Route::middleware(['auth', 'role:checker'])->group(function () {
    Route::get('/checker/dashboard', function () {
        return view('checker.dashboard.index');
    })->name('checker.dashboard');
});