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
                    <th>Gross Amount</th>
                    <th>Net Cost</th>
                    <th>Net Profit</th>
                    <th>Expenses</th> <!-- Added Expenses column -->
                </tr>
            </thead>
            <tbody>
                @php
                    $total_invoice_amt = 0;
                    $total_net_amt = 0;
                    $net_profit_amt = 0;
                    $symbol = '₹';
                    $net_supplier_expenses_total = 0;
                @endphp

                @forelse ($invoices as $invoice)
                    @php
                        $total_invoice_amt_row = 0;  // Total amount for this invoice
                        $net_amt_row = 0;           // Net amount for this invoice
                        $net_profit_amt_row = 0;    // Net profit for this invoice

                        // Currency Symbol
                        $symbol = $invoice->currency->symbol ?? '₹';

                        // Package details
                        $package_amt = $invoice->package->amount ?? 0; // Fallback to 0 if no amount
                        $net_amt_row = $invoice->package->net_amount ?? 0; // Fallback to 0 if no net amount
                        $total_net_amt += $net_amt_row;

                        // Tax and Discount
                        $tax = $invoice->vat ?? 0;
                        $discount = $invoice->discount ?? 0;
                        $discount_amt = ($invoice->discount_type == 'Fixed') ? $discount : ($package_amt * $discount) / 100;

                        // Calculate amounts
                        $amount_after_discount = $package_amt - $discount_amt;
                        $tax_amt = ($amount_after_discount * $tax) / 100;
                        $total_amt = $amount_after_discount + $tax_amt;

                        // Update totals
                        $total_invoice_amt_row = $total_amt;
                        $total_invoice_amt += $total_invoice_amt_row;

                        // Calculate net profit
                        $net_profit_amt_row = $total_invoice_amt_row - $net_amt_row;
                        $net_profit_amt += $net_profit_amt_row;
                    @endphp

                    <!-- Render Row -->
                    <tr>
                        <td>{{ $invoice->branch->branch_name ?? '' }}</td>
                        <td>{{ $invoice->package->package_name ?? '' }}</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('F') }}</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('Y') }}</td>
                        <td>{{ $invoice->user->first_name ?? '' }} {{ $invoice->user->last_name ?? '' }}</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y h:i A') }}</td>
                        <td>{{ $symbol }}{{ number_format($total_invoice_amt_row, 2) }}</td>
                        <td>{{ $symbol }}{{ number_format($net_amt_row, 2) }}</td>
                        <td>{{ $symbol }}{{ number_format($net_profit_amt_row, 2) }}</td>

                        <td>
                            @php
                                $invoice_expenses = collect([]);
                                $supplier_expenses_total = 0;
                            @endphp
                            
                            @foreach ($invoice->services as $service)
                                @php
                                    $supplier = $service->suplyer ?? null;
                                    $supplier_expenses = $supplier ? $supplier->expenses : collect([]);
                                    $supplier_expenses_total += $supplier_expenses->isNotEmpty() ? $supplier_expenses->sum('amount') : 0;
                                @endphp

                                @if ($supplier)
                                    <div>
                                        <strong>Supplier: {{ $supplier->name }}</strong>
                                        @if ($supplier_expenses->isNotEmpty())
                                            <div><strong>Expenses:</strong>
                                                @foreach ($supplier_expenses as $expense)
                                                    <div>{{ $expense->title }} - {{ $symbol }}{{ number_format($expense->amount, 2) }}</div>
                                                @endforeach
                                                <strong>Total: {{ $symbol }}{{ number_format($supplier_expenses_total, 2) }}</strong>
                                            </div>
                                        @else
                                            <div>No Expenses</div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    @php $net_supplier_expenses_total += $supplier_expenses_total; @endphp
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
                    <td><strong>{{ $symbol }}{{ number_format($net_supplier_expenses_total, 2) }}</strong></td> <!-- Total expenses for all suppliers -->
                </tr>
            </tfoot>
        </table>
    </div>
</div>
