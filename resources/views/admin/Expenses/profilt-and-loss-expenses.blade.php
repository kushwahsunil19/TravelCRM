@extends('admin.layouts.master')
@section('content')


<!-- Main Wrapper -->
@include('admin.layouts.common-sidebar')
<!-- /Main Wrapper -->

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="content-page-header">
                <h5>Profit & Loss Expenses</h5>
                <div class="page-content">
                    <div class="list-btn">
                        <ul class="filter-list">
                            <li>
                                <a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="Filter"><span class="me-2"><img
                                            src="{{url('public/assets/img/icons/filter-icon.svg')}}"
                                            alt="filter"></span>Filter
                                </a>
                            </li>
                            <!-- <li>
                                <div class="dropdown dropdown-action" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="Download">
                                    <a href="#" class="btn-filters" data-bs-toggle="dropdown"
                                        aria-expanded="false"><span><i class="fe fe-download"></i></span></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="d-block">
                                            <li>
                                                <a class="d-flex align-items-center download-item"
                                                    href="javascript:void(0);" id="download-pdf-btn" download><i
                                                        class="far fa-file-pdf me-2"></i>PDF</a>
                                            </li>
                                            <li>
                                                <a class="d-flex align-items-center download-item"
                                                    href="javascript:void(0);" id="download-csv-btn" download><i
                                                        class="far fa-file-text me-2"></i>CSV</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li> -->
                            <!-- <li>
										<a class="btn-filters" href="javascript:void(0);" data-bs-toggle="tooltip"
											data-bs-placement="bottom" title="Print"><span><i
													class="fe fe-printer"></i></span> </a>
									</li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="profit-menu">
            <!-- <div class="row">
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div class="input-block mb-3">
                        <label>Branch</label>
                        <ul class="form-group">
                            <li>
                                <select class="select" name="branch" id="branch">

                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div class="input-block mb-3">
                        <label>Package</label>
                        <ul class="form-group">
                            <li>
                                <select class="select" name="package" id="package">
                                    <option value="">Select Package</option>

                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div class="input-block mb-3">
                        <label>Period</label>
                        <ul class="form-group">
                            <li>
                                <select class="select" name="year" id="year">
                                    <option value="">Select Year</option>
                                    @php
                                    $currentYear = now()->year; // Get the current year
                                    $startYear = $currentYear - 1; // Starting from 10 years ago
                                    $endYear = $currentYear + 10; // Ending 10 years in the future
                                    @endphp

                                    @for ($year = $startYear; $year <= $endYear; $year++) <option value="{{ $year }}">
                                        {{ $year }}</option>
                                        @endfor
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div class="input-block mb-3">
                        <label>From</label>
                        <div class="cal-icon cal-icon-info">
                            <input type="text" id="from_date" name="from_date" class="datetimepicker form-control"
                                placeholder="DD-MM-YYYY">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div class="input-block mb-3">
                        <label>To</label>
                        <div class="cal-icon cal-icon-info">
                            <input type="text" id="to_date" name="to_date" class="datetimepicker form-control"
                                placeholder="DD-MM-YYYY">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 ">
                    <div class="input-block mb-3">
                        <label>Display Columns by</label>
                        <ul class="form-group">
                            <li>
                                <select class="select" name="month" id="month">
                                    <option value="">Select Month</option>
                                    @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                    @endforeach
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="col-lg-4 col-md-6 col-sm-12">
                    <button class="btn btn-primary" id="filter-btn">Filter</button>
                    <button class="btn btn-danger" id="reset-btn">Reset</button>
                </div>
            </div> -->
        </div>

        <!-- Search Filter -->
        <div id="filter_inputs" class="card filter-card">
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="input-block mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="input-block mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="input-block mb-3">
                            <label>Phone</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card-table">
                    <div class="card-body">

                        <div class="table-responsive">
                            <div class="table-profit-loss">
                                <table class="table table-center">
                                    <thead class="thead-light loss">
                                        <tr>
                                            <th>Supplier Name</th>
                                            <th>Agent Name</th>
                                            <th>Description</th>
                                            <th>Expenses</th>
                                            <th>Gross</th>
                                            <th>Net Cost</th>
                                            <th>Net Profit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $gross = 0;
                                        $net_cost = 0;
                                        $net_profit = 0;
                                        @endphp

                                        @foreach ($suppliers as $supplier)
                                        @php
                                        $gross_row = 0;
                                        $net_cost_row = 0;

                                        // Calculate gross from invoices
                                        foreach ($supplier->invoices as $invoice) {
                                        $package_amount = $invoice->package?->amount ?? 0;
                                        $gross_row += $package_amount;
                                        }

                                        // Calculate net cost from expenses
                                        foreach ($supplier->expenses as $expense) {
                                        $net_cost_row += $expense->amount;
                                        }

                                        // Calculate net profit
                                        $net_profit_row = $gross_row - $net_cost_row;

                                        // Add to totals
                                        $gross += $gross_row;
                                        $net_cost += $net_cost_row;
                                        $net_profit += $net_profit_row;
                                        @endphp
                                        <tr>
                                            <td>{{ $supplier->name }}</td>
                                            <td>
                                                @if ($supplier->invoices->isNotEmpty())
                                                {{ $supplier->invoices->first()->partner?->name ?? 'N/A' }}
                                                @else
                                                N/A
                                                @endif
                                            </td>
                                            <td>{{ $supplier->description ?? 'N/A' }}</td>
                                            <td>
                                                @foreach ($supplier->expenses as $expense)
                                                <div>{{ $expense->title }} - {{ number_format($expense->amount, 2) }}
                                                </div>
                                                @endforeach
                                            </td>
                                            <td>{{ number_format($gross_row, 2) }}</td>
                                            <td>{{ number_format($net_cost_row, 2) }}</td>
                                            <td>{{ number_format($net_profit_row, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                    <!-- Display the total values -->
                                    <tfoot>
                                        <tr class="profitloss-bg">
                                            <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                            <td>{{ number_format($gross, 2) }}</td>
                                            <td>{{ number_format($net_cost, 2) }}</td>
                                            <td>{{ number_format($net_profit, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>



                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Page Wrapper -->

<!-- Add Asset -->
<div class="toggle-sidebar ledge">
    <div class="sidebar-layout-filter">
        <div class="sidebar-header ledge">
            <h5>Expenses Report</h5>
            <a href="#" class="sidebar-closes"><i class="fa-regular fa-circle-xmark"></i></a>
        </div>

        <div class="sidebar-body">
            <form action="{{ route('expenses.profit-loss-expenses') }}" method="GET" autocomplete="off">
                <!-- Name Filter -->
                <div class="form-group">
                    <label for="name">Agent Name</label>
                    <input type="text" name="agent_name" id="name" class="form-control" placeholder="Enter name"
                        value="{{ request('agent_name') }}">
                </div>
                <div class="form-group">
                    <label for="name">Supplyer Name</label>
                    <input type="text" name="supplyer_name" id="name" class="form-control" placeholder="Enter name"
                        value="{{ request('supplyer_name') }}">
                </div>


                <!-- Expenses Filter -->
                <div class="form-group">
                    <label for="expenses">Expenses</label>
                    <input type="text" name="expenses" id="expenses" class="form-control"
                        placeholder="Enter expense title (e.g., hotel, bus)" value="{{ request('expenses') }}">
                </div>

                <!-- Email Filter -->
                <!-- <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email"
                           value="{{ request('email') }}">
                </div> -->

                <!-- Filter Buttons -->
                <div style="margin-top:12px">
                    <button type="submit" class="btn btn-primary">Apply</button>
                    <button type="button" class="btn btn-secondary reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--/Add Asset -->

<!-- Delete Items Modal -->
<div class="modal custom-modal fade" id="delete_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Customer</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <button type="reset" data-bs-dismiss="modal"
                                class="w-100 btn btn-primary paid-continue-btn">Delete</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" data-bs-dismiss="modal"
                                class="w-100 btn btn-primary paid-cancel-btn">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Items Modal -->

</div>
<!-- /Main Wrapper -->

<!--Theme Setting -->
<div class="settings-icon">
    <span data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas"
        aria-controls="theme-settings-offcanvas"><img src="assets/img/icons/siderbar-icon2.svg" class="feather-five"
            alt="layout"></span>
</div>
<div class="offcanvas offcanvas-end border-0 " tabindex="-1" id="theme-settings-offcanvas">
    <div class="sidebar-headerset">
        <div class="sidebar-headersets">
            <h2>Customizer</h2>
            <h3>Customize your overview Page layout</h3>
        </div>
        <div class="sidebar-headerclose">
            <a data-bs-dismiss="offcanvas" aria-label="Close"><img src="assets/img/close.png" alt="img"></a>
        </div>
    </div>
    <div class="offcanvas-body p-0">
        <div data-simplebar class="h-100">
            <div class="settings-mains">
                <div class="layout-head">
                    <h5>Layout</h5>
                    <h6>Choose your layout</h6>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-check card-radio p-0">
                            <input id="customizer-layout01" name="data-layout" type="radio" value="vertical"
                                class="form-check-input">
                            <label class="form-check-label avatar-md w-100" for="customizer-layout01">
                                <img src="assets/img/vertical.png" alt="img">
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Vertical</h5>
                    </div>
                    <div class="col-4">
                        <div class="form-check card-radio p-0">
                            <input id="customizer-layout02" name="data-layout" type="radio" value="horizontal"
                                class="form-check-input">
                            <label class="form-check-label  avatar-md w-100" for="customizer-layout02">
                                <img src="assets/img/horizontal.png" alt="img">
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Horizontal</h5>
                    </div>
                    <div class="col-4 d-none">
                        <div class="form-check card-radio p-0">
                            <input id="customizer-layout03" name="data-layout" type="radio" value="twocolumn"
                                class="form-check-input">
                            <label class="form-check-label  avatar-md w-100" for="customizer-layout03">
                                <img src="assets/img/two-col.png" alt="img">
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Two Column</h5>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3">
                    <div class="layout-head mb-0">
                        <h5>RTL Mode</h5>
                        <h6>Change Language Direction.</h6>
                    </div>
                    <div class="active-switch">
                        <div class="status-toggle">
                            <input id="rtl" class="check" type="checkbox">
                            <label for="rtl" class="checktoggle checkbox-bg">checkbox</label>
                        </div>
                    </div>
                </div>
                <div class="layout-head pt-3">
                    <h5>Color Scheme</h5>
                    <h6>Choose Light or Dark Scheme.</h6>
                </div>
                <div class="colorscheme-cardradio">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check card-radio blue  p-0 ">
                                <input class="form-check-input" type="radio" name="data-layout-mode"
                                    id="layout-mode-blue" value="blue">
                                <label class="form-check-label  avatar-md w-100" for="layout-mode-blue">
                                    <img src="assets/img/vertical.png" alt="img">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2 mb-2">Blue</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio p-0">
                                <input class="form-check-input" type="radio" name="data-layout-mode"
                                    id="layout-mode-light" value="light">
                                <label class="form-check-label  avatar-md w-100" for="layout-mode-light">
                                    <img src="assets/img/vertical.png" alt="img">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2 mb-2">Light</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio dark  p-0 ">
                                <input class="form-check-input" type="radio" name="data-layout-mode"
                                    id="layout-mode-dark" value="dark">
                                <label class="form-check-label avatar-md w-100 " for="layout-mode-dark">
                                    <img src="assets/img/vertical.png" alt="img">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2 mb-2">Dark</h5>
                        </div>
                        <div class="col-4 d-none">
                            <div class="form-check card-radio p-0">
                                <input class="form-check-input" type="radio" name="data-layout-mode"
                                    id="layout-mode-orange" value="orange">
                                <label class="form-check-label  avatar-md w-100 " for="layout-mode-orange">
                                    <img src="assets/img/vertical.png" alt="img">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2 mb-2">Orange</h5>
                        </div>
                        <div class="col-4 d-none">
                            <div class="form-check card-radio maroon p-0">
                                <input class="form-check-input" type="radio" name="data-layout-mode"
                                    id="layout-mode-maroon" value="maroon">
                                <label class="form-check-label  avatar-md w-100 " for="layout-mode-maroon">
                                    <img src="assets/img/vertical.png" alt="img">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2 mb-2">Brink Pink</h5>
                        </div>
                        <div class="col-4 d-none">
                            <div class="form-check card-radio purple p-0">
                                <input class="form-check-input" type="radio" name="data-layout-mode"
                                    id="layout-mode-purple" value="purple">
                                <label class="form-check-label  avatar-md w-100 " for="layout-mode-purple">
                                    <img src="assets/img/vertical.png" alt="img">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2 mb-2">Green</h5>
                        </div>
                    </div>
                </div>

                <div id="layout-width">
                    <div class="layout-head pt-3">
                        <h5>Layout Width</h5>
                        <h6>Choose Fluid or Boxed layout.</h6>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check card-radio p-0">
                                <input class="form-check-input" type="radio" name="data-layout-width"
                                    id="layout-width-fluid" value="fluid">
                                <label class="form-check-label avatar-md w-100" for="layout-width-fluid">
                                    <img src="assets/img/vertical.png" alt="img">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Fluid</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio p-0 ">
                                <input class="form-check-input" type="radio" name="data-layout-width"
                                    id="layout-width-boxed" value="boxed">
                                <label class="form-check-label avatar-md w-100 px-2" for="layout-width-boxed">
                                    <img src="assets/img/boxed.png" alt="img">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Boxed</h5>
                        </div>
                    </div>
                </div>

                <div id="layout-position" class="d-none">
                    <div class="layout-head pt-3">
                        <h5>Layout Position</h5>
                        <h6>Choose Fixed or Scrollable Layout Position.</h6>
                    </div>
                    <div class="btn-group bor-rad-50 overflow-hidden radio" role="group">
                        <input type="radio" class="btn-check" name="data-layout-position" id="layout-position-fixed"
                            value="fixed">
                        <label class="btn btn-light w-sm" for="layout-position-fixed">Fixed</label>

                        <input type="radio" class="btn-check" name="data-layout-position"
                            id="layout-position-scrollable" value="scrollable">
                        <label class="btn btn-light w-sm ms-0" for="layout-position-scrollable">Scrollable</label>
                    </div>
                </div>
                <div class="layout-head pt-3">
                    <h5>Topbar Color</h5>
                    <h6>Choose Light or Dark Topbar Color.</h6>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-check card-radio  p-0">
                            <input class="form-check-input" type="radio" name="data-topbar" id="topbar-color-light"
                                value="light">
                            <label class="form-check-label avatar-md w-100" for="topbar-color-light">
                                <img src="assets/img/vertical.png" alt="img">
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Light</h5>
                    </div>
                    <div class="col-4">
                        <div class="form-check card-radio p-0">
                            <input class="form-check-input" type="radio" name="data-topbar" id="topbar-color-dark"
                                value="dark">
                            <label class="form-check-label  avatar-md w-100" for="topbar-color-dark">
                                <img src="assets/img/dark.png" alt="img">
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">Dark</h5>
                    </div>
                </div>

                <div id="sidebar-size">
                    <div class="layout-head pt-3">
                        <h5>Sidebar Size</h5>
                        <h6>Choose a size of Sidebar.</h6>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio  p-0 ">
                                <input class="form-check-input" type="radio" name="data-sidebar-size"
                                    id="sidebar-size-default" value="lg">
                                <label class="form-check-label avatar-md w-100" for="sidebar-size-default">
                                    <img src="assets/img/vertical.png" alt="img">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Default</h5>
                        </div>

                        <div class="col-4 d-none">
                            <div class="form-check sidebar-setting card-radio p-0">
                                <input class="form-check-input" type="radio" name="data-sidebar-size"
                                    id="sidebar-size-compact" value="md">
                                <label class="form-check-label  avatar-md w-100" for="sidebar-size-compact">
                                    <img src="assets/img/compact.png" alt="img">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Compact</h5>
                        </div>

                        <div class="col-4 ">
                            <div class="form-check sidebar-setting card-radio p-0 ">
                                <input class="form-check-input" type="radio" name="data-sidebar-size"
                                    id="sidebar-size-small-hover" value="sm-hover">
                                <label class="form-check-label avatar-md w-100" for="sidebar-size-small-hover">
                                    <img src="assets/img/small-hover.png" alt="img">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Small Sidebar</h5>
                        </div>
                    </div>
                </div>

                <div id="sidebar-view">
                    <div class="layout-head pt-3">
                        <h5>Sidebar View</h5>
                        <h6>Choose Default or Detached Sidebar view.</h6>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio  p-0">
                                <input class="form-check-input" type="radio" name="data-layout-style"
                                    id="sidebar-view-default" value="default">
                                <label class="form-check-label avatar-md w-100" for="sidebar-view-default">
                                    <img src="assets/img/compact.png" alt="img">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Default</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio p-0">
                                <input class="form-check-input" type="radio" name="data-layout-style"
                                    id="sidebar-view-detached" value="detached">
                                <label class="form-check-label  avatar-md w-100" for="sidebar-view-detached">
                                    <img src="assets/img/detached.png" alt="img">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Detached</h5>
                        </div>
                    </div>
                </div>
                <div id="sidebar-color">
                    <div class="layout-head pt-3">
                        <h5>Sidebar Color</h5>
                        <h6>Choose a color of Sidebar.</h6>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio p-0" data-bs-toggle="collapse"
                                data-bs-target="#collapseBgGradient.show">
                                <input class="form-check-input" type="radio" name="data-sidebar"
                                    id="sidebar-color-light" value="light">
                                <label class="form-check-label  avatar-md w-100" for="sidebar-color-light">
                                    <span class="bg-light bg-sidebarcolor"></span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Light</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio p-0" data-bs-toggle="collapse"
                                data-bs-target="#collapseBgGradient.show">
                                <input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-dark"
                                    value="dark">
                                <label class="form-check-label  avatar-md w-100" for="sidebar-color-dark">
                                    <span class="bg-darks bg-sidebarcolor"></span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Dark</h5>
                        </div>
                        <div class="col-4 d-none">
                            <div class="form-check sidebar-setting card-radio p-0">
                                <input class="form-check-input" type="radio" name="data-sidebar"
                                    id="sidebar-color-gradient" value="gradient">
                                <label class="form-check-label avatar-md w-100" for="sidebar-color-gradient">
                                    <span class="bg-gradients bg-sidebarcolor"></span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Gradient</h5>
                        </div>
                        <div class="col-4 d-none">
                            <button class="btn btn-link avatar-md w-100 p-0 overflow-hidden border collapsed"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient"
                                aria-expanded="false">
                                <span class="d-flex gap-1 h-100">
                                    <span class="flex-shrink-0">
                                        <span class="bg-vertical-gradient d-flex h-100 flex-column gap-1 p-1">
                                            <span class="d-block p-1 px-2 bg-soft-light rounded mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light d-block p-1"></span>
                                            <span class="bg-light d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </button>
                            <h5 class="fs-13 text-center mt-2">Gradient</h5>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="offcanvas-footer border-top p-3 text-center">
        <div class="row">
            <div class="col-6">
                <button type="button" class="btn btn-light w-100 bor-rad-50" id="reset-layout">Reset</button>
            </div>
            <div class="col-6">
                <a href="https://themeforest.net/item/smarthr-bootstrap-admin-panel-template/21153150" target="_blank"
                    class="btn btn-primary w-100 bor-rad-50">Buy Now</a>
            </div>
        </div>
    </div>
</div>
<!-- /Theme Setting -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function() {
    $(document).on('click', '.reset', function() {
        window.location.href = "{{ route('expenses.profit-loss-expenses') }}";
    });
    setTimeout(function() {
        // Trigger the click event using .click()
        $('#filter-btn').click();
    }, 100);


    // function formatDate(date) {
    //     let day = String(date.getDate()).padStart(2, '0'); // Get day and pad with zero
    //     let month = String(date.getMonth() + 1).padStart(2, '0'); // Get month (0-11) and pad with zero
    //     let year = date.getFullYear(); // Get full year
    //     return `${day}-${month}-${year}`; // Return formatted date
    // }

    // // Get the current date
    // var currentDate = new Date();

    // // Set the "To" date to the current date (formatted as DD-MM-YYYY)
    // var toDate = formatDate(currentDate);
    // $('#to_date').val(toDate);

    // // Set the "From" date to one month before the current date
    // var fromDate = new Date(currentDate);
    // fromDate.setMonth(currentDate.getMonth() - 1); // Set to one month earlier
    // fromDate = formatDate(fromDate); // Format the date
    // $('#from_date').val(fromDate);

    $('#reset-btn').on('click', function() {

        // Clear all select inputs
        $('#year').val('');
        $('#month').val('');
        $('#branch').val('');
        $('#package').val('');
        $('#from_date').val('');
        $('#to_date').val('');
        window.location.reload();
        // Reset date inputs to the current and one month before date
        // var currentDate = new Date();
        // var toDate = formatDate(currentDate); // Current date
        // $('#to_date').val(toDate); // Set To date

        // var fromDate = new Date(currentDate);
        // fromDate.setMonth(currentDate.getMonth() - 1); // One month ago
        // $('#from_date').val(formatDate(fromDate)); // Set From date
    });

    // Function to format date as DD-MM-YYYY
    // function formatDate(date) {
    //     let day = String(date.getDate()).padStart(2, '0'); // Get day and pad with zero
    //     let month = String(date.getMonth() + 1).padStart(2, '0'); // Get month (0-11) and pad with zero
    //     let year = date.getFullYear(); // Get full year
    //     return `${day}-${month}-${year}`; // Return formatted date
    // }
    $('#filter-btn').click(function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("profit-loss.index") }}', // Adjust the route if necessary
            method: 'GET',
            data: {
                year: $('#year').val(),
                month: $('#month').val(),
                branch: $('#branch').val(),
                package: $('#package').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
            },
            success: function(response) {
                $('#profit-loss-table').html(response
                    .html); // Replace the table body with the new HTML
            },
            error: function(xhr) {
                console.log(xhr.responseText); // Log any errors
            }
        });
    });
    $('#download-pdf-btn').click(function(e) {
        e.preventDefault();

        // Build the URL with the necessary parameters
        var downloadUrl = '{{ route("profit-loss.downloadPDF") }}' +
            '?year=' + $('#year').val() +
            '&month=' + $('#month').val() +
            '&branch=' + $('#branch').val() +
            '&package=' + $('#package').val() +
            '&from_date=' + $('#from_date').val() +
            '&to_date=' + $('#to_date').val();

        // Redirect to the download URL
        window.location.href = downloadUrl;
    });
    $('#download-csv-btn').click(function(e) {
        e.preventDefault();

        // Build the URL with the necessary parameters
        var downloadUrl = '{{ route("profit-loss.downloadCSV") }}' +
            '?year=' + $('#year').val() +
            '&month=' + $('#month').val() +
            '&branch=' + $('#branch').val() +
            '&package=' + $('#package').val() +
            '&from_date=' + $('#from_date').val() +
            '&to_date=' + $('#to_date').val();

        // Redirect to the download URL
        window.location.href = downloadUrl;
    });

});
</script>

@endsection