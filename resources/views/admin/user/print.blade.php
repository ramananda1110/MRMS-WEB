<!DOCTYPE html>
<html>
<head>
    <title>Print Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
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
    <h1>Users List</h1>
    <button onclick="window.print()" class="no-print">Print</button>
    <table>
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Project Code</th>
                <th>Joining Date</th>
                <th>Division</th>
                <th>Designation</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->employee_id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>{{ $user->project_code }}</td>
                    <td>{{ $user->start_from }}</td>
                    <td>{{ $user->department->name }}</td>
                    <td>{{ $user->designation}}</td>
                    <td>{{ $user->mobile_number}}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->address }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
