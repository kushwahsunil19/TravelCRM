<div class="table-responsive">
    <div class="table-profit-loss">
        <table class="table table-center">
            <thead class="thead-light loss">
                <tr>
                    <th>Branch</th>
                    <th>Package</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $total_invoice_amt = 0;  $symbol = '₹'; @endphp
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
                        <td>{{ $symbol}}{{ number_format($total_amt, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No invoices found.</td>
                    </tr>
                @endforelse
            </tbody>

            <!-- Display the total income -->
            <tr class="profitloss-bg">
                <td>Total Income</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $symbol}}{{ number_format($total_invoice_amt, 2) }}</td>
            </tr>

            <!-- Display the expenses -->
            <tr class="profitloss-bg">
                <td>Total Expense</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $symbol}}{{ number_format($suppliers->sum('amount'), 2) }}</td>
            </tr>

            <!-- Display net income -->
            <tr class="profitloss-bg">
                <td>Net Income</td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    @php
                        $netIncome = $total_invoice_amt - $suppliers->sum('amount');
                    @endphp
                    {{ $symbol}} {{ number_format($netIncome, 2) }}
                </td>
            </tr>
        </table>
    </div>
</div>
