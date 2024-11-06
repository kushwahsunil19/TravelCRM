<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Profit & Loss</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <style>
    /* General Layout */
    body {
        font-family: 'DejaVu Sans', sans-serif;
        margin: 0;
        padding: 0;
        background: #fff;
    }

    .container {
        width: 695px;
        margin: 0 auto;
        padding: 10px;
        border: 0.5px solid #ddd;
    }

    /* Fixed Footer Styling */
    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 40px;
        text-align: center;
        line-height: 40px;
        background-color: #f8f9fa;
    }

    /* Table Styling */
    .table {
        border-collapse: collapse;
        width: 100%;
    }

    .table th,
    .table td {
        border: none;
        padding: 4px;
    }

    .table th {
        background-color: #84dfd0;
    }

    h3,
    h1,
    p {
        margin: 0;
    }

    .row {
        margin-bottom: 10px;
    }

    .navbar-brand img {
        height: 70px;
    }

    .total-section {
        display: flex;
        justify-content: left;
        align-items: flex-start;
        margin-top: 20px;
    }

    .total {
        text-align: right;
        margin-top: 2px;
    }

    /* Print Styles */
    .header {
        width: 100%;
        margin-bottom: 20px;
    }

    @media print {
        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th,
        .table td {
            border: none;
            padding: 4px;
        }

        .table th {
            background-color: #84dfd0;
        }

        h3,
        h1,
        p {
            margin: 0;
        }

        .row {
            margin-bottom: 10px;
        }

        .navbar-brand img {
            height: 70px;
        }

        .header {
            position: static;
            top: 0;
            z-index: 1;
            page-break-after: avoid;
        }

        body {
            margin-top: 50px;
        }

        .no-print {
            display: none;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #f8f9fa;
        }

        .content-wrapper {
            page-break-inside: avoid;
        }

        .table tbody tr {
            page-break-inside: avoid;
        }

        .table thead {
            display: table-header-group;
        }

        .footer {
            page-break-before: always;
        }

        .notes {
            page-break-inside: avoid;
        }
    }

    ul li {
        list-style-type: none !important;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid" style="padding: 0px">
                    <br>
                    <a class="navbar-brand" href="#">
                        <!-- Dynamic Image Placeholder -->
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/logo2.png'))) }}"
                            alt="Company Logo" />
                    </a>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="float:right;">
                        <li class="nav-item text-end">
                            <h1>Profit & Loss</h1>

                        </li>
                    </ul>
                </div>
            </nav>
        </div>    


        <!-- Services Table -->
        <div class="content-wrapper" style="padding: 0px">
            <table class="table" style="border: 1px solid black;">
                <thead>
                    <tr>
                        <th style="text-align:left; border: 1px solid black; ">Branch</th>
                        <th style="text-align:left; border: 1px solid black; ">Package</th>
                        <th style="text-align:left; border: 1px solid black;">Month</th>
                        <th style="text-align:left; border: 1px solid black;">Year</th>
                        <th style="text-align:left; border: 1px solid black;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total_invoice_amt = 0; @endphp
                    @forelse ($invoices as $invoice)
                    @php
                    $symbol = $invoice->currency->symbol ?? '₹';
                    $package_amt = $invoice->package->amount ?? 0;
                    $tax = $invoice->vat ?? 0;
                    $discount = $invoice->discount ?? 0;
                    $discount_amt = ($invoice->discount_type == 'Fixed') ? $discount : ($package_amt * $discount) / 100;
                    $amount_after_discount = $package_amt - $discount_amt;
                    $tax_amt = ($amount_after_discount * $tax) / 100;
                    $total_amt = $amount_after_discount + $tax_amt;
                    $total_invoice_amt += $total_amt;
                    @endphp
                    <tr>
                        <td style="text-align:justify; border: 1px solid black;">
                            {{ $invoice->branch->branch_name ?? 'N/A' }}</td>
                        <td style="text-align:justify; border: 1px solid black;">
                            {{ $invoice->package->package_name ?? 'N/A' }}</td>
                        <td style="text-align:justify; border: 1px solid black;">
                            {{ \Carbon\Carbon::parse($invoice->created_at)->format('F') }}</td>
                        <td style="text-align:justify; border: 1px solid black;">
                            {{ \Carbon\Carbon::parse($invoice->created_at)->format('Y') }}</td>
                        <td style="text-align:justify; border: 1px solid black;">
                        {{$symbol}}{{ number_format($total_amt, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No invoices found.</td>
                    </tr>
                    @endforelse
                    
                </tbody>

            </table>
        </div>




        <div class="total" style="padding: 0px">
            <p><strong>Total Income :</strong>  {{$symbol}}{{ number_format($total_invoice_amt, 2) }} </p>
            <p><strong>Total Expense : </strong>{{$symbol}}{{ number_format($suppliers->sum('amount'), 2) }} </p>
            <p><strong>Net Income : </strong> @php
                $netIncome = $total_invoice_amt - $suppliers->sum('amount');
                @endphp
                {{$symbol}}{{ number_format($netIncome, 2) }}</p>

        </div>



        <div class="footer">
            <p> </p>
        </div>
    </div>
</body>

</html>