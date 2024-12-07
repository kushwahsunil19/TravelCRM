<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff-wise Report</title>
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

<h1>Staff-wise Report</h1>

<table>
    <thead>
        <tr>
            <th>S. No</th>
            <th>User Name</th>          
            <th>Email</th>
            <th>Mobile No</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Gross Amount</th>
            <th>Net Cost</th>
            <th>Net Profit</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalGrossAmount = 0;
            $totalNetCost = 0;
            $totalNetProfit = 0;
        @endphp

        @foreach ($users as $user)
            @php
                $grossAmountRow = 0;
                $netAmountRow = 0;

                foreach ($user->invoices as $invoice) {
                    $grossAmountRow += $invoice->package->amount;
                    $netAmountRow += $invoice->package->net_amount;
                }

                $profitAmountRow = $grossAmountRow - $netAmountRow;

                // Accumulate totals
                $totalGrossAmount += $grossAmountRow;
                $totalNetCost += $netAmountRow;
                $totalNetProfit += $profitAmountRow;
            @endphp
            
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $user->first_name  }} {{ $user->last_name }}</td>              
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile }}</td>
                <td>
                    {{ $user->roles->isNotEmpty() ? $user->roles->first()->name : 'No Role' }}
                </td>
                <td class="center">
                    {{ $user->status ? 'Active' : 'Inactive' }}
                </td>
                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</td>
                <td class="center">{{ number_format($grossAmountRow, 2) }}</td>
                <td class="center">{{ number_format($netAmountRow, 2) }}</td>
                <td class="center">{{ number_format($profitAmountRow, 2) }}</td>
            </tr>
        @endforeach

        <!-- Total Row -->
        <tr class="total-row">
            <td colspan="7" class="center">Total Amount:</td>
            <td class="center">{{ number_format($totalGrossAmount, 2) }}</td>
            <td class="center">{{ number_format($totalNetCost, 2) }}</td>
            <td class="center">{{ number_format($totalNetProfit, 2) }}</td>
        </tr>
    </tbody>
</table>

</body>
</html>
