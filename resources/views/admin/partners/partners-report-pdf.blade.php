<!DOCTYPE html>
<html>
<head>
    <title>Agency Report</title>
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

<h1>Agency Report</h1>

<table>
    <thead>
        <tr>
            <th>S. No</th>
            <th>Agency Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>City</th>
            <th>State</th>
            <th>Country</th>
          
        </tr>
    </thead>
    <tbody>
        @foreach ($partners as $partner)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $partner->name }}</td>
                <td>{{ $partner->email }}</td>
                <td>{{ $partner->mobile }}</td>
                <td>{{ $partner->city->name ?? 'N/A' }}</td>
                <td>{{ $partner->state->name ?? 'N/A' }}</td>
                <td>{{ $partner->country->name ?? 'N/A' }}</td>
                
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
