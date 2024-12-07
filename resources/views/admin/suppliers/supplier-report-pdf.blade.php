<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px; /* Adjust font size */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 4px; /* Reduce padding */
            text-align: center;
        }

        thead {
            background-color: #f8f9fa;
        }

        .thead-light th {
            font-weight: bold;
        }

        .profitloss-bg {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px;
            background-color: #f8f9fa;
            text-align: center;
            font-size: 12px;
        }

        td {
            word-wrap: break-word;
            white-space: normal;
        }

        .expenses-section {
            background-color: #f9f9f9;
            font-size: 9px;
        }

        .expenses-section strong {
            display: block;
            margin-top: 5px;
        }
        h1{text-align:center;}
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
            <th>Gross Amount</th>
            <th>Net Amount</th>
            <th>Net Profit</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalGrossAmount = 0;
            $totalNetAmount = 0;
            $totalNetProfit = 0;
        @endphp

        @foreach ($suppliers as $supplier)
            @php
                $grossAmount = 0;
                $netAmount = 0;
                $netProfit = 0;
            @endphp
            @foreach($supplier->invoices as $invoice)
                @php
                    $grossAmount += $invoice->package->amount;
                    $netAmount += $invoice->package->net_amount;
                    $netProfit = $grossAmount - $netAmount;
                @endphp
            @endforeach
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->email }}</td>
                <td>{{ $supplier->mobile }}</td>
                <td>{{ $supplier->city->name }}</td>
                <td>{{ $supplier->state->name }}</td>
                <td>{{ $supplier->country->name }}</td>
                <td> {{ number_format($grossAmount, 2) }}</td>
                <td> {{ number_format($netAmount, 2) }}</td>
                <td> {{ number_format($netProfit, 2) }}</td>
            </tr>

            @php
                // Add the calculated amounts to the totals
                $totalGrossAmount += $grossAmount;
                $totalNetAmount += $netAmount;
                $totalNetProfit += $netProfit;
            @endphp
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <td colspan="7" class="text-end"><strong>Total Amount:</strong></td>
            <td><strong> {{ number_format($totalGrossAmount, 2) }}</strong></td>
            <td><strong> {{ number_format($totalNetAmount, 2) }}</strong></td>
            <td><strong> {{ number_format($totalNetProfit, 2) }}</strong></td>
        </tr>
    </tfoot>
</table>

</body>
</html>
