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
        font-family: Arial, sans-serif;
        background-color: #ffffff;
        font-size: 12px;
        width: 210mm;
        /* A4 Width */
        margin: auto;
        padding-bottom: 60px;
        /* Space for the footer */
        position: relative;
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
    </style>
</head>

<body>
    <div class="header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid" style="padding: 0px">
                <a class="navbar-brand" href="#">
                    <!-- Dynamic Image Placeholder -->
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/logo2.png'))) }}"
                        alt="Company Logo" />
                </a>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item text-end">
                        <h1>ESTIMATE</h1>
                        <!-- Dynamic Company Info -->
                        {{ $data['branch_address'] }}<br />
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <hr />

    <div class="content-wrapper" style="padding: 0px">
        <div class="row">
            <div class="col-6">
                <h7 style="color: #cbc5c5">BILL TO</h7>
                <p>
                    <!-- Dynamic Bill To Details -->
                    <b>Mr.{{ $data['bill_to'] }}</b><br />
                    {{ $data['bill_mobile'] }}<br />
                    {{ $data['bill_city'] }} {{ $data['bill_state'] }}<br />
                    {{ $data['bill_country'] }}<br /><br />
                    <a href="mailto:{{ $data['bill_email'] }}"
                        style="text-decoration: none; color: black">{{ $data['bill_email'] }}</a>
                </p>
            </div>
            <div class="col-6 text-end">
                <p>
                    <!-- Dynamic Estimate Info -->
                    <b>Estimate Number:</b> {{ $data['quotation_number'] }}<br />
                    <b>Estimate Date:</b> {{ $data['quotation_date'] }}<br />
                    <b>Valid Until:</b> {{ now()->addDays(30)->toDateString() }}<br />
                    <b>Estimate Total:</b> ₹{{ number_format($data['total'], 2) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Services Table -->
    <div class="content-wrapper" style="padding: 0px">
        <table class="table">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Description</th>
                    <th>Amount </th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic Items -->
                @if(!empty($data['items']) && is_array($data['items']))
                @foreach($data['items'] as $item)
                <tr>
                    <td style="text-align:justify;"><b>{{ $item['package_name'] }}</b></td>
                    <td style="text-align:justify;">{!! $item['description'] !!}</td>
                    <td style="text-align:justify;">{{ number_format($item['amount'], 2) }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <hr />

    <!-- Total and Notes Section -->
    <div class="total" style="padding: 0px">
        <p>
            <strong>Sub Total:</strong> ₹{{ number_format($data['subtotal'], 2) }}<br />
        <p><strong>Discount:</strong> {{ number_format($data['discount'], 2) }} </p>
        <p><strong>Vat %:</strong> {{ number_format($data['tax'], 2) }} </p>
        <strong>Estimate Total:</strong> ₹{{ number_format($data['total'], 2) }}
        </p>
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
                    Payments should be made in favor of “{{ $data['bill_to'] }}”<br /><br />
                    <strong>ACCOUNT DETAIL</strong><br />
                    Account Name: {{ $data['bill_to'] }}<br />
                    Bank: {{ $data['bank_name'] }}<br />
                    Branch: {{ $data['bank_branch'] }}<br />
                    Account Number: {{ $data['account_no'] }}<br />
                    @if (isset($data['branch_name']) && strpos(strtolower(trim($data['branch_name'])), 'dubai') !==
                    false)
                    IBAN No: {{ $data['iban_no'] }}<br />
                    SWIFT Code: {{ $data['ifsc_code'] }}
                    @else
                    IFSC Code: {{ $data['ifsc_code'] }}
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="footer">
        <p> Estimate #{{ $data['quotation_number'] }}</p>
    </div>
</body>

</html>