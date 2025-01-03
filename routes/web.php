<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Designation\DesignationController;
use App\Http\Controllers\Employee\AttendanceController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Employee\LeaveController as EmployeeLeaveController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectMaster\ProjectMasterController;
use App\Http\Controllers\RolePermission\PermissionController;
use App\Http\Controllers\RolePermission\RoleController;
use App\Http\Controllers\Settings\HolidayController;
use App\Http\Controllers\Settings\LeaveController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/complete-registration', [RegisterController::class, 'completeRegistration'])->name('complete.registration');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [EmployeeController::class, 'profile'])->middleware(['permission:view_profile'])->name('profile');
    Route::get('/edit-profile/{employee?}', [EmployeeController::class, 'editProfile'])->name('employee_form');
    Route::get('/logout-auth', [LoginController::class, 'logOut']);
});

Route::middleware(['2fa', 'auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    Route::post('/2fa', function () {
        return redirect(route('home'));
    })->name('2fa');
});

// employees url
Route::prefix('employees')->as('employees.')->middleware(['auth', '2fa'])->group(function () {
    
    Route::post('/update-profile/{employee}', [EmployeeController::class, 'updateProfile'])->middleware(['permission:update_profile'])->name('update_profile');

    Route::get('/index', [EmployeeController::class, 'index'])->middleware(['permission:view_employees'])->name('employee_index');
    Route::get('/details/{employee}', [EmployeeController::class, 'employee'])->middleware(['permission:view_employees'])->name('employee_details');
    Route::post('/datatable', [EmployeeController::class, 'datatable'])->middleware(['permission:view_employees'])->name('employee_datatable');
    Route::post('/create-or-update/{employee?}', [EmployeeController::class, 'createOrUpdate'])->middleware(['permission:add_employee'])->name('create_or_update');
    Route::get('/delete/{employee?}', [EmployeeController::class, 'delete'])->middleware(['permission:delete_employee'])->name('employee_delete');

    Route::get('/form/{employee?}', [EmployeeController::class, 'form'])->name('employee_form');
});

// employee attendance
Route::prefix('attendance')->as('attendance.')->middleware(['auth'])->group(function () {
    Route::get('/index', [AttendanceController::class, 'index'])->name('index');
    Route::post('/datatable', [AttendanceController::class, 'dataTable'])->name('data_table');
    Route::post('/summary', [AttendanceController::class, 'summary'])->name('attendance_summary');
    Route::post('/details', [AttendanceController::class, 'details'])->name('attendance_details');
    Route::get('/punch-in', [AttendanceController::class, 'punchIn'])->name('punch_in');
    Route::get('/punch-out', [AttendanceController::class, 'punchOut'])->name('punch_out');
});

// Designation routes
Route::prefix('designations')->as('designations.')->middleware(['permission:view_designations','auth'])->group(function(){ 
    Route::get('/index', [DesignationController::class, 'index'])->name('designation');
    Route::post('/datatable', [DesignationController::class, 'datatable'])->name('designation_list');
    Route::post('/create-or-update/{designation?}', [DesignationController::class, 'storeOrUpdate'])->name('store_or_update');
    Route::get('/delete/{designation}',[DesignationController::class, 'destroy'])->name('delete');
});

// Role routes
Route::prefix('roles')->as('roles.')->middleware(['permission:view_roles','auth'])->group(function(){ 
    Route::get('/index', [RoleController::class, 'index'])->name('role');
    Route::post('/datatable', [RoleController::class, 'datatable'])->name('role_list');
    Route::post('/create-or-update/{role?}', [RoleController::class, 'storeOrUpdate'])->name('store_or_update');
    Route::get('/delete/{role}',[RoleController::class, 'destroy'])->name('delete');
});

// permission
Route::prefix('permissions')->as('permissions.')->middleware(['auth'])->group(function () {
    Route::get('/index', [PermissionController::class, 'index'])->name('permissions');
    Route::get('/details', [PermissionController::class, 'details'])->name('details');
    Route::post('/save-changes', [PermissionController::class, 'assignPermission'])->name('role_permission_save_changes');
});

// holiday
Route::prefix('holidays')->as('holidays.')->middleware(['auth'])->group(function () {
    Route::get('/index', [HolidayController::class, 'index'])->name('index');
    Route::get('/holiday-list', [HolidayController::class, 'holidayList'])->name('holiday_list');
    Route::post('/year-filter', [HolidayController::class, 'yearFilter'])->name('year_filter');
    Route::post('/get-holiday', [HolidayController::class, 'getHoliday'])->name('get_holiday');
    Route::post('/update-holiday', [HolidayController::class, 'updateHoliday'])->name('update-holiday');
});

// settings
Route::prefix('settings')->as('settings.')->middleware(['auth'])->group(function () {
    Route::get('/index', [DashboardController::class, 'settings'])->name('index');
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave');
});

// settings
Route::prefix('leave-settings')->as('leave_settings.')->middleware(['auth'])->group(function () {
    Route::get('/all-leaves', [LeaveController::class, 'allLeaves'])->name('all_leave');
    Route::post('/update', [LeaveController::class, 'update'])->name('update');
});

// my leaves
Route::prefix('my-leaves')->as('my_leaves.')->middleware(['auth'])->group(function () {
    Route::get('/index', [EmployeeLeaveController::class, 'index'])->name('my_leaves');
    Route::post('/datatable', [EmployeeLeaveController::class, 'datatable'])->name('leave_list');
    Route::post('/add', [EmployeeLeaveController::class, 'addLeave'])->name('add');
});

// employee leaves
Route::prefix('employee-leaves')->as('employee_leaves.')->middleware(['auth'])->group(function () {
    Route::get('/index', [EmployeeLeaveController::class, 'employeeLeavesIndex'])->name('employee_leaves');
    Route::post('/datatable', [EmployeeLeaveController::class, 'allEmployeeLeaves'])->name('employee_leves_list');
    Route::post('/update-status', [EmployeeLeaveController::class, 'updateStatus'])->name('update_status');
});

// project master
Route::prefix('project-master')->as('project_master.')->middleware(['auth'])->group(function () {
    Route::get('/index', [ProjectMasterController::class, 'index'])->name('project_master_list');
    Route::post('/datatable', [ProjectMasterController::class, 'datatable']);
    Route::post('/create-or-update/{project?}', [ProjectMasterController::class, 'storeOrUpdate']);
    Route::get('/delete/{project}',[ProjectMasterController::class, 'destroy']);
});

// common
Route::get('/send-msg', [DashboardController::class, 'generateInvoice']);
