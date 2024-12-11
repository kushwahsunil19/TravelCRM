<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Report</title>
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

    <h1>Quotation Report</h1>

    <table>
        <thead>
            <tr>
                <th>S. No</th>
                <th>Quotation No</th>
                <th>Branch</th>
                <th>Package</th>
                <th>Partner</th>
                <th>Discount Type</th>
                <th>Discount</th>
                <th>VAT</th>
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
         
            $totalNetExpenses = 0;
            $symbol = 'د.إ';
            $grossAmount = 0;
            @endphp

            @if($quotations->isEmpty())
            <tr>
                <td colspan="11" class="text-center">No data available</td>
            </tr>
            @else
            @foreach ($quotations as $quotation)
            @php
            $currency_code = $quotation->currency->code ?? 'AED';
            $grossAmount = ($quotation->package->amount ?? 0) * ($quotation->no_of_passenger ?? 1);
            $netCost = ($quotation->package->net_amount ?? 0) * ($quotation->no_of_passenger ?? 1);
            $rates = getCurrencyRate($currency_code);
            $discount = $quotation->discount ?? 0;
            $discountAmount = ($quotation->discount_type == 'Fixed') ? $discount * $rates['AED'] : ($grossAmount *
            $discount) / 100;

           if($currency_code == 'INR') {
            $grossAmount *= $rates['AED'];
            $netCost *= $rates['AED'];
            $discount = $quotation->discount ?? 0;
            $discountAmount = ($quotation->discount_type == 'Fixed') ? $discount * $rates['AED'] : ($grossAmount *
            $discount) / 100;
            } elseif($currency_code == 'USD') {
            $grossAmount *= $rates['AED'];
            $netCost *= $rates['AED'];
            $discount = $quotation->discount ?? 0;
            $discountAmount = ($quotation->discount_type == 'Fixed') ? $discount * $rates['AED'] : ($grossAmount *
            $discount) / 100;
            }
            // Calculate values

            $vatAmount = ($grossAmount - $discountAmount) * $quotation->gst_tax / 100;

            $netProfit = $grossAmount - $netCost;

            // Add to totals
            $totalGrossAmount += $grossAmount;
            $totalNetCost += $netCost;
            $totalNetProfit += $netProfit;
            @endphp


            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $quotation->quotation_no }}</td>
                <td>{{ ($quotation->branch->city) ? $quotation->branch->city : 'N/A' }}</td>
                <td>{{ isset($quotation->package->package_name) ? $quotation->package->package_name : 'N/A' }}</td>
                <td>{{ isset($quotation->partner->name) ? $quotation->partner->name : 'N/A' }}</td>
                <td>{{ isset($quotation->discount_type) ? $quotation->discount_type : 'N/A' }}</td>
                <td>
                    {{ $quotation->discount }}{{ ($quotation->discount_type == 'Fixed') ? '' : '%' }}
                </td>
                <td>{{ $quotation->gst_tax }}%</td>
                <td>{{ number_format($grossAmount, 2) }}</td>
                <td>
                    @php
                    $totalExpenses = 0; // Initialize total expenses
                    @endphp

                    @if(isset($quotation->package->expenses))
                    @foreach($quotation->package->expenses as $expense)
                    @php
                    // Calculate the converted amount based on the currency code
                    $convertedAmount = 0;
                    if ($currency_code == 'AED') {
                    $convertedAmount = $expense->amount * $rates['AED'];
                    } elseif ($currency_code == 'INR') {
                    $convertedAmount = $expense->amount * $rates['AED'];
                    } elseif ($currency_code == 'USD') {
                    $convertedAmount = $expense->amount * $rates['AED'];
                    } elseif ($currency_code == 'EUR') {
                    $convertedAmount = $expense->amount * $rates['AED'];
                    }

                    // Add to the total expenses
                    $convertedAmount = $convertedAmount * ($quotation->no_of_passenger ?? 1);
                    $totalExpenses += $convertedAmount ;
                    @endphp

                    {{ $expense->title }}: {{ number_format($convertedAmount  , 2) }}<br>
                    @endforeach
                    @endif

                    <hr>
                    <strong>Total: {{ number_format($totalExpenses, 2) }}</strong><br>

                </td>
                <td>{{ number_format($netProfit, 2) }}</td>
            </tr>
            @php $totalNetExpenses += $totalExpenses; @endphp
            @endforeach
            @endif
        </tbody>

        <tfoot>
            <tr>
                <td colspan="8" class="text-end"><strong>Total Amount:</strong></td>
                <td><strong>{{ $symbol }}{{ number_format($totalGrossAmount, 2) }}</strong></td>
                <td><strong>{{ $symbol }}{{ number_format($totalNetExpenses, 2) }}</strong></td>
                <td><strong>{{ $symbol }}{{ number_format($totalNetProfit, 2) }}</strong></td>
            </tr>
        </tfoot>

    </table>


</body>

</html>