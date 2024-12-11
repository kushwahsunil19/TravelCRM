@extends('admin.layouts.master')
@section('content')

<!-- Main Wrapper -->
@include('admin.layouts.common-sidebar')

<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="content-page-header">
                <h5>Staff Report</h5> <!-- Updated title for clarity -->
                <div class="list-btn">
                    <ul class="filter-list">
                        <li>
                            <a class="btn btn-filters w-auto popup-toggle" id="filterToggle" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" title="Filter">
                                <span class="me-2"><img src="{{ url('public/assets/img/icons/filter-icon.svg') }}"
                                        alt="filter"></span>Filter
                            </a>
                        </li>
                        <li>
                            <div class="dropdown dropdown-action" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                title="Download">
                                <a href="#" class="btn-filters" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span><i class="fe fe-download"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="d-block">
                                        <li>
                                            <a class="d-flex align-items-center download-item"
                                                href="{{ route('staff-wise-report.downloadPDF', request()->query()) }}">
                                                <i class="far fa-file-pdf me-2"></i>PDF
                                            </a>
                                        </li>
                                        <li>
                                            <a class="d-flex align-items-center download-item"
                                                href="{{ route('staff-wise-report.downloadCSV', request()->query()) }}">
                                                <i class="far fa-file-text me-2"></i>CSV
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="toggle-sidebar">
            <div class="sidebar-layout-filter">
                <div class="sidebar-header">
                    <h5>Filter</h5>
                    <a href="#" class="sidebar-closes"><i class="fa-regular fa-circle-xmark"></i></a>
                </div>
                <div class="sidebar-body">
                    <form action="{{ route('staff-wise-report.index') }}" method="GET" autocomplete="off">
                        <!-- User Name Filter -->
                        <div class="form-group">
                            <label for="user_name">User Name</label>
                            <input type="text" name="user_name" id="user_name" class="form-control"
                                placeholder="Enter user name" value="{{ request('user_name') }}">
                        </div>

                        <!-- Email Filter -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email"
                                value="{{ request('email') }}">
                        </div>

                        <!-- Mobile Filter -->
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" name="mobile" id="mobile" class="form-control"
                                placeholder="Enter mobile number" value="{{ request('mobile') }}">
                        </div>

                        <!-- Role Filter -->
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="" {{ request('role') == '' ? 'selected' : '' }}>Choose Role</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="" {{ request('status') == '' ? 'selected' : '' }}>Choose Status</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Filter Buttons -->
                        <div style="margin-top: 12px">
                            <div class="filter-buttons">
                                <!-- Apply Button -->
                                <button type="submit"
                                    class="d-inline-flex align-items-center justify-content-center btn w-100 btn-primary">
                                    Apply
                                </button>
                                <!-- Reset Button -->
                                <button type="button"
                                    class="d-inline-flex align-items-center justify-content-center btn w-100 btn-secondary"
                                    onclick="resetForm()">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- User Table -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                           <table class="table table-center table-hover datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>S.NO</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Role</th>
                                    <th>Created On</th>
                                    <th>Status</th>
                                    <th>Gross Amount</th>
                                    <th>Net Cost</th>
                                    <th>Net Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $totalGrossAmount = 0;
                                $totalNetCost = 0;
                                $totalNetProfit = 0;
                        
                                $symbol = 'د.إ'; // Default currency symbol (AED)
                                @endphp
                        
                                @if($users->isEmpty())
                                <tr>
                                    <td colspan="10" class="text-center">No data available</td>
                                </tr>
                                @else
                                @foreach ($users as $user)
                                @php
                                $grossAmountRow = 0;
                                $netAmountRow = 0;
                        
                                // Iterate through each user's invoices
                                foreach ($user->invoices as $invoice) {
                                    // Fetch currency and conversion rates
                                    $currency_code = $invoice->currency->code ?? 'AED';
                                    $rates = getCurrencyRate($currency_code); // Assume this function returns an array of rates.
                        
                                    // Calculate Gross and Net Amount
                                    $grossAmount = ($invoice->package->amount ?? 0) * ($invoice->no_of_passenger ?? 1);
                                    $netAmount = ($invoice->package->net_amount ?? 0) * ($invoice->no_of_passenger ?? 1);
                        
                                    // Apply Discounts
                                    $discount = $invoice->discount ?? 0;
                                    $discountAmount = ($invoice->discount_type === 'Fixed') ? $discount : ($grossAmount * $discount) / 100;
                        
                                    // Currency Conversion
                                    $grossAmount *= $rates['AED'] ?? 1;
                                    $netAmount *= $rates['AED'] ?? 1;
                                    $discountAmount *= $rates['AED'] ?? 1;
                        
                                    // Apply Tax
                                    $taxRate = $invoice->vat ?? 0;
                                    $amountAfterDiscount = $grossAmount - $discountAmount;
                                    $taxAmount = ($amountAfterDiscount * $taxRate) / 100;
                        
                                    $grossAmount = $amountAfterDiscount + $taxAmount;
                        
                                    // Accumulate totals for the current user
                                    $grossAmountRow += $grossAmount;
                                    $netAmountRow += $netAmount;
                                }
                        
                                // Calculate Profit for the User
                                $profitAmountRow = $grossAmountRow - $netAmountRow;
                        
                                // Accumulate global totals
                                $totalGrossAmount += $grossAmountRow;
                                $totalNetCost += $netAmountRow;
                                $totalNetProfit += $profitAmountRow;
                                @endphp
                        
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile ?? 'N/A' }}</td>
                                    <td>{{ $user->roles->isNotEmpty() ? $user->roles->first()->name : 'No Role' }}</td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    <td>{{ number_format($grossAmountRow, 2) }}</td>
                                    <td>{{ number_format($netAmountRow, 2) }}</td>
                                    <td>{{ number_format($profitAmountRow, 2) }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="text-end"><strong>Total Amount:</strong></td>
                                    <td><strong>{{ $symbol }} {{ number_format($totalGrossAmount, 2) }}</strong></td>
                                    <td><strong>{{ $symbol }} {{ number_format($totalNetCost, 2) }}</strong></td>
                                    <td><strong>{{ $symbol }} {{ number_format($totalNetProfit, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Pagination -->
        <div class="row">
            <div class="col-sm-12">
                {{ $users->links() }}
                <!-- Laravel pagination links -->
            </div>
        </div>

    </div>
</div>

<!-- JavaScript to toggle the filter sidebar -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    var filterToggle = document.getElementById('filterToggle');
    var filterSidebar = document.querySelector('.toggle-sidebar');

    filterToggle.addEventListener('click', function(event) {
        event.preventDefault();
        filterSidebar.classList.toggle('active');
    });

    // Close button functionality
    var closeSidebar = document.querySelector('.sidebar-closes');
    closeSidebar.addEventListener('click', function(event) {
        event.preventDefault();
        filterSidebar.classList.remove('active');
    });
});

function resetForm() {
    // Clear the input values by setting them to an empty string
    document.getElementById('user_name').value = '';
    document.getElementById('email').value = '';
    document.getElementById('mobile').value = '';
    document.getElementById('role').value = '';
    document.getElementById('status').value = ''; // Ensure status filter is cleared

    // Redirect to the same page to reload with default values
    window.location.href = '{{ route("staff-wise-report.index") }}';
}
</script>

@endsection