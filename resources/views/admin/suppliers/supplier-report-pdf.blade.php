<!DOCTYPE html>
<html>
<head>
    <title>Supplier Report</title>
    <style>
        /* Add some styles for the PDF */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-size: 14px;
        }
        td {
            font-size: 12px;
        }
        .center {
            text-align: center;
        }

        /* Page layout centering */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container">
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
                    <td>{{ $loop->iteration }}</td>
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
</div>

</body>
</html>
