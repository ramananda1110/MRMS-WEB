<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        
        .no-print {
            display: none;
        }
    </style>
</head>
<body onload="window.print()">
    <h1>Meetings List</h1>
    <button onclick="window.print()" class="no-print">Print</button>
    <table>
        <thead>
            <tr>
                <th>Emp_ID</th>
                <th>Grade</th>
                <th>Name</th>
                <th>Status</th>
                <th>Division</th>
                <th>Project Name</th>
                <th>Designation</th>
                <th>Mobile</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->employee_id }}</td>
                    <td>{{ $employee->grade }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->status }}</td>
                    <td>{{ $employee->division }}</td>
                    <td>{{ $employee->project_name }}</td>
                    <td>{{ $employee->designation }}</td>
                    <td>{{ $employee->mobile_number }}</td>
                    <td>{{ $employee->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
