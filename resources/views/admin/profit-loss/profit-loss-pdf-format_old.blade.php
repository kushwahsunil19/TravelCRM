<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit & Loss Report</title>
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
    </style>
</head>
<body>
    <h1 style="text-align: center;">Profit & Loss Report</h1>
    <div class="table-responsive">
        <table>
            <thead class="thead-light">
                <tr>
                    <th>Branch</th>
                    <th>Package</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>User</th>
                    <th>Created Date</th>
                    <th>Gross Amount</th>
                    <th>Net Cost</th>
                    <th>Net Profit</th>
                    <th>Expenses</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_invoice_amt = 0;
                    $total_net_amt = 0;
                    $net_profit_amt = 0;
                    $total_expenses = 0;
                    $symbol = '₹';
                @endphp

                @forelse ($invoices as $invoice)
                    @php
                        $symbol = $invoice->currency->symbol ?? '₹';
                        $package_amt = $invoice->package->amount ?? 0;
                        $net_amt_row = $invoice->package->net_amount ?? 0;
                        $total_net_amt += $net_amt_row;

                        $tax = $invoice->vat ?? 0;
                        $discount = $invoice->discount ?? 0;
                        $discount_amt = ($invoice->discount_type == 'Fixed') ? $discount : ($package_amt * $discount) / 100;

                        $amount_after_discount = $package_amt - $discount_amt;
                        $tax_amt = ($amount_after_discount * $tax) / 100;
                        $total_amt = $amount_after_discount + $tax_amt;
                        $total_invoice_amt += $total_amt;

                        $net_profit_amt_row = $total_amt - $net_amt_row;
                        $net_profit_amt += $net_profit_amt_row;

                        $invoice_expenses = $invoice->services->flatMap(function ($service) {
                            return $service->suplyer->expenses ?? [];
                        });
                        $expense_total = $invoice_expenses->sum('amount');
                        $total_expenses += $expense_total;
                    @endphp
                    <tr>
                        <td>{{ $invoice->branch->branch_name ?? '' }}</td>
                        <td>{{ $invoice->package->package_name ?? '' }}</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('F') }}</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('Y') }}</td>
                        <td>{{ $invoice->user->first_name ?? '' }} {{ $invoice->user->last_name ?? '' }}</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y h:i A') }}</td>
                        <td>{{ $symbol }}{{ number_format($total_amt, 2) }}</td>
                        <td>{{ $symbol }}{{ number_format($net_amt_row, 2) }}</td>
                        <td>{{ $symbol }}{{ number_format($net_profit_amt_row, 2) }}</td>
                        <td>
                            @if ($invoice_expenses->isNotEmpty())
                                <div class="expenses-section">
                                <strong>Supplier: {{ optional(optional($invoice->services->first())->suplyer)->name ?? 'N/A' }}</strong>
                                @foreach ($invoice_expenses as $expense)
                                        <div>{{ $expense->title }}: {{ $symbol }}{{ number_format($expense->amount, 2) }}</div>
                                    @endforeach
                                    <strong>Total: {{ $symbol }}{{ number_format($expense_total, 2) }}</strong>
                                </div>
                            @else
                                <div>No Expenses</div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">No invoices found.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="profitloss-bg">
                    <td><strong>Total</strong></td>
                    <td colspan="5"></td>
                    <td><strong>{{ $symbol }}{{ number_format($total_invoice_amt, 2) }}</strong></td>
                    <td><strong>{{ $symbol }}{{ number_format($total_net_amt, 2) }}</strong></td>
                    <td><strong>{{ $symbol }}{{ number_format($net_profit_amt, 2) }}</strong></td>
                    <td><strong>{{ $symbol }}{{ number_format($total_expenses, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="footer">
        <p>Profit & Loss Report - Powered by Your Company</p>
    </div>
</body>
</html>
