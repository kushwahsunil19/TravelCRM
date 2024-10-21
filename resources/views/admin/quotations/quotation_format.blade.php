<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Static Estimate</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <style>
    /* General Layout */
    body {
        margin: 0;
        padding: 0;
        background: #fff;
        font-family: 'DejaVu Sans', sans-serif;
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
                    <a class="navbar-brand" href="#">
                        <!-- Dynamic Image Placeholder -->
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/logo2.png'))) }}"
                            alt="Company Logo" />
                    </a>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="float:right;">
                        <li class="nav-item text-end">
                            <h1>ESTIMATE</h1>
                            <!-- Dynamic Company Info -->
                            {{ $branch_address }}<br />
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <hr />

        <div class="content-wrapper" style="padding: 0px">
            <div class="row">
                <!-- BILL TO and Estimate Info Table -->
                <table style="width: 100%; margin-bottom: 20px;">
                    <tr>
                        <!-- Left Column: BILL TO -->
                        <td style="width: 50%; vertical-align: top;">
                            <p>
                                <b style="color: #cbc5c5;">BILL TO</b><br>
                                <b>Mr.{{ $bill_to }}</b><br />
                                {{ $bill_mobile }}<br />
                                {{ $bill_city }} {{ $bill_state }}<br />
                                {{ $bill_country }}<br />
                                <a href="mailto:{{ $bill_email }}" style="text-decoration: none; color: black;">
                                    {{ $bill_email }}
                                </a>
                            </p>
                        </td>

                        <!-- Right Column: Estimate Info -->
                        <td style="width: 50%; vertical-align: top; text-align: right;">
                            <p>
                                <b>Estimate Number:</b> {{ $quotation_number }}<br />
                                <b>Estimate Date:</b> {{ $quotation_date }}<br />
                                <b>Valid Until:</b> {{ now()->addDays(30)->toDateString() }}<br />
                                <b>Estimate Total:</b> {{$curreny_symbol}}{{ number_format($total, 2) }}
                            </p>
                        </td>
                    </tr>
                </table>


            </div>
        </div>

        <!-- Services Table -->
        <div class="content-wrapper" style="padding: 0px">
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align:left; ">Service</th>
                        <th style="text-align:left; ">Description</th>
                        <th style="text-align:left; ">Amount ({{$currency_code}})</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic Items -->
                    @if(!empty($items) && is_array($items))
                    @foreach($items as $item)
                    @if(is_array($item))
                    <tr style="text-align:center;">
                        <td style="text-align:justify;"><b>{{ $item['package_name'] }}</b></td>
                        <td style="text-align:justify;">{!! $item['description'] !!}</td>
                        <td style="text-align:justify;">{{$curreny_symbol}}{{ number_format($item['amount'] ?? 0, 2) }}</td>
                    </tr>
                    @endif
                    @endforeach
                    @else
                    <tr>
                        <td colspan="3" class="text-center">No items available</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <hr />

        <!-- Total and Notes Section -->
        <!-- <div class="total" style="padding: 0px">
            <p>
                <strong>Total:</strong> ${{ number_format($total, 2) }}<br />
                <strong>Estimate Total (INR):</strong> ${{ number_format($total, 2) }}
            </p>
        </div> -->
        <div class="total" style="padding: 0px">
            <p><strong>Sub Total :</strong> {{$curreny_symbol}}{{ number_format($subtotal, 2) }} </p>
            <p><strong>Discount @if($discount_type == 'Percentage') (%) @endif: </strong>@if($discount_type == 'Fixed') {{$curreny_symbol}} @endif{{ number_format($discount, 2) }} </p>
            <p><strong>Vat (%) : </strong>{{ number_format($tax, 2) }} </p>
            <p><strong>Estimate Total :</strong> {{$curreny_symbol}}{{ number_format($total, 2) }} </p>
        </div>

        <!-- Notes / Terms Section -->
        <div class="note1">
            <div class="content-wrapper total-section">
                <div class="notes">
                    <h6>Notes / Terms</h6>
                    <p>
                        <!-- Dynamic Notes -->
                        Timeline: <br />
                        Advance: <br />
                        Payments should be made in favor of “{{ $bill_to }}”<br /><br />
                        <strong>ACCOUNT DETAIL</strong><br />
                        Account Name: {{ $bill_to }}<br />
                        Bank: {{ $bank_name }}<br />
                        Branch: {{ $bank_branch }}<br />
                        Account Number: {{ $account_no }}<br />
                        @if (isset($branch_name) && strpos(strtolower(trim($branch_name)), 'dubai') !==
                        false)
                        IBAN No: {{ $iban_no }}<br />
                        SWIFT Code: {{ $ifsc_code }}
                        @else
                        IFSC Code: {{ $ifsc_code }}
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p> Estimate #{{ $quotation_number }}</p>
        </div>
    </div>
</body>

</html>