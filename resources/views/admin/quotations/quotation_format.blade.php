<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Estimate PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <style>
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

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th,
        .table td {
            border: 1px solid black;
            padding: 4px;
            word-wrap: break-word;
            word-break: break-word;
            white-space: normal;
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

        @media print {
            .table {
                page-break-inside: auto;
            }

            .table tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            .table thead {
                display: table-header-group;
            }

            .table tbody tr {
                display: table-row;
            }
        }

        ul li {
            list-style-type: none !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <nav class="navbar navbar-light">
                <div class="container-fluid" style="padding: 0px">
                    <a class="navbar-brand" href="#">
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/logo2.png'))) }}"
                            alt="Company Logo" />
                    </a>
                    <div style="float:right; text-align: right;">
                        <h1>ESTIMATE</h1>
                        <p>{{ $branch_address }}</p>
                    </div>
                </div>
            </nav>
        </div>

        <hr />

        <!-- Billing Information -->
        <div class="row">
            <table style="width: 100%; margin-bottom: 20px;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <p>
                            <b style="color: #cbc5c5;">BILL TO</b><br>
                            <b>Mr. {{ $bill_to }}</b><br />
                            {{ $bill_mobile }}<br />
                            {{ $bill_city }}, {{ $bill_state }}<br />
                            {{ $bill_country }}<br />
                            <a href="mailto:{{ $bill_email }}" style="text-decoration: none; color: black;">
                                {{ $bill_email }}
                            </a>
                        </p>
                    </td>
                    <td style="width: 50%; text-align: right;">
                        <p>
                            <b>Estimate Number:</b> {{ $quotation_number }}<br />
                            <b>Estimate Date:</b> {{ $quotation_date }}<br />
                            <b>No. of Nights:</b> {{ $no_of_night }}<br />
                            <b>No. of Passengers:</b> {{ $no_of_passenger }}<br />
                            <b>Valid Until:</b> {{ now()->addDays(30)->toDateString() }}<br />
                            <b>Estimate Total:</b> {{$curreny_symbol}}{{ number_format($total, 2) }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Services Table -->
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align: left;">Service</th>
                        <th style="text-align: left;">Description</th>
                        <th style="text-align: left;">Amount ({{$currency_code}})</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($items) && is_array($items))
                        @foreach($items as $item)
                            @if(is_array($item))
                                <tr>
                                    <td><b>{{ $item['package_name'] }}</b></td>
                                    <td>{!! $item['description'] !!}</td>
                                    <td>{{$curreny_symbol}}{{ number_format($item['amount'] ?? 0, 2) }}</td>
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

        <!-- Total Section -->
        <div class="total" style="margin-top: 20px;">
            <p>
                <strong>Sub Total :</strong> {{$curreny_symbol}}{{ number_format($subtotal, 2) }}<br />
                <strong>Discount:</strong> @if($discount_type == 'Fixed') {{$curreny_symbol}} @endif{{ number_format($discount, 2) }}<br />
                <strong>Vat %:</strong> {{ number_format($tax, 2) }}<br />
                <strong>Estimate Total (AED):</strong> د.إ{{ number_format($total_in_aed, 2) }}<br />
                <strong>Estimate Total (USD):</strong> ${{ number_format($total_in_usd, 2) }}<br />
                <strong>Estimate Total (INR):</strong> ₹{{ number_format($total_in_inr, 2) }}
            </p>
        </div>

        <!-- Notes Section -->
        <div class="notes" style="margin-top: 20px;">
            <h6>Notes / Terms</h6>
            <p>Payments should be made in favor of “{{ $bill_to }}”</p>
            <p><strong>ACCOUNT DETAILS</strong></p>
            @if(!empty($companyBankDetails) && is_array($companyBankDetails))
                @foreach($companyBankDetails as $bank)
                    <div style="{{ $loop->last ? '' : 'border-bottom: 1px solid #ddd; padding-bottom: 15px; margin-bottom: 15px;' }}">
                        <strong>Account Name:</strong> {{ $bank['account_holder_name'] }}<br />
                        <strong>Bank:</strong> {{ $bank['bank_name'] }}<br />
                        <strong>Branch:</strong> {{ $bank['branch_name'] }}<br />
                        <strong>Account Number:</strong> {{ $bank['account_no'] }}<br />
                        <strong>IFSC Code:</strong> {{ $bank['ifsc_code'] }}<br />
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</body>

</html>
