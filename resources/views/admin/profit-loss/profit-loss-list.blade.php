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
                <h5>Profit & Loss</h5>
                <div class="page-content">
                    <div class="list-btn">
                        <ul class="filter-list">
                            <!-- <li>
										<a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip"
											data-bs-placement="bottom" title="Filter"><span class="me-2"><img
													src="assets/img/icons/filter-icon.svg" alt="filter"></span>Filter
										</a>
									</li>
									<li>
										<div class="dropdown dropdown-action" data-bs-toggle="tooltip"
											data-bs-placement="bottom" title="Download">
											<a href="#" class="btn-filters" data-bs-toggle="dropdown"
												aria-expanded="false"><span><i class="fe fe-download"></i></span></a>
											<div class="dropdown-menu dropdown-menu-end">
												<ul class="d-block">
													<li>
														<a class="d-flex align-items-center download-item"
															href="javascript:void(0);" download><i
																class="far fa-file-pdf me-2"></i>PDF</a>
													</li>
													<li>
														<a class="d-flex align-items-center download-item"
															href="javascript:void(0);" download><i
																class="far fa-file-text me-2"></i>CVS</a>
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
            <div class="row">
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div class="input-block mb-3">
                        <label>Period</label>
                        <ul class="form-group">
                            <li>
                                <select class="select ">
                                    <option>This Year</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div class="input-block mb-3">
                        <label>From</label>
                        <div class="cal-icon cal-icon-info">
                            <input type="text" class="datetimepicker form-control" placeholder="01 Jan 2023">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div class="input-block mb-3">
                        <label>To</label>
                        <div class="cal-icon cal-icon-info">
                            <input type="text" class="datetimepicker form-control" placeholder="31 Mar 2023">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 ">
                    <div class="input-block mb-3">
                        <label>Display Columns by</label>
                        <ul class="form-group">
                            <li>
                                <select class="select ">
                                    <option>Month</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div class="input-block mb-3">
                        <label>Accounting Method</label>
                        <ul class="form-group">
                            <li>
                                <select class="select ">
                                    <option>Accrual</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <a class="btn btn-primary loss" href="#">
                        Run</a>
                </div>
            </div>
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
                                <table class="table table-center ">
                                    <thead class="thead-light loss">
                                        <tr>
                                        
											<th>Branch</th>
											<th>Package</th>
                                            <th>Month</th>
                                            <th>Year</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td class="profit space" colspan="5">
                                            <table class="table table-center profit">
                                                <thead class="profitloss-heading">
                                                    <tr>
                                                        <th class="table-profit-head" colspan="5">Income</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													@php  $total_invoice_amt = 0; @endphp
                                                    @forelse ($invoices as $invoice)

                                                    @php
													$symbol = isset($invoice->currency->symbol) ? $invoice->currency->symbol : '₹';
                                                    $package_amt = $invoice->package->amount;
                                                    // GST Tax in percentage
                                                    $tax = $invoice->vat;
                                                    // Discount in percentage
                                                    $discount = $invoice->discount;

                                                    if($invoice->discount_type=='Fixed'){
                                                    $discount_amt = $discount;
                                                    }else{
                                                    $discount_amt = ($package_amt * $discount) / 100;
                                                    }
                                                    // Amount after discount
                                                    $amount_after_discount = $package_amt - $discount_amt;
                                                    $tax_amt = ($amount_after_discount * $tax) / 100;
                                                    $total_amt = $amount_after_discount + $tax_amt;
													$total_invoice_amt += $total_amt;
                                                    @endphp
                                                    <tr class="proft-head">
                                                        <td>{{ isset($invoice->branch->branch_name)?$invoice->branch->branch_name:'' }}</td>
                                                        <td>{{ isset($invoice->package->package_name)?$invoice->package->package_name:'' }}</td>
                                                        <td>March</td>
                                                        <td>2024</td>
                                                        <td>{{ isset($invoice->currency->symbol) ? $invoice->currency->symbol : '₹' }}{{ $total_amt }}</td>
                                                    </tr>
													@empty
                                    <tr>
                                        <td colspan="9" class="text-center">No invoices found.</td>
                                    </tr>
                                    @endforelse
                                                </tbody>

                                                <tr class="profitloss-bg">
                                                    <td>
                                                        <h6>Total Income</h6>
                                                    </td>
                                                    <td>
                                                        
                                                    </td>
                                                    <td>
                                                      
                                                    </td>
                                                    <td>
                                                      
                                                    </td>
                                                    <td>
                                                        {{$symbol}}{{ $total_amt }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="loss-space" colspan="5">
                                            <table class="table table-center profit">
                                                <thead class="profitloss-heading">
                                                    <tr>
                                                        <th class="table-profit-head" colspan="5">Expenses</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Exchange Gain or Losses</td>
                                                        <td>$0.00</td>
                                                        <td>$0.00</td>
                                                        <td>$0.00</td>
                                                        <td>$0.00</td>
                                                    </tr>
                                                    <tr class="proft-head">
                                                        <td>Stripe Fees</td>
                                                        <td>$2,81,687.00</td>
                                                        <td>$3,73,518.00</td>
                                                        <td>$2,17,936.00</td>
                                                        <td>$8,73,141.00</td>
                                                    </tr>
                                                </tbody>

                                                <tr class="profitloss-bg">
                                                    <td>
                                                        <h6>Total Expense</h6>
                                                    </td>
                                                    <td>
                                                        <h6>$2,58,136.00</h6>
                                                    </td>
                                                    <td>
                                                        <h6>$1,38,471.00</h6>
                                                    </td>
                                                    <td>
                                                        <h6>$2,61,682.00</h6>
                                                    </td>
                                                    <td>
                                                        <h6>$6,58,289.00</h6>
                                                    </td>
                                                </tr>
                                                <tr class="profitloss-bg">
                                                    <td>
                                                        <h6>Net Income</h6>
                                                    </td>
                                                    <td>
                                                        <h6>$2,69,276.00</h6>
                                                    </td>
                                                    <td>
                                                        <h6>$2,75,638.00</h6>
                                                    </td>
                                                    <td>
                                                        <h6>$2,51,629.00</h6>
                                                    </td>
                                                    <td>
                                                        <h6>$7,96,543.00</h6>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
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
<div class="toggle-sidebar">
    <div class="sidebar-layout-filter">
        <div class="sidebar-header">
            <h5>Filter</h5>
            <a href="#" class="sidebar-closes"><i class="fa-regular fa-circle-xmark"></i></a>
        </div>
        <div class="sidebar-body">
            <form action="#" autocomplete="off">
                <!-- Customer -->
                <div class="accordion" id="accordionMain1">
                    <div class="card-header-new" id="headingOne">
                        <h6 class="filter-title">
                            <a href="javascript:void(0);" class="w-100" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Customer
                                <span class="float-end"><i class="fa-solid fa-chevron-down"></i></span>
                            </a>
                        </h6>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample1">
                        <div class="card-body-chat">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="checkBoxes1">
                                        <div class="form-custom">
                                            <input type="text" class="form-control" id="member_search1"
                                                placeholder="Search here">
                                            <span><img src="assets/img/icons/search.svg" alt="img"></span>
                                        </div>
                                        <div class="selectBox-cont">
                                            <label class="custom_check w-100">
                                                <input type="checkbox" name="username">
                                                <span class="checkmark"></span> Michael
                                            </label>
                                            <label class="custom_check w-100">
                                                <input type="checkbox" name="username">
                                                <span class="checkmark"></span> Richard
                                            </label>
                                            <label class="custom_check w-100">
                                                <input type="checkbox" name="username">
                                                <span class="checkmark"></span> Joseph
                                            </label>
                                            <label class="custom_check w-100">
                                                <input type="checkbox" name="username">
                                                <span class="checkmark"></span> David
                                            </label>
                                            <!-- View All -->
                                            <div class="view-content">
                                                <div class="viewall-One">
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="username">
                                                        <span class="checkmark"></span> Benjamin
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="username">
                                                        <span class="checkmark"></span> Steven
                                                    </label>
                                                </div>
                                                <div class="view-all">
                                                    <a href="javascript:void(0);" class="viewall-button-One"><span
                                                            class="me-2">View
                                                            All</span><span><i
                                                                class="fa fa-circle-chevron-down"></i></span></a>
                                                </div>
                                            </div>
                                            <!-- /View All -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Customer -->

                <!-- Select Date -->
                <div class="accordion" id="accordionMain2">
                    <div class="card-header-new" id="headingTwo">
                        <h6 class="filter-title">
                            <a href="javascript:void(0);" class="w-100 collapsed" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                Select Date
                                <span class="float-end"><i class="fa-solid fa-chevron-down"></i></span>
                            </a>
                        </h6>
                    </div>

                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample2">
                        <div class="card-body-chat">
                            <div class="input-block mb-3">
                                <label class="form-control-label">From</label>
                                <div class="cal-icon">
                                    <input type="email" class="form-control datetimepicker" placeholder="DD-MM-YYYY">
                                </div>
                            </div>
                            <div class="input-block mb-3">
                                <label class="form-control-label">To</label>
                                <div class="cal-icon">
                                    <input type="email" class="form-control datetimepicker" placeholder="DD-MM-YYYY">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Select Date -->

                <button type="submit"
                    class="d-inline-flex align-items-center justify-content-center btn w-100 btn-primary">
                    <span><img src="assets/img/icons/chart.svg" class="me-2" alt="Generate report"></span>Generate
                    report
                </button>
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
@endsection