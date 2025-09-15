<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\SubmissionController;

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

    // route for view controller submission
    Route::get('/admin/submission', [SubmissionController::class, 'index'])->name('index.submission');
    Route::get('/admin/submission/add', [SubmissionController::class, 'submission_add'])->name('add.submission');
    Route::get('/admin/submission/edit/{id}', [SubmissionController::class, 'submission_edit'])->name('edit.submission');
    // route for function controller submission
    Route::post('/admin/submission/store', [SubmissionController::class, 'store'])->name('store.submission');
    Route::post('/admin/submission/update/{id}', [SubmissionController::class, 'update'])->name('update.submission');

    // route for function controller varian
    Route::get('/admin/varian', [App\Http\Controllers\Admin\VarianController::class, 'index'])->name('index.varian');
    Route::get('/admin/varian/add', [App\Http\Controllers\Admin\VarianController::class, 'varian_add'])->name('add.varian');
    Route::get('/admin/varian/edit/{id}', [App\Http\Controllers\Admin\VarianController::class, 'varian_edit'])->name('edit.varian');
    // route for function controller varian
    Route::post('/admin/varian/store', [App\Http\Controllers\Admin\VarianController::class, 'store'])->name('store.varian');
    Route::post('/admin/varian/update/{id}', [App\Http\Controllers\Admin\VarianController::class, 'update'])->name('update.varian');

    // route for view controller role
    Route::get('/admin/role', [RoleController::class, 'index'])->name('index.role');
    Route::get('/admin/role/add', [RoleController::class, 'role_add'])->name('add.role');
    Route::get('/admin/role/edit/{id}', [RoleController::class, 'role_edit'])->name('edit.role');
    // route for function controller role
    Route::post('/admin/role/store', [RoleController::class, 'store'])->name('store.role');
    Route::post('/admin/role/update/{id}', [RoleController::class, 'update'])->name('update.role');

    // route for view controller Employee
    Route::get('/admin/employee', [EmployeeController::class, 'index'])->name('index.employee');
    Route::get('/admin/employee/add', [EmployeeController::class, 'employee_add'])->name('add.employee');
    Route::get('/admin/employee/edit/{id}', [EmployeeController::class, 'employee_edit'])->name('edit.employee');
    // route for function controller employee
    Route::post('/admin/employee/store', [EmployeeController::class, 'store'])->name('store.employee');
    Route::post('/admin/employee/update/{id}', [EmployeeController::class, 'update'])->name('update.employee');
    Route::post('/admin/employee/action/{id}', [EmployeeController::class, 'action'])
        ->name('employee.action');

    // route for view controller Customer
    Route::get('/admin/customer', [CustomerController::class, 'index'])->name('index.customer');
    Route::get('/admin/customer/add', [CustomerController::class, 'customer_add'])->name('add.customer');
    Route::get('/admin/customer/edit/{id}', [CustomerController::class, 'customer_edit'])->name('edit.customer');
    // route for function controller customer
    Route::post('/admin/customer/store', [CustomerController::class, 'store'])->name('store.customer');
    Route::post('/admin/customer/update/{id}', [CustomerController::class, 'update'])->name('update.customer');
    Route::post('/admin/customer/action/{id}', [CustomerController::class, 'action'])
        ->name('customer.action');

    // route for view controller Account
    Route::get('/admin/account', [App\Http\Controllers\Admin\AccountController::class, 'index'])->name('index.account');
    Route::get('/admin/account/add', [App\Http\Controllers\Admin\AccountController::class, 'account_add'])->name('add.account');
    Route::get('/admin/account/edit/{id}', [App\Http\Controllers\Admin\AccountController::class, 'account_edit'])->name('edit.account');
    // route for function controller account
    Route::post('/admin/account/store', [App\Http\Controllers\Admin\AccountController::class, 'store'])->name('store.account');
    Route::post('/admin/account/update/{id}', [App\Http\Controllers\Admin\AccountController::class, 'update'])->name('update.account');
    Route::post('/admin/account/action/{id}', [App\Http\Controllers\Admin\AccountController::class, 'action'])->name('account.action');

    // route for view controller Engine
    Route::get('/admin/engine', [App\Http\Controllers\Admin\EngineController::class, 'index'])->name('index.engine');
    Route::get('/admin/engine/add', [App\Http\Controllers\Admin\EngineController::class, 'engine_add'])->name('add.engine');
    Route::get('/admin/engine/edit/{id}', [App\Http\Controllers\Admin\EngineController::class, 'engine_edit'])->name('edit.engine');
    // route for function controller engine
    Route::post('/admin/engine/store', [App\Http\Controllers\Admin\EngineController::class, 'store'])->name('store.engine');
    Route::post('/admin/engine/update/{id}', [App\Http\Controllers\Admin\EngineController::class, 'update'])->name('update.engine');
    Route::post('/admin/engine/action/{id}', [App\Http\Controllers\Admin\EngineController::class, 'action'])->name('engine.action');

    // route for view controller Brand
    Route::get('/admin/brand', [App\Http\Controllers\Admin\BrandController::class, 'index'])->name('index.brand');
    Route::get('/admin/brand/add', [App\Http\Controllers\Admin\BrandController::class, 'brand_add'])->name('add.brand');
    Route::get('/admin/brand/edit/{id}', [App\Http\Controllers\Admin\BrandController::class, 'brand_edit'])->name('edit.brand');
    // route for function controller brand
    Route::post('/admin/brand/store', [App\Http\Controllers\Admin\BrandController::class, 'store'])->name('store.brand');
    Route::post('/admin/brand/update/{id}', [App\Http\Controllers\Admin\BrandController::class, 'update'])->name('update.brand');
    Route::post('/admin/brand/action/{id}', [App\Http\Controllers\Admin\BrandController::class, 'action'])->name('brand.action');

    // route for view controller Chassis
    Route::get('/admin/chassis', [App\Http\Controllers\Admin\ChassisController::class, 'index'])->name('index.chassis');
    Route::get('/admin/chassis/add', [App\Http\Controllers\Admin\ChassisController::class, 'chassis_add'])->name('add.chassis');
    Route::get('/admin/chassis/edit/{id}', [App\Http\Controllers\Admin\ChassisController::class, 'chassis_edit'])->name('edit.chassis');
    // route for function controller chassis
    Route::post('/admin/chassis/store', [App\Http\Controllers\Admin\ChassisController::class, 'store'])->name('store.chassis');
    Route::post('/admin/chassis/update/{id}', [App\Http\Controllers\Admin\ChassisController::class, 'update'])->name('update.chassis');
    Route::post('/admin/chassis/action/{id}', [App\Http\Controllers\Admin\ChassisController::class, 'action'])->name('chassis.action');

    // route for view controller Vehicle
    Route::get('/admin/vehicle', [App\Http\Controllers\Admin\VehicleController::class, 'index'])->name('index.vehicle');
    Route::get('/admin/vehicle/add', [App\Http\Controllers\Admin\VehicleController::class, 'vehicle_add'])->name('add.vehicle');
    Route::get('/admin/vehicle/edit/{id}', [App\Http\Controllers\Admin\VehicleController::class, 'vehicle_edit'])->name('edit.vehicle');
    // route for function controller vehicle
    Route::post('/admin/vehicle/store', [App\Http\Controllers\Admin\VehicleController::class, 'store'])->name('store.vehicle');
    Route::post('/admin/vehicle/update/{id}', [App\Http\Controllers\Admin\VehicleController::class, 'update'])->name('update.vehicle');
    Route::post('/admin/vehicle/action/{id}', [App\Http\Controllers\Admin\VehicleController::class, 'action'])->name('vehicle.action');

    // route for view controller Mdata
    Route::get('/admin/mdata', [App\Http\Controllers\Admin\MdataController::class, 'index'])->name('index.mdata');
    Route::get('/admin/mdata/add', [App\Http\Controllers\Admin\MdataController::class, 'mdata_add'])->name('add.mdata');
    Route::get('/admin/mdata/edit/{id}', [App\Http\Controllers\Admin\MdataController::class, 'mdata_edit'])->name('edit.mdata');
    // route for function controller mdata
    Route::post('/admin/mdata/store', [App\Http\Controllers\Admin\MdataController::class, 'store'])->name('store.mdata');
    Route::post('/admin/mdata/update/{id}', [App\Http\Controllers\Admin\MdataController::class, 'update'])->name('update.mdata');
    Route::post('/admin/mdata/action/{id}', [App\Http\Controllers\Admin\MdataController::class, 'action'])->name('mdata.action');

    // route for view controller Mgambar
    Route::get('/admin/mgambar', [App\Http\Controllers\Admin\MgambarController::class, 'index'])->name('index.mgambar');
    Route::get('/admin/mgambar/add', [App\Http\Controllers\Admin\MgambarController::class, 'mgambar_add'])->name('add.mgambar');
    Route::get('/admin/mgambar/edit/{id}', [App\Http\Controllers\Admin\MgambarController::class, 'mgambar_edit'])->name('edit.mgambar');
    // route for function controller mgambar
    Route::post('/admin/mgambar/store', [App\Http\Controllers\Admin\MgambarController::class, 'store'])->name('store.mgambar');
    Route::post('/admin/mgambar/update/{id}', [App\Http\Controllers\Admin\MgambarController::class, 'update'])->name('update.mgambar');
    Route::post('/admin/mgambar/action/{id}', [App\Http\Controllers\Admin\MgambarController::class, 'action'])->name('mgambar.action');
});

