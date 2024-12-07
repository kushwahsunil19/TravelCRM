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
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($quotations as $quotation)
            @php
                // Get currency symbol (default to ₹ if not set)
                $symbol = isset($quotation->currency->symbol) ? $quotation->currency->symbol : '₹';
                
                // Calculate package amount
                $package_amt = isset($quotation->package->amount) ? $quotation->package->amount * $quotation->no_of_passenger : 0;

                // Calculate discount
                $discount = $quotation->discount;
                $discount_amt = $quotation->discount_type == 'Fixed' ? $discount : ($package_amt * $discount) / 100;
                $amount_after_discount = $package_amt - $discount_amt;

                // Calculate tax
                $tax_amt = ($amount_after_discount * $quotation->gst_tax) / 100;

                // Calculate total
                $total_amt = $amount_after_discount + $tax_amt;
            @endphp
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $quotation->quotation_no }}</td>
                <td>{{ ($quotation->branch->city) ? $quotation->branch->city : 'N/A' }}</td>
                <td>{{ isset($quotation->package->package_name) ? $quotation->package->package_name : 'N/A' }}</td>
                <td>{{ isset($quotation->partner->name) ? $quotation->partner->name : 'N/A' }}</td>
                <td>{{ isset($quotation->discount_type) ? $quotation->discount_type : 'N/A' }}</td>
                <td>{{ $quotation->discount }}{{ ($quotation->discount_type == 'Fixed') ? '' : '%' }}</td>
                <td>{{ $quotation->gst_tax }}%</td>
                <td>{{ $symbol }}{{ number_format($total_amt, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


</body>
</html>
