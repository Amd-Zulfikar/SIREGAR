<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

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
    Route::post('/admin/role/update/{id}', [RoleController::class, 'update'])->name('update.role');

    // route for view controller Employee
    Route::get('/admin/employee', [EmployeeController::class, 'index'])->name('index.employee');
    Route::get('/admin/employee/add', [EmployeeController::class, 'employee_add'])->name('add.employee');
    Route::get('/admin/employee/edit/{id},', [EmployeeController::class, 'employee_edit'])->name('edit.employee');
    // route for function controller employee
    Route::post('/admin/employee/store', [EmployeeController::class, 'store'])->name('store.employee');
    Route::post('/admin/employee/update/{id}', [EmployeeController::class, 'update'])->name('update.employee');
    Route::post('/admin/employee/action/{id}', [EmployeeController::class, 'action'])
        ->name('employee.action');

    // route for view controller Customer
    Route::get('/admin/customer', [CustomerController::class, 'index'])->name('index.customer');
    Route::get('/admin/customer/add', [CustomerController::class, 'customer_add'])->name('add.customer');
    Route::get('/admin/customer/edit/{id},', [CustomerController::class, 'customer_edit'])->name('edit.customer');
    // route for function controller customer
    Route::post('/admin/customer/store', [CustomerController::class, 'store'])->name('store.customer');
    Route::post('/admin/customer/update/{id}', [CustomerController::class, 'update'])->name('update.customer');
    Route::post('/admin/customer/action/{id}', [CustomerController::class, 'action'])
        ->name('customer.action');

    // route for view controller Account
    Route::get('/admin/account', [App\Http\Controllers\Admin\AccountController::class, 'index'])->name('index.account');
    Route::get('/admin/account/add', [App\Http\Controllers\Admin\AccountController::class, 'account_add'])->name('add.account');
    Route::get('/admin/account/edit/{id},', [App\Http\Controllers\Admin\AccountController::class, 'account_edit'])->name('edit.account');
    // route for function controller account
    Route::post('/admin/account/store', [App\Http\Controllers\Admin\AccountController::class, 'store'])->name('store.account');
    Route::post('/admin/account/update/{id}', [App\Http\Controllers\Admin\AccountController::class, 'update'])->name('update.account');

    Route::post('/admin/account/action/{id}', [App\Http\Controllers\Admin\AccountController::class, 'action'])->name('account.action');
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
