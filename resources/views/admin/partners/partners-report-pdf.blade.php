<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Report</title>
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
    </style>
</head>

<body>

<h1>Partner Report</h1>

<table>
  <thead>
        <tr>
            <th>S.No</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>City</th>
            <th>State</th>
            <th>Country</th>
            <th>Gross Amount</th>
            <th>Net Cost</th>
            <th>Net Profit</th>
        </tr>
    </thead>
<tbody>
    @php
        $totalGross = 0;
        $totalNetCost = 0;
        $totalNetProfit = 0;
    @endphp

    @forelse ($partners as $partner)
        @php
            $grossAmount = 0;
            $netCost = 0; // Initialize netCost for this partner
            $netProfit = 0;
        @endphp

        @foreach ($partner->invoices as $invoice)
            @php
                $currencyCode = $invoice->currency->code ?? 'AED';
                
                // Calculate gross amount
                $invoiceGrossAmount = ($invoice->package->amount ?? 0) * ($invoice->no_of_passenger ?? 1);

                // Calculate net cost
                $invoiceNetCost = ($invoice->package->net_amount ?? 0) * ($invoice->no_of_passenger ?? 1);

                // Apply discount
                $discount = $invoice->discount ?? 0;
                $discountAmount = ($invoice->discount_type === 'Fixed') 
                    ? $discount 
                    : ($invoiceGrossAmount * $discount) / 100;

                // Currency conversion
                $invoiceGrossAmount = getCurrencyRateAmt($currencyCode, 'AED', $invoiceGrossAmount);
                $invoiceNetCost = getCurrencyRateAmt($currencyCode, 'AED', $invoiceNetCost);
                $discountAmount = getCurrencyRateAmt($currencyCode, 'AED', $discountAmount);

                // Tax calculation
                $tax = $invoice->vat ?? 0;
                $amountAfterDiscount = $invoiceGrossAmount - $discountAmount;
                $taxAmount = ($amountAfterDiscount * $tax) / 100;
                $totalInvoiceAmount = $amountAfterDiscount + $taxAmount;

                // Final gross amount and net profit
                $grossAmount += $totalInvoiceAmount;
                $netCost += $invoiceNetCost; // Accumulate net cost for the partner
                $netProfit += $totalInvoiceAmount - $invoiceNetCost;

                // Accumulate totals
                $totalGross += $totalInvoiceAmount;
                $totalNetCost += $invoiceNetCost;
                $totalNetProfit += $totalInvoiceAmount - $invoiceNetCost;
            @endphp
        @endforeach

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
               {{ $partner->name}} - {{ $partner->email}}
            </td>
            <td>{{ $partner->mobile }}</td>
            <td>{{ $partner->city->name ?? 'N/A' }}</td>
            <td>{{ $partner->state->name ?? 'N/A' }}</td>
            <td>{{ $partner->country->name ?? 'N/A' }}</td>
            <td>{{ number_format($grossAmount, 2) }}</td>
            <td>{{ number_format($netCost, 2) }}</td> <!-- Net Cost now displays correctly -->
            <td>{{ number_format($netProfit, 2) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">No partners found.</td>
        </tr>
    @endforelse
</tbody>
<tfoot>
    <tr>
        <th colspan="6" class="text-end">Total Amount:</th>
        <th>{{ number_format($totalGross, 2) }}</th>
        <th>{{ number_format($totalNetCost, 2) }}</th>
        <th>{{ number_format($totalNetProfit, 2) }}</th>
    </tr>
</tfoot>

</table>

</body>
</html>
