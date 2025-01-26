<!DOCTYPE html>
<html>

<head>
    <title>{{ __('messages.printUsers') }} </title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
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
    <h1>{{ __('messages.usersList') }} </h1>
    <button onclick="window.print()" class="no-print">{{__('messages.print')}} </button>
    <table>
        <thead>
            <tr>
                <th>{{ __('messages.empId') }} </th>
                <th>{{ __('messages.name') }} </th>
                <th>{{ __('messages.role') }} </th>
                <th>{{ __('messages.projectCode') }} </th>
                <th>{{ __('messages.joiningDate') }} </th>
                <th>{{ __('messages.division') }} </th>
                <th>{{ __('messages.designation') }} </th>
                <th>{{ __('messages.mobile') }} </th>
                <th>{{ __('messages.email') }} </th>
                <th>{{ __('messages.address') }} </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->employee_id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>{{ $user->project_code }}</td>
                    <td>{{ $user->start_from }}</td>
                    <td>{{ $user->department->name }}</td>
                    <td>{{ $user->designation }}</td>
                    <td>{{ $user->mobile_number }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->address }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
