<!DOCTYPE html>
<html>
<head>
    <title>Invoice Report</title>
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

<h1>Invoice Report</h1>

<table>
    <thead>
        <tr>
            <th>S. No</th>
            <th>Invoice No</th>
            <th>Branch</th>
            <th>Package</th>
            <th>agent</th>
            <th>Discount Type</th>
            <th>Discount</th>
            <th>Vat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoices as $invoice)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $invoice->invoice_no }}</td>
                <td>{{ ($invoice->branch->city) ? $invoice->branch->city : 'N/A' }}</td>
                <td>{{ isset($invoice->package->package_name) ? $invoice->package->package_name : 'N/A' }}</td>
                <td>{{ isset($invoice->agent->name) ? $invoice->agent->name : 'N/A' }}</td>
                <td>{{ $invoice->discount_type }}</td>
                <td>{{ $invoice->discount }}{{ ($invoice->discount_type == 'Fixed') ? '' : '%' }}</td>
                <td>{{ $invoice->vat }}%</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
