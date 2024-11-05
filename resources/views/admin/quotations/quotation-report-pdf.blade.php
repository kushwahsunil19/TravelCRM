<!DOCTYPE html>
<html>
<head>
    <title>Quotation Report</title>
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

<h1>Quotation Report</h1>

<table>
    <thead>
        <tr>
            <th>S. No</th>
            <th>Quotation No</th>
            <th>Branch</th>
            <th>Package</th>
            <th>agent</th>
            <th>Discount Type</th>
            <th>Discount</th>
            
            <th>Vat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($quotations as $quotation)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $quotation->quotation_no }}</td>
                <td>{{ ($quotation->branch->city) ? $quotation->branch->city : 'N/A' }}</td>
                <td>{{ isset($quotation->package->package_name) ? $quotation->package->package_name : 'N/A' }}</td>
                <td>{{ isset($quotation->agent->name) ? $quotation->agent->name : 'N/A' }}</td>
                <td>{{ $quotation->discount_type }}</td>
                <td>{{ $quotation->discount }}{{ ($quotation->discount_type == 'Fixed') ? '' : '%' }}</td>
                <td>{{ $quotation->gst_tax }}%</td>
               
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
