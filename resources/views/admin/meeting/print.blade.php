<!DOCTYPE html>
<html>
<head>
    <title>Print Meetings</title>
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
    <h1>Meetings List</h1>
    <button onclick="window.print()" class="no-print">Print</button>
    <table>
        <thead>
            <tr>
                <th>Meeting ID</th>
                <th>Room Name</th>
                <th>Title</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Host</th>
                <th>Co-Host</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
                <th>Participants</th>
            </tr>
        </thead>
        <tbody>
            @foreach($meetings as $meeting)
                <tr>
                    <td>{{ $meeting->id }}</td>
                    <td>{{ $meeting->room ? $meeting->room->name : 'N/A' }}</td>
                    <td>{{ $meeting->meeting_title }}</td>
                    <td>{{ $meeting->start_date }}</td>
                    <td>{{ $meeting->start_time }}</td>
                    <td>{{ $meeting->end_time }}</td>
                    <td>{{ $meeting->host ? $meeting->host->name : '' }}</td>
                    <td>{{ $meeting->coHost ? $meeting->coHost->name : 'N/A' }}</td>
                    <td>{{ $meeting->booking_type }}</td>
                    <td>{{ $meeting->booking_status }}</td>
                    <td>{{ $meeting->description }}</td>
                    <td>
                        @foreach($meeting->participants as $participant)
                            {{ $participant->employee ? $participant->employee->name : '' }}<br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
