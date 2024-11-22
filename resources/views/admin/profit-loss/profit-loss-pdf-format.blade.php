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
     

        .table-responsive {
            width: 100%;
            margin: 20px 0;
        }

        .table-profit-loss {
            width: 100%;
            border-collapse: collapse;
        }

        .table-profit-loss th, .table-profit-loss td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }

        .thead-light {
            background-color: #f8f9fa;
            color: #495057;
        }

        .thead-light th {
            font-weight: bold;
        }

        .profitloss-bg {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .total-expense td {
            text-align: right;
        }

        .table-center {
            width: 100%;
            margin-top: 20px;
        }

        .total-expense td, .profitloss-bg td {
            font-size: 16px;
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

        .expenses {
            text-align: left;
            margin-left: 1px;
        }

        .expenses div {
            margin-bottom: 5px;
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

        .expense-total-row td {
            text-align: right;
        }

        .expense-details {
            display: flex;
            justify-content: space-between;
        }

        .expense-details .expense-text {
            text-align: left;
        }

        .expense-details .expense-total {
            text-align: right;
        }

    </style>
</head>

<body>
    <h1>Profit & loss </h1>
    <div class="table-responsive">
        <div class="table-profit-loss">
            <table class="table table-center table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Branch</th>
                        <th>Package</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>User</th>
                        <th>Created Date</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $total_invoice_amt = 0;  
                        $total_supplier_expenses = 0;
                        $symbol = '₹'; 
                    @endphp
                    @forelse ($invoices as $invoice)
                        @php
                            $symbol = $invoice->currency->symbol ?? '₹';
                            $package_amt = $invoice->package->amount;
                            $tax = $invoice->vat;
                            $discount = $invoice->discount;
                            $discount_amt = ($invoice->discount_type == 'Fixed') ? $discount : ($package_amt * $discount) / 100;
                            $amount_after_discount = $package_amt - $discount_amt;
                            $tax_amt = ($amount_after_discount * $tax) / 100;
                            $total_amt = $amount_after_discount + $tax_amt;
                            $total_invoice_amt += $total_amt;
                        @endphp

                        <tr>
                            <td>{{ $invoice->branch->branch_name ?? '' }}</td>
                            <td>{{ $invoice->package->package_name ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('F') }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('Y') }}</td>
                            <td>{{ $invoice->user->first_name ?? '' }} {{ $invoice->user->last_name ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y h:i A') }}</td>
                            <td>{{ $symbol }}{{ number_format($total_amt, 2) }}</td>
                        </tr>

                        @php
                            $invoice_total_expense = 0; 
                        @endphp

                        @foreach ($invoice->services as $service)
                            @php
                                $supplier = $service->suplyer;
                                $supplier_expenses = $supplier->expenses;
                                $supplier_expense_total = $supplier_expenses->sum('amount');
                                $invoice_total_expense += $supplier_expense_total;
                                $total_supplier_expenses += $supplier_expense_total;
                            @endphp

                            <!-- Supplier Details Row -->
                            <tr>
                                <td colspan="2" class="text-left"><strong>Supplier: {{ $supplier->name }}</strong></td>
                                <td colspan="5">
                                    <div class="text-left"><strong>Expenses:</strong></div>
                                    <div class="expenses">
                                        @foreach ($supplier_expenses as $expense)
                                            <div>{{ $expense->title }} - {{ $symbol }}{{ number_format($expense->amount, 2) }}</div>
                                            <br>
                                        @endforeach
                                    </div>
                                    <div class="text-right"><strong>Total:</strong> {{ $symbol }}{{ number_format($supplier_expense_total, 2) }}</div>
                                </td>
                            </tr>
                        @endforeach

                        <!-- Total Expense for the invoice -->
                        <tr class="total-expense">
                            <td colspan="6"><strong>Total Expense for this Invoice</strong></td>
                            <td><strong>{{ $symbol }}{{ number_format($invoice_total_expense, 2) }}</strong></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>

                <tr class="profitloss-bg">
                <td colspan="6"><strong>Total Income</strong></td>                   
                    <td><strong>{{ $symbol }}{{ number_format($total_invoice_amt, 2) }}</strong></td>
                </tr>

                <tr class="profitloss-bg">
                   <td colspan="6"><strong>Total Expense</strong></td>                  
                    <td><strong>{{ $symbol }}{{ number_format($total_supplier_expenses, 2) }}</strong></td>
                </tr>

                <tr class="profitloss-bg">
                    <td colspan="6"><strong>Net Income</strong></td>                  
                    <td><strong>{{ $symbol }}{{ number_format($total_invoice_amt - $total_supplier_expenses, 2) }}</strong></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Footer for PDF -->
    <div class="footer">
        <p>Profit & Loss Report - Powered by Your Company</p>
    </div>
</body>

</html>
