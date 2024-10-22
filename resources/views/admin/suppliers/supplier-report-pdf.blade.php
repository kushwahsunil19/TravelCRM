<!DOCTYPE html>
<html>
<head>
    <title>Supplier Report</title>
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

<h1>Supplier Report</h1>

<table>
    <thead>
        <tr>
            <th>S. No</th>
            <th>Supplier Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>City</th>
            <th>State</th>
            <th>Country</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($suppliers as $supplier)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->email }}</td>
                <td>{{ $supplier->mobile }}</td>
                <td>{{ $supplier->city }}</td>
                <td>{{ $supplier->state }}</td>
                <td>{{ $supplier->country }}</td>
                <td>{{ $supplier->amount }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
