<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .container {
            width: 700px;
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px; /* Adjust the size as needed */
            margin-bottom: 20px;
        }
        .invoice-details, .bank-details {
            margin-top: 20px;
            font-size: 14px;
        }
        .items-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .items-table th {
            background-color: #f4f4f4;
        }
        .total {
            margin-top: 20px;
            text-align: right;
        }
        .bank-details {
            margin-top: 30px;
            font-size: 12px;
        }
        .thank-you {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Invoice Header with Logo -->
        <div class="header">
            <img src="{{ url('public/assets/img/logo2.png') }}" alt="Company Logo">
            <h1>ESTIMATE</h1>
        </div>

        <!-- Company and Invoice Details -->
        <p>Centurion Luxury Travel & Tourism LLC</p>
        <p>Head Office: {{ $branch_address }}</p>
        <p>P.O. Box: 123347, +971 40 262 0453, TRN - 100513805000003</p>

        <!-- Invoice Details -->
        <div class="bank-details">
            <p>Date: <b>{{ $quotation_date }}</b></p>
            <p>Estimate #: <b>{{ $quotation_number }}</b></p>
            <p>Bill to: <b>{{ $bill_to }}</b></p>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>No. of TKTS</th>
                    <th>Rate</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item['description'] }}</td>
                    <td>{{ $item['no_of_tkts'] }}</td>
                    <td>{{ number_format($item['rate'], 2) }}</td>
                    <td>{{ number_format($item['amount'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="total">
            <p><strong>Subtotal:</strong> {{ number_format($subtotal, 2) }} AED</p>
            <p><strong>Discount%:</strong> {{ number_format($discount, 2) }} AED</p>
            <p><strong>Tax :</strong> {{ number_format($tax, 2) }} AED</p>
            <p><strong>Total:</strong> {{ number_format($total, 2) }} AED</p>
        </div>

        <!-- Bank Details -->
        <div class="bank-details">
            <p><strong>Bank Details:</strong></p>
            <p>Bank: RAK BANK</p>
            <p>Holder / Beneficiary: CENTURION LUXURY TRAVEL & TOURISM LLC</p>
            <p>Account Number: 0332964062001</p>
            <p>IBAN: AE39 0400 0003 3296 4062 001</p>
            <p>Swift Code: NRAKAEAK</p>
            <p>Branch Address: {{ $branch_address }}</p>
        </div>

        <!-- Thank You -->
        <div class="thank-you">
            <p>THANK YOU FOR YOUR BUSINESS!</p>
        </div>
    </div>
</body>
</html>