Route::middleware(['auth', 'role:drafter'])->group(function () {
    Route::get('/drafter/dashboard', function () {
        return view('drafter.dashboard.index');
    })->name('drafter.dashboard');

    // route for view controller workspace
    Route::get('/drafter/workspace', [App\Http\Controllers\Drafter\WorkspaceController::class, 'index'])->name('index.workspace');
    Route::get('/drafter/workspace/add', [App\Http\Controllers\Drafter\WorkspaceController::class, 'workspace_add'])->name('add.workspace');
    Route::get('/drafter/workspace/edit/{id}', [App\Http\Controllers\Drafter\WorkspaceController::class, 'workspace_edit'])->name('edit.workspace');
    Route::get('/drafter/workspace/show/{id}', [App\Http\Controllers\Drafter\WorkspaceController::class, 'workspace_show'])->name('show.workspace');
    // route for function controller workspace
    Route::post('/drafter/workspace/store', [App\Http\Controllers\Drafter\WorkspaceController::class, 'store'])->name('store.workspace');
    Route::post('/drafter/workspace/update/{id}', [App\Http\Controllers\Drafter\WorkspaceController::class, 'update'])->name('update.workspace');
    Route::post('/drafter/workspace/select-upload/{id}', [App\Http\Controllers\Drafter\WorkspaceController::class, 'select_upload'])->name('select.upload');
    Route::post('/drafter/workspace/export/{id}', [App\Http\Controllers\Drafter\WorkspaceController::class, 'export'])->name('export.workspace');
});

Route::middleware(['auth', 'role:checker'])->group(function () {
    Route::get('/checker/dashboard', function () {
        return view('checker.dashboard.index');
    })->name('checker.dashboard');
});
