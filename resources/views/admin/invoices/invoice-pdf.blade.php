<!DOCTYPE html>
<html>
  
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice Report</title>
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

<h1>Invoice Report</h1>

<table>
    <thead>
        <tr>
            <th>S. No</th>
            <th>Invoice No</th>
            <th>Branch</th>
            <th>Package</th>
            <th>Partner</th>
            <th>Discount Type</th>
            <th>Discount</th>
            <th>VAT</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoices as $invoice)
            @php
                $symbol = isset($invoice->currency->symbol) ? $invoice->currency->symbol : '₹';
                $package_amt = $invoice->package->amount * $invoice->no_of_passenger;
                $tax = $invoice->vat;
                $discount = $invoice->discount;
                
                // Calculate discount
                $discount_amt = $invoice->discount_type == 'Fixed' ? $discount : ($package_amt * $discount) / 100;
                $amount_after_discount = $package_amt - $discount_amt;
                
                // Calculate tax
                $tax_amt = ($amount_after_discount * $tax) / 100;
                
                // Calculate total
                $total_amt = $amount_after_discount + $tax_amt;
            @endphp
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $invoice->invoice_no }}</td>
                <td>{{ ($invoice->branch->city) ? $invoice->branch->city : 'N/A' }}</td>
                <td>{{ isset($invoice->package->package_name) ? $invoice->package->package_name : 'N/A' }} </td>
                <td>{{ isset($invoice->partner->name) ? $invoice->partner->name : 'N/A' }}</td>
                <td>{{ isset($invoice->discount_type) ? $invoice->discount_type : 'N/A' }}</td>
                <td>{{ $invoice->discount }}{{ ($invoice->discount_type == 'Fixed') ? '' : '%' }}</td>
                <td>{{ $invoice->vat }}%</td>
                <td>{{ $symbol }}{{ number_format($total_amt, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


</body>
</html>
