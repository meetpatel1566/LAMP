<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function userIndex(){
        return view('dashboard.userindex');
    }

    public function index()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        $employeesJoinedThisYear = Employee::whereYear('join_date', $currentYear)->count();

        $employeesBirthdayThisMonth = Employee::whereMonth('birth_date', $currentMonth)->get();

        $fifthHighestSalary = Salary::orderBy('amount', 'desc')
            ->distinct()
            ->skip(4)
            ->take(1)
            ->first();

        $employeeWith5thHighestSalary = null;
        if ($fifthHighestSalary) {
            $employeeWith5thHighestSalary = Employee::with('salary')
                ->whereHas('salary', function($query) use ($fifthHighestSalary) {
                    $query->where('amount', $fifthHighestSalary->amount);
                })
                ->first();
        }

        $employeeCountPerDepartment = Department::withCount('employees')->get();

        $departmentsWithHighestSalary = Department::with('employees.salary')->get()->map(function ($department) {
            $department->employees = $department->employees->sortByDesc(function ($employee) {
                return $employee->salary->amount ?? 0;
            });
        
            return $department;
        });
        
        $highestSalaryPerDepartment = $departmentsWithHighestSalary->map(function ($department) {
            $employeeWithHighestSalary = $department->employees->first();
        
            return [
                'department_name' => $department->name,
                'employee_name' => $employeeWithHighestSalary->name,
                'amount' => $employeeWithHighestSalary->salary->amount,
            ];
        });

        return view('dashboard.index', compact(
            'employeesJoinedThisYear',
            'employeesBirthdayThisMonth',
            'employeeWith5thHighestSalary',
            'employeeCountPerDepartment',
            'highestSalaryPerDepartment'
        ));
    }
}
