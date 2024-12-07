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
        </tr>
    </thead>
    <tbody>
        @php
            $total_invoice_amt = 0;
            $total_net_amt = 0;
            $net_profit_amt = 0;
            $rates = getCurrencyRate('AED' );
            $symbol = 'د.إ';
        @endphp

        @forelse ($invoices as $invoice)
            @php
              
                $currency_code = $invoice->currency->code ?? 'AED';
                $package_amt = ($invoice->package->amount ?? 0) * ($invoice->no_of_passenger ?? 1);
                $net_amt_row = ($invoice->package->net_amount ?? 0) * ($invoice->no_of_passenger ?? 1);
                if($currency_code =='AED'){
                    $package_amt = $package_amt * $rates['AED'];
                    $net_amt_row =   $net_amt_row * $rates['AED'];
                }else if($currency_code =='INR'){
                    $package_amt = $package_amt * $rates['INR'];
                    $net_amt_row =   $net_amt_row * $rates['INR'];
                }else if($currency_code =='USD'){
                    $package_amt = $package_amt * $rates['USD'];
                    $net_amt_row =   $net_amt_row * $rates['USD'];
                }
              

                $total_net_amt += $net_amt_row;

                $tax = $invoice->vat ?? 0;
                $discount = $invoice->discount ?? 0;

                $discount_amt = ($invoice->discount_type == 'Fixed') ? $discount : ($package_amt * $discount) / 100;

                $amount_after_discount = $package_amt - $discount_amt;
                $tax_amt = ($amount_after_discount * $tax) / 100;
                $total_amt = $amount_after_discount + $tax_amt;

                $total_invoice_amt_row = $total_amt;
                $total_invoice_amt += $total_invoice_amt_row;

                $net_profit_amt_row = $total_invoice_amt_row - $net_amt_row;
                $net_profit_amt += $net_profit_amt_row;
                
            @endphp

            <tr>
                <td>{{ $invoice->branch->branch_name ?? '' }}</td>
                <td>{{ $invoice->package->package_name ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('F') }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('Y') }}</td>
                <td>{{ $invoice->user->first_name ?? '' }} {{ $invoice->user->last_name ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y h:i A') }}</td>
                <td>{{ number_format($total_invoice_amt_row, 2) }}</td>
                <td>{{ number_format($net_amt_row, 2) }}</td>
                <td>{{ number_format($net_profit_amt_row, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">No invoices found.</td>
            </tr>
        @endforelse
    </tbody>

    <tfoot>
        <tr class="profitloss-bg">
            <td colspan="6" class="text-end"><strong>Total Amount:</strong></td>           
           
            <td><strong>{{ $symbol }} {{ number_format($total_invoice_amt, 2) }}</strong></td>
            <td><strong>{{ $symbol }} {{ number_format($total_net_amt, 2) }}</strong></td>
            <td><strong>{{ $symbol }} {{ number_format($net_profit_amt, 2) }}</strong></td>
        </tr>
    </tfoot>
</table>

    </div>
</div>
