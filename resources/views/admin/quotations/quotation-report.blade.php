@extends('admin.layouts.master')
@section('content')


<!-- Main Wrapper -->
@include('admin.layouts.common-sidebar')
<!-- /Main Wrapper -->
<style>
    .datatable th {
    word-wrap: break-word !important;
    white-space: normal; /* Allow word wrapping in case of long words */
}
</style>
    <!-- Page Content -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="content-page-header">
                    <h5>Quotation Report</h5>
                    <div class="list-btn">
                        <ul class="filter-list">
                            <li>
                                <a class="btn btn-filters w-auto popup-toggle" id="filterToggle"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="Filter">
                                    <span class="me-2"><img src="{{url('public/assets/img/icons/filter-icon.svg')}}"
                                            alt="filter"></span>Filter
                                </a>
                            </li>
                            <li>
                                <div class="dropdown dropdown-action" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="Download">
                                    <a href="#" class="btn-filters" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span><i class="fe fe-download"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="d-block">
                                            <li>
                                                <a class="d-flex align-items-center download-item"
                                                    href="{{ route('quotations.downloadPDF', request()->query()) }}">
                                                    <i class="far fa-file-pdf me-2"></i>PDF
                                                </a>

                                            </li>
                                            <li>
                                                <a class="d-flex align-items-center download-item"
                                                    href="{{ route('quotations.downloadCSV', request()->query()) }}">
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
                        <form action="{{ route('quotation-report.index') }}" method="GET" autocomplete="off">
                            <!-- Quotation No Filter -->
                            <div class="form-group">
                                <label for="quotation_no">Quotation No</label>
                                <input type="text" name="quotation_no" id="quotation_no" class="form-control"
                                    placeholder="Enter quotation number" value="{{ request('quotation_no') }}">
                            </div>

                            <!-- Branch Filter -->
                            <div class="form-group">
                                <label for="branch">Branch</label>
                                <input type="text" name="branch" id="branch" class="form-control"
                                    placeholder="Enter branch" value="{{ request('branch') }}">
                            </div>

                            <!-- Package Filter -->
                            <div class="form-group">
                                <label for="package">Package</label>
                                <input type="text" name="package" id="package" class="form-control"
                                    placeholder="Enter package name" value="{{ request('package') }}">
                            </div>

                            <!-- Partner Filter -->
                            <div class="form-group">
                                <label for="partner">Partner</label>
                                <input type="text" name="partner" id="partner" class="form-control"
                                    placeholder="Enter partner name" value="{{ request('partner') }}">
                            </div>

                            <!-- Discount Type Filter -->
                            <div class="form-group">
                                <label for="discount_type">Discount Type</label>
                                <select name="discount_type" id="discount_type" class="form-control">
                                    <option value="" {{ request('discount_type') == '' ? 'selected' : '' }}>Choose
                                        Discount Type</option>
                                    <option value="Percentage"
                                        {{ request('discount_type') == 'Percentage' ? 'selected' : '' }}>Percentage
                                    </option>
                                    <option value="Fixed" {{ request('discount_type') == 'Fixed' ? 'selected' : '' }}>
                                        Fixed</option>
                                </select>
                            </div>

                            <!-- Filter Buttons -->
                            <div style="margin-top:12px">
                                <div class="filter-buttons">
                                    <!-- Apply Button -->
                                    <button type="submit"
                                        class="d-inline-flex align-items-center justify-content-center btn w-100 btn-primary">
                                        Apply
                                    </button>
                                    <!-- Reset Button -->
                                    <button type="button"
                                        class="d-inline-flex align-items-center justify-content-center btn w-100 btn-secondary" id="reset-btn">
                                        Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Table Section -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-table">
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-center table-hover datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>S.NO</th>
                                    <th>Quotation No</th>
                                    <th>Branch</th>
                                    <th>Package</th>
                                    <th>No of Passenger</th>
                                    <th>Partner</th>
                                    <th>Discount Type</th>
                                    <th>Discount</th>
                                    <th>VAT</th>
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
                                @endphp

                                @if($quotations->isEmpty())
                                <tr>
                                    <td colspan="11" class="text-center">No data available</td>
                                </tr>
                                @else
                                @foreach ($quotations as $quotation)
                                @php
                                // Calculate values
                                $grossAmount = $quotation->package ? $quotation->package->amount  * $quotation->no_of_passenger : 0;
                                $discountAmount = $quotation->discount_type === 'Percentage' 
                                                    ? ($grossAmount * $quotation->discount / 100) 
                                                    : ($quotation->discount_type === 'Fixed' 
                                                        ? $quotation->discount 
                                                        : 0);
                                $vatAmount = ($grossAmount - $discountAmount) * $quotation->gst_tax / 100;
                                $netCost = $quotation->package->amount?$quotation->package->amount:0.00;
                                $netProfit = $grossAmount - $netCost;

                                // Add to totals
                                $totalGrossAmount += $grossAmount;
                                $totalNetCost += $netCost;
                                $totalNetProfit += $netProfit;
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $quotation->quotation_no }}</td>
                                    <td>{{ $quotation->branch ? $quotation->branch->city : 'N/A' }}</td>
                                    <td>{{ $quotation->package ? $quotation->package->package_name : 'N/A' }}</td>
                                    <td>{{$quotation->no_of_passenger}}</td>
                                    <td>
                                        <h2 class="table-avatar">
                                            @php
                                            $avatar = $quotation->partner->image 
                                                    ? url('public/profile/' . $quotation->partner->image) 
                                                    : url('public/assets/img/profiles/default.png');
                                            @endphp
                                            <a href="" class="avatar avatar-md me-2">
                                                <img class="avatar-img rounded-circle" src="{{ $avatar }}" alt="User Image">
                                            </a>
                                            <a href="">{{ $quotation->partner->name }} 
                                                <span>
                                                    <span class="__cf_email__" data-cfemail="">{{ $quotation->partner->email }}</span>
                                                </span>
                                            </a>
                                        </h2>
                                    </td>
                                    <td>{{ isset($quotation->discount_type)?$quotation->discount_type:'N/A' }}</td>
                                    <td>
                                        @if($quotation->discount_type == 'Fixed')
                                        ₹{{ $quotation->discount }}
                                        @elseif($quotation->discount_type == 'Percentage')
                                        {{ $quotation->discount }}%
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>{{ $quotation->gst_tax . '%' }}</td>
                                    <td>{{ number_format($grossAmount, 2) }}</td>
                                    <td>{{ number_format($netCost, 2) }}</td>
                                    <td>{{ number_format($netProfit, 2) }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8" class="text-center"><strong>Total Amount:</strong></td>
                                    <td><strong>{{ number_format($totalGrossAmount, 2) }}</strong></td>
                                    <td><strong>{{ number_format($totalNetCost, 2) }}</strong></td>
                                    <td><strong>{{ number_format($totalNetProfit, 2) }}</strong></td>
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
                    {{ $quotations->links() }}
                    <!-- Laravel pagination links -->
                </div>
            </div>

        </div> <!-- /content -->
    </div> <!-- /page-wrapper -->
</div> <!-- /main-wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- JavaScript to toggle the filter sidebar -->
<script>
    $(document).ready(function() {
    $(document).on('click', '#reset-btn', function() {   
        window.location.href = "{{ route('quotation-report.index') }}";
    });
});
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


</script>

@endsection