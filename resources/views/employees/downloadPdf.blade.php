<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }

        table th {
            padding: 5px;
            border: 1px solid black;
            text-align: center;
        }

        table td {
            padding: 5px;
            border: 1px solid black;
            text-align: center;
        }
        
        .address {
            word-wrap: break-word;
        }
    </style>

</head>

<body>
    <h1>Employee List</h1>
    <table>
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Employee Code</th>
                <th>Employee Name</th>
                <th>Email</th>
                <th>NRC Number</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Matial Status</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->employee_id }}</td>
                <td>{{ $employee->employee_code }}</td>
                <td>{{ $employee->employee_name }}</td>
                <td>{{ $employee->email_address }}</td>
                <td>{{ $employee->nrc_number }}</td>
                <td>@if ($employee->gender == 1)
                    Male
                    @else ($employee->gender == 2)
                    Female
                    @endif</td>
                <td>{{ $employee->date_of_birth }}</td>
                <td>@if ($employee->martial_status == 'single')
                    Single
                    @elseif ($employee->martial_status == 'married')
                    Married
                    @else ($employee->martial_status == 'divorce')
                    Divorced
                    @endif</td>
                <td class="address">{{ $employee->address }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>