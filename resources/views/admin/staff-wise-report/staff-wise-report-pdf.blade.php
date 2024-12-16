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
        font-size: 10px;
        /* Adjust font size */
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 4px;
        /* Reduce padding */
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

    h1 {
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
                        
                                $symbol = 'د.إ'; // Default currency symbol (AED)
                             
                                @endphp
                                
                                @if($users->isEmpty())
                                <tr>
                                    <td colspan="10" class="text-center">No data available</td>
                                </tr>
                                @else
                                @foreach ($users as $user)
                                @php
                                $grossAmountRow = 0;
                                $netAmountRow = 0;
                        
                                // Iterate through each user's invoices
                                foreach ($user->invoices as $invoice) {
                                    // Fetch currency and conversion rates
                                    $currency_code = $invoice->currency->code ?? 'AED';
                                    // Calculate Gross and Net Amount
                                    $grossAmount = ($invoice->package->amount ?? 0) * ($invoice->no_of_passenger ?? 1);                                 
                                    $netAmount = ($invoice->package->net_amount ?? 0) ;                                 
                        
                                    // Apply Discounts
                                    $discount = $invoice->discount ?? 0;
                                    $discountAmount = ($invoice->discount_type === 'Fixed') ? getCurrencyRateAmt($invoice->currency->code, 'AED', $discount) : ($grossAmount * $discount) / 100;
                        
                                    // Currency Conversion                             
                                    $grossAmount = getCurrencyRateAmt($invoice->currency->code,'AED',$grossAmount);
                                    $netAmount = getCurrencyRateAmt($invoice->currency->code,'AED',$netAmount);
                                    $discountAmount = getCurrencyRateAmt($invoice->currency->code,'AED',$discountAmount);
                                    // Apply Tax
                                    $taxRate = $invoice->vat ?? 0;
                                    $amountAfterDiscount = $grossAmount - $discountAmount;
                                    $taxAmount = ($amountAfterDiscount * $taxRate) / 100;
                        
                                    $grossAmount = $amountAfterDiscount + $taxAmount;
                        
                                    // Accumulate totals for the current user
                                    $grossAmountRow += $grossAmount;
                                    $netAmountRow += $netAmount;
                                }
                        
                                // Calculate Profit for the User
                                $profitAmountRow = $grossAmountRow - $netAmountRow;
                        
                                // Accumulate global totals
                                $totalGrossAmount += $grossAmountRow;
                                $totalNetCost += $netAmountRow;
                                $totalNetProfit += $profitAmountRow;
                                @endphp
                        
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile ?? 'N/A' }}</td>
                                    <td>{{ $user->roles->isNotEmpty() ? $user->roles->first()->name : 'No Role' }}</td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    <td>{{ number_format($grossAmountRow, 2) }}</td>
                                    <td>{{ number_format($netAmountRow, 2) }}</td>
                                    <td>{{ number_format($profitAmountRow, 2) }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="text-end"><strong>Total Amount:</strong></td>
                                    <td><strong>{{ $symbol }} {{ number_format($totalGrossAmount, 2) }}</strong></td>
                                    <td><strong>{{ $symbol }} {{ number_format($totalNetCost, 2) }}</strong></td>
                                    <td><strong>{{ $symbol }} {{ number_format($totalNetProfit, 2) }}</strong></td>
                                </tr>
                            </tfoot>

    </table>

</body>

</html>