<div class="table-responsive">
    <div class="table-profit-loss">
        <table class="table table-center table-bordered" style="font-size: 14px; width: 100%;">
            <thead class="thead-light loss">
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
                               <td colspan="2"><strong>Supplier: {{ $supplier->name }}</strong></td>
                            <td colspan="4">
                                <strong>Expenses:</strong>
                                @foreach ($supplier_expenses as $expense)
                                    <div>{{ $expense->title }} - {{ $symbol }}{{ number_format($expense->amount, 2) }}</div>
                                @endforeach
                                <strong>Total:</strong> {{ $symbol }}{{ number_format($supplier_expense_total, 2) }}
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
                <td><strong>Total Income</strong></td>
                <td colspan="5"></td>
                <td><strong>{{ $symbol }}{{ number_format($total_invoice_amt, 2) }}</strong></td>
            </tr>

            <tr class="profitloss-bg">
                <td><strong>Total Expense</strong></td>
                <td colspan="5"></td>
                <td><strong>{{ $symbol }}{{ number_format($total_supplier_expenses, 2) }}</strong></td>
            </tr>

            <tr class="profitloss-bg">
                <td><strong>Net Income</strong></td>
                <td colspan="5"></td>
                <td><strong>{{ $symbol }}{{ number_format($total_invoice_amt - $total_supplier_expenses, 2) }}</strong></td>
            </tr>
        </table>
    </div>
</div>
