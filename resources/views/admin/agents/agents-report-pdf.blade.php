<!DOCTYPE html>
<html>
<head>
    <title>Agents Report</title>
    <style>
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

<h1>Agents Report</h1>

<table>
    <thead>
        <tr>
            <th>S. No</th>
            <th>Agent Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>City</th>
            <th>State</th>
            <th>Country</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($agents as $index => $agent)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td>{{ $agent->name }}</td>
                <td>{{ $agent->email }}</td>
                <td>{{ $agent->mobile }}</td>
                <td>{{ $agent->city }}</td>
                <td>{{ $agent->state }}</td>
                <td>{{ $agent->country }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
