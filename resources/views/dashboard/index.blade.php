<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>
    <div class="sidebar">
        <h4 class="text-white text-center">Dashboard</h4>
        <a href="#" class="active"><i class="fas fa-home"></i> Home</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="logout-btn">
            @csrf
            <button class="btn btn-danger btn-sm"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </div>
    
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Employees Joined This Year -->
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-primary shadow">
                        <div class="card-header">Employees Joined This Year</div>
                        <div class="card-body text-center">
                            <h3>{{ $employeesJoinedThisYear }}</h3>
                        </div>
                    </div>
                </div>
                
                <!-- Employees with Birthdays -->
                <div class="col-md-4 mb-4">
                    <div class="card bg-success shadow">
                        <div class="card-header text-white">Birthdays This Month</div>
                        <div class="card-body text-black">
                            @if($employeesBirthdayThisMonth->isNotEmpty())
                                <ul class="list-group birthday-list">
                                    @foreach ($employeesBirthdayThisMonth as $employee)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $employee->name }}
                                            <span class="badge badge-dark">{{ \Carbon\Carbon::parse($employee->birth_date)->format('F j, Y') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-white">No employees with birthdays this month.</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Fifth Highest Salary -->
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-warning shadow">
                        <div class="card-header">5th Highest Salary</div>
                        <div class="card-body text-center">
                            @if ($employeeWith5thHighestSalary)
                                <h5>{{ $employeeWith5thHighestSalary->name }}</h5>
                                <p>Salary: ${{ number_format($employeeWith5thHighestSalary->salary->amount, 2) }}</p>
                            @else
                                <p>No data available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-white">Employee Count Per Department</div>
                        <div class="card-body">
                            @if($employeeCountPerDepartment->isNotEmpty())
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Department</th>
                                            <th>Employee Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employeeCountPerDepartment as $department)
                                            <tr>
                                                <td>{{ $department->name }}</td>
                                                <td>{{ $department->employees_count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No data available.</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Highest Salary Per Department -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-white">Highest Salary Per Department</div>
                        <div class="card-body">
                            @if($highestSalaryPerDepartment->isNotEmpty())
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Department</th>
                                            <th>Employee</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($highestSalaryPerDepartment as $record)
                                            <tr>
                                                <td>{{ $record['department_name'] }}</td>
                                                <td>{{ $record['employee_name'] }}</td>
                                                <td>${{ number_format($record['amount'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No data available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
