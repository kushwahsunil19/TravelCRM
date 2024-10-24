<!DOCTYPE html>
<html>
<head>
    <title>Staff-wise Report</title>
    <style>
        /* Add some styles for the PDF */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>

<h1>Staff-wise Report</h1>

<table>
    <thead>
        <tr>
            <th>S. No</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    {{ $user->roles->isNotEmpty() ? $user->roles->first()->name : 'No Role' }}
                </td>
                <td class="center">
                    {{ $user->status ? 'Active' : 'Inactive' }}
                </td>
                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
