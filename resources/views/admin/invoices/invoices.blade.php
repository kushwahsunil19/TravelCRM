@extends('admin.layouts.master')
@section('content')


<!-- Main Wrapper -->
@include('admin.layouts.common-sidebar')
<!-- /Main Wrapper -->
<!-- Page Wrapper -->
@include('admin.invoices.common-topbar')
<!-- /Page Wrapper -->
<!-- Add Asset -->
<div class="toggle-sidebar">
    <div class="sidebar-layout-filter">
        <div class="sidebar-header">
            <h5>Filter</h5>
            <a href="#" class="sidebar-closes"><i class="fa-regular fa-circle-xmark"></i></a>
        </div>
        <div class="sidebar-body">
            <form action="{{ route('invoices.index') }}" method="GET" autocomplete="off">
                
                <div class="form-group">
                    <label for="invoice_no">Invoice No </label>
                    <input type="text" name="invoice_no" id="invoice_no" class="form-control"
                           placeholder="Enter invoice number" value="{{ request('invoice_no') }}">
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

                <!-- Invoice To Filter -->
                <div class="form-group">
                    <label for="invoice_to">Invoice To</label>
                    <input type="text" name="invoice_to" id="invoice_to" class="form-control"
                           placeholder="Enter invoice recipient" value="{{ request('invoice_to') }}">
                </div>

                <!-- Discount Type Filter -->
                <div class="form-group">
                    <label for="discount_type">Discount Type</label>
                    <select name="discount_type" id="discount_type" class="form-control">
                        <option value="" {{ request('discount_type') == '' ? 'selected' : '' }}>Choose Discount Type</option>
                        <option value="Percentage" {{ request('discount_type') == 'Percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="Fixed" {{ request('discount_type') == 'Fixed' ? 'selected' : '' }}>Fixed</option>
                    </select>
                </div>

                <!-- Filter Buttons -->
                <div style="margin-top:12px">
                    <div class="filter-buttons">
                        <!-- Apply Button -->
                        <button type="submit" class="d-inline-flex align-items-center justify-content-center btn w-100 btn-primary">
                            Apply
                        </button>
                        <!-- Reset Button -->
                        <button type="button" class="d-inline-flex align-items-center justify-content-center btn w-100 btn-secondary"
                                onclick="resetForm()">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--/Add Asset -->

<!-- View Modal -->
<div class="modal custom-modal fade" id="view_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content view-delivery-challans">
            <div class="modal-header border-0 pb-0 justify-content-end d-flex align-items-center">
                <div class="file-link mb-0 ">
                    <button class="download_btn download-link">
                        <i class="fa fa-cloud-download me-1" aria-hidden="true"></i> <span>Download</span>
                    </button>
                    <a href="javascript:window.print()" class="print-link">
                        <i class="fa fa-print me-1" aria-hidden="true"></i> <span class="">Print</span>
                    </a>
                </div>
            </div>
            <div class="modal-body invoice-one">
                <div class="invoice-wrapper download_section">
                    <div class="inv-content">
                        <div class="invoice-header p-0">
                            <div class="inv-header-left">
                                <h4>DELIVERY CHALLAN</h4>
                                <h5>Dreamguys Technologies Pvt Ltd</h5>
                                <h6>Mobile 8072687299</h6>
                            </div>
                            <div class="inv-header-right">
                                <h3 class="mb-3">Delivery Challan</h3>
                                <h6 class="mb-1">Invoice # : <span> INV-1</span></h6>
                                <h6 class="mb-1">Invoice Date :<span> 07-10-2023</span></h6>
                                <p>Due Date : <span>07-12-2023</span></p>
                            </div>

                        </div>
                        <span class="line my-4"></span>
                        <div class="patient-infos">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class=" patient-detailed">
                                        <div class="bill-add">
                                            Customer Details :
                                        </div>
                                        <div class="customer-name">
                                            <h4 class="mb-1">Test Customer</h4>
                                            <h4 class="mb-1">Test Company</h4>
                                            <p><span>GSTIN : ACWR000054321</span></p>
                                            <p><span>Phone Number : +91 1234567890</span></p>
                                            <p><span>Email : <a
                                                        href="https://kanakku.dreamstechnologies.com/cdn-cgi/l/email-protection"
                                                        class="__cf_email__"
                                                        data-cfemail="a0c4c5ccc9d6c5e0c5d8c1cdd0ccc58ec3cfcd">[email&#160;protected]</a></span>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class=" patient-detailed">
                                        <div class="bill-add">
                                            Billing Address :
                                        </div>
                                        <div class="add-details">
                                            Walter Roberson <br> 299 Star Trek Drive, Panama City,<br> Florida,
                                            32405,<br> USA
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class=" patient-detailed">
                                        <div class="bill-add">
                                            Shipping Address :
                                        </div>
                                        <div class="add-details">
                                            Walter Roberson <br> 299 Star Trek Drive, Panama City,<br> Florida,
                                            32405,<br> USA
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="reference">
                                <h4>Reference</h4>
                                <p>Keep the Delivery Challan for reference in the future. Now it's simple to create an
                                    invoice, download it</p>
                                <hr>
                            </div>
                        </div>
                        <div class="invoice-table">
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                        <tr class="ecommercetable">
                                            <th class="table_width_1">#</th>
                                            <th>Item</th>
                                            <th class="text-end">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td class="text-start">Accounting Software Maintainence</td>
                                            <td class="text-end">3</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td class="text-start">Man Power Support</td>
                                            <td class="text-end">1</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td class="text-start">Transportation Fee</td>
                                            <td class="text-end">2</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td class="text-start">Spars Replacement Charges</td>
                                            <td class="text-end">5</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td class="text-start">Materials Handling</td>
                                            <td class="text-end">1</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h5 class="text-end">Total Quantity : 12</h5>
                            </div>
                        </div>

                        <div class="authorization text-end">
                            <h6>For YOUR BUSINESS NAME</h6>
                            <img src="assets/img/signature.png" class="my-3" alt="signature-img">
                            <h6>Authorized Signatory</h6>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="terms-condition p-0">
                                    <span>Terms & Conditions:</span>
                                    <ol>
                                        <li>This is a GST based invoice bill, Which is applicable for TDS Deduction</li>
                                        <li>We are not the manufactures, company will stand for warranty as per their
                                            terms and conditions.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center powered">
                        <h6 class="mt-4 mb-3">Powered By</h6>
                        <a href="#">
                            <img class="logo-lightmode" src="assets/img/logo.png" alt="Logo">
                            <img class="logo-darkmode" src="assets/img/logo-white.png" alt="Logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /View Modal -->

<!-- Delete Items Modal -->
<div class="modal custom-modal fade" id="delete_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Invoice</h3>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var filterToggle = document.getElementById('filterToggle');
        var filterSidebar = document.querySelector('.toggle-sidebar');

        // Toggle sidebar visibility when the filter button is clicked
        filterToggle.addEventListener('click', function (event) {
            event.preventDefault();
            filterSidebar.classList.toggle('active');
        });

        // Close sidebar when close button is clicked
        var closeSidebar = document.querySelector('.sidebar-closes');
        closeSidebar.addEventListener('click', function (event) {
            event.preventDefault();
            filterSidebar.classList.remove('active');
        });
    });

    function resetForm() {
        // Clear all the input fields
        document.getElementById('invoice_no').value = '';
        document.getElementById('branch').value = '';
        document.getElementById('package').value = '';
        document.getElementById('invoice_to').value = '';
        document.getElementById('discount_type').value = '';

        // Redirect to reset the filter and go back to the original page
        window.location.href = '{{ route('invoices.index') }}';
    }
</script>
<!-- /Theme Setting -->
@endsection