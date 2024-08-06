<?php

namespace App\Http\Controllers\API;

use App\Models\Employee;
use App\Models\Department;
use App\Http\Controllers\API\BaseController;


class DashboardController extends BaseController
{
    public function countEmployees()
    {
        $employeeCount = Employee::count();

        return $this->successResponse(['employee_count' => $employeeCount], 'Employee count retrieved successfully.');
    }

    public function countEmployeesByStatus()
    {
        $activeCount = Employee::where('status', 'active')->count();
        $inactiveCount = Employee::where('status', 'inactive')->count();

        return $this->successResponse([
            'active_count' => $activeCount,
            'inactive_count' => $inactiveCount
        ], 'Employee status count retrieved successfully.');
    }

    public function countEmployeesByDepartment()
    {
        $departments = Department::with(['jobs' => function ($query) {
            $query->withCount('employees');
        }])->get();

        $departmentCounts = $departments->mapWithKeys(function ($department) {
            $employeeCount = $department->jobs->sum('employees_count');
            return [$department->name => $employeeCount];
        });

        return $this->successResponse(['department_counts' => $departmentCounts], 'Employee count by department retrieved successfully.');
    }

    public function countEmployeesSummary()
    {
        // Count total employees
        $employeeCount = Employee::count();

        // Count employees by status
        $activeCount = Employee::where('status', 'active')->count();
        $inactiveCount = Employee::where('status', 'inactive')->count();

        // Count employees by department
        $departments = Department::with(['jobs' => function ($query) {
            $query->withCount('employees');
        }])->get();

        $departmentCounts = $departments->mapWithKeys(function ($department) {
            $employeeCount = $department->jobs->sum('employees_count');
            return [$department->name => $employeeCount];
        });

        // Combine all counts into one response
        return $this->successResponse([
            'employee_count' => $employeeCount,
            'status_counts' => [
                'active_count' => $activeCount,
                'inactive_count' => $inactiveCount
            ],
            'department_counts' => $departmentCounts
        ], 'Employee summary count retrieved successfully.');
    }
}
