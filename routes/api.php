<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    AuthController,
    DepartmentController,
    JobController,
    EmployeeController,
    DashboardController
};


Route::post('auth', [AuthController::class, 'signin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('departments', DepartmentController::class);
    Route::resource('jobs', JobController::class);
    Route::resource('employees', EmployeeController::class);

    Route::get('dashboard/employee-count', [DashboardController::class, 'countEmployees']);
    Route::get('dashboard/employee-status-count', [DashboardController::class, 'countEmployeesByStatus']);
    Route::get('dashboard/employee-department-count', [DashboardController::class, 'countEmployeesByDepartment']);
    Route::get('dashboard/employee-summary', [DashboardController::class, 'countEmployeesSummary']);
});
