@extends('admin.layouts.master')
@section('content')


<!-- Main Wrapper -->
@extends('admin.layouts.common-sidebar')
<!-- /Main Wrapper -->
<style>
  
</style>

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="card mb-0">
            <div class="card-body">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="content-page-header">
                        <h5>Add Quotation</h5>
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('quotations.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group-item">
                                <h5 class="form-title">Basic Details</h5>

                                <div class="row">

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label> Branch</label>
                                            <ul class="form-group-plus css-equal-heights">
                                                <li>
                                                    <select class="select" name="branch_id" id="branch_id">
                                                        <option value="">-- Select Branch --</option>
                                                        @foreach ($branches as $branch)
                                                        <option value="{{ $branch->id }}"
                                                            {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                            {{ $branch->city }}
                                                        </option>
                                                        @endforeach
                                                    </select>

                                                </li>
                                                <li>
                                                    <a class="btn btn-primary form-plus-btn"
                                                        href="{{route('branches.create')}}"><i
                                                            class="fas fa-plus-circle"></i></a>
                                                </li>

                                            </ul>
                                            @if ($errors->has('branch_id'))
                                            <span class="text-danger">{{ $errors->first('branch_id') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label> Partner</label>
                                            <ul class="form-group-plus css-equal-heights">
                                                <li>
                                                    <select class="select" name="partner_id" id="partner_id">
                                                        <option value="">-- Select Partner --</option>
                                                        @foreach ($partners as $partner)
                                                        <option value="{{ $partner->id }}"
                                                            {{ old('partner_id') == $partner->id ? 'selected' : '' }}>
                                                            {{ $partner->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </li>
                                                <li>
                                                    <a class="btn btn-primary form-plus-btn"
                                                        href="{{route('partners.create')}}"><i
                                                            class="fas fa-plus-circle"></i></a>
                                                </li>
                                            </ul>
                                            @if ($errors->has('partner_id'))
                                            <span class="text-danger">{{ $errors->first('partner_id') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label> Package</label>
                                            <ul class="form-group-plus css-equal-heights">
                                                <li>
                                                    <select class="select" name="package_id" id="package_id">
                                                        <option value="">-- Select package --</option>
                                                        @foreach ($packages as $package)
                                                        <option value="{{ $package->id }}"
                                                            {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                                            {{ $package->package_name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </li>
                                                <li>
                                                    <a class="btn btn-primary form-plus-btn"
                                                        href="{{route('packages.create')}}"><i
                                                            class="fas fa-plus-circle"></i></a>
                                                </li>
                                            </ul>
                                            @if ($errors->has('package_id'))
                                            <span class="text-danger">{{ $errors->first('package_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>Quotation No</label>
                                            <input type="number" class="form-control" name="quotation_no" placeholder=""
                                                value="{{ $quotation_no}}" readonly>
                                            @if ($errors->has('quotation_no'))
                                            <span class="text-danger">{{ $errors->first('quotation_no') }}</span>
                                            @endif

                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-4 col-md-6 col-sm-12">
													<div class="input-block mb-3">
														<label>Currency</label>
														<select class="select">
															<option>Select Currency</option>
															<option>₹</option>
															<option>$</option>
															<option>£</option>
															<option>€</option>
														</select>
													</div>
												</div> -->
                                    <!-- <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>Twin double sharing cost</label>
                                            <input type="number" class="form-control" name="twin_double_sharing_cost"
                                                placeholder="Enter Twin double sharing cost">
                                            @if ($errors->has('twin_double_sharing_cost'))
                                            <span
                                                class="text-danger">{{ $errors->first('twin_double_sharing_cost') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>Triple sharing cost</label>
                                            <input type="number" class="form-control" name="triple_sharing_cost"
                                                placeholder="Enter Triple sharing cost">
                                            @if ($errors->has('triple_sharing_cost'))
                                            <span class="text-danger">{{ $errors->first('triple_sharing_cost') }}</span>
                                            @endif
                                        </div>
                                    </div> -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>GST Tax</label>
                                            <input type="number" class="form-control gst_tax" name="gst_tax"
                                                placeholder="Enter GST Tax">
                                            @if ($errors->has('gst_tax'))
                                            <span class="text-danger">{{ $errors->first('gst_tax') }}</span>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>Discount Type</label>
                                            <select class="select" name="discount_type">
                                                <option value="Percentage">Percentage(%)</option>
                                                <option value="Fixed">Fixed</option>
                                            </select>
                                            @if ($errors->has('gst_tax'))
                                            <span class="text-danger">{{ $errors->first('gst_tax') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>Discount </label>
                                            <input type="number" class="form-control discount" name="discount"
                                                placeholder="Enter discount">
                                            @if ($errors->has('discount'))
                                            <span class="text-danger">{{ $errors->first('discount') }}</span>
                                            @endif

                                        </div>
                                    </div>

                                </div>
                                <!-- </div>
										<div class="form-group-item">
											<div class="row align-items-end">
												<div class="col-md-6">
													<div class="billing-btn mb-2">
														<h5 class="form-title">Billing Address</h5>
													</div>
													<div class="input-block mb-3">
														<label>Name</label>
														<input type="text" class="form-control" placeholder="Enter Name">
													</div>
													<div class="input-block mb-3">
														<label>Address Line 1</label>
														<input type="text" class="form-control" placeholder="Enter Address 1">
													</div>
													<div class="input-block mb-3">
														<label>Address Line 2</label>
														<input type="text" class="form-control" placeholder="Enter Address 2">
													</div>
													<div class="row">
														<div class="col-lg-6 col-md-12">
															<div class="input-block mb-3">
																<label>Country</label>
																<input type="text" class="form-control" placeholder="Enter Country">
															</div>
															<div class="input-block mb-3">
																<label>City</label>
																<input type="text" class="form-control" placeholder="Enter City">
															</div>
														</div>
														<div class="col-lg-6 col-md-12">
															<div class="input-block mb-3">
																<label>State</label>
																<input type="text" class="form-control" placeholder="Enter State">
															</div>
															<div class="input-block mb-3">
															<label>Pincode</label>
																<input type="text" class="form-control" placeholder="Enter Pincode">
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="billing-btn">
														<h5 class="form-title mb-0">Shipping Address</h5>
														<a href="#" class="btn btn-primary">Copy from Billing</a>
													</div>
													<div class="input-block mb-3">
														<label>Name</label>
														<input type="text" class="form-control" placeholder="Enter Name">
													</div>
													<div class="input-block mb-3">
														<label>Address Line 1</label>
														<input type="text" class="form-control" placeholder="Enter Address 1">
													</div>
													<div class="input-block mb-3">
														<label>Address Line 2</label>
														<input type="text" class="form-control" placeholder="Enter Address 2">
													</div>
													<div class="row">
														<div class="col-lg-6 col-md-12">
															<div class="input-block mb-3">
																<label>Country</label>
																<input type="text" class="form-control" placeholder="Enter Country">
															</div>
															<div class="input-block mb-3">
																<label>City</label>
																<input type="text" class="form-control" placeholder="Enter City">
															</div>
														</div>
														<div class="col-lg-6 col-md-12">
															<div class="input-block mb-3">
																<label>State</label>
																<input type="text" class="form-control" placeholder="Enter State">
															</div>
															<div class="input-block mb-3">
																<label>Pincode</label>
																<input type="text" class="form-control" placeholder="Enter Pincode">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group-customer customer-additional-form">
											<div class="row">
												<h5 class="form-title">Bank Details</h5>
												<div class="col-lg-4 col-md-6 col-sm-12">
													<div class="input-block mb-3">
														<label>Bank Name</label>
														<input type="text" class="form-control" placeholder="Enter Bank Name">
													</div>
												</div>
												<div class="col-lg-4 col-md-6 col-sm-12">
													<div class="input-block mb-3">
														<label>Branch</label>
														<input type="text" class="form-control" placeholder="Enter Branch Name">
													</div>									
												</div>
												<div class="col-lg-4 col-md-12 col-sm-12">
													<div class="input-block mb-3">
														<label>Account Holder Name</label>
														<input type="text" class="form-control" placeholder="Enter Account Holder Name">
													</div>
												</div>
												<div class="col-lg-4 col-md-12 col-sm-12">
													<div class="input-block mb-3">
														<label>Account Number</label>
														<input type="text" class="form-control" placeholder="Enter Account Number">
													</div>
												</div>
												<div class="col-lg-4 col-md-12 col-sm-12">
													<div class="input-block mb-3">
														<label>IFSC</label>
														<input type="text" class="form-control" placeholder="Enter IFSC Code">
													</div>
												</div>
											</div>
										</div>								 -->

                                <div class="form-group-item">
                                    <div class="card-table">
                                        <div class="card-body">
                                            <div class="table-responsive itme_table no-pagination">
                                                <table class="table table-center table-hover datatable">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Package Name</th>
                                                            <th>Discription</th>                                                          
                                                            <th>Amount</th>
                                                            <th class="no-sort">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="packageBody">
                                                        <!-- Rows will be added here by AJAX -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group-item border-0 p-0">
                                        <div class="row">

                                            <div class="col-xl-12 col-lg-12">
                                                <div class="form-group-bank">
                                                    <div class="invoice-total-box">
                                                        <div class="invoice-total-inner">
                                                            <p>Package Amount <span class="amount">$0.00</span></p>
                                                            <input type="hidden" id="package_amt" value="0">
                                                            <p>Discount <span class="discount">$0.00</span></p>
                                                            <input type="hidden" id="discount" value="0">
                                                            <p>Tax <span class="gst_tax">$0.00</span></p>
                                                            <input type="hidden" id="gst_tax" value="0">
                                                            <!-- <div class="status-toggle justify-content-between">
                                                                <div class="d-flex align-center">
                                                                    <p>Round Off </p>
                                                                    <input id="rating_1" class="check" type="checkbox"
                                                                        checked="">
                                                                    <label for="rating_1"
                                                                        class="checktoggle checkbox-bg">checkbox</label>
                                                                </div>
                                                                <span>$0.00</span>
                                                            </div> -->
                                                        </div>
                                                        <div class="invoice-total-footer">
                                                            <h4>Total Amount <span class="total_amt">$00.00</span></h4>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="input-block mb-3">
                                                        <label>Signature Name</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Signature Name">
                                                    </div>
                                                    <div class="input-block mb-0">
                                                        <label>Signature Image</label>
                                                        <div
                                                            class="input-block service-upload service-upload-info mb-0">
                                                            <span><i class="fe fe-upload-cloud me-1"></i>Upload
                                                                Signature</span>
                                                            <input type="file" multiple="" id="image_sign">
                                                            <div id="frames"></div>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-customer-btns text-end">
                                    <a href="{{route('quotations.index')}}" class="btn customer-btn-cancel">Cancel</a>
                                    <button type="submit" class="btn customer-btn-save">Create</button>

                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Page Wrapper -->

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

                        <div class="col-4">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 for Package Select   
    // Handle Package Change Event
$(document).on('change', '#package_id', function() {
    var packageId = $(this).val();

    if (packageId) {
        $.ajax({
            url: '{{ route("packages.details", ":id") }}'.replace(':id', packageId),
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response); // Log the response for debugging

                if (response.success) {
                    // Update package amounts
                    $('.amount').text('$' + response.data.amount);
                    $('#package_amt').val(response.data.amount);
                    $('.total_amt').text('$' + response.data.amount);
                    
                    // Clear the existing table body
                    const tableBody = $('#packageBody');
                     tableBody.empty(); // Clear existing rows

                    // Ensure that the response contains the expected fields
                    const packageData = response.data;
                    const editRoute = '{{ route("packages.edit", ":id") }}'.replace(':id', packageData.id);

                    // Create a new row with package details
                    const newRow = `
                        <tr>
                            <td>${packageData.package_name }</td> <!-- Package Name -->
                            <td  class="description-cell">${packageData.description }</td> <!-- Description -->
                            <td>${packageData.amount }</td> <!-- Amount -->
                           <td class="d-flex align-items-center">
                                <!-- Edit button that calls the 'packages.edit' route -->
                                <a href="${editRoute}" class="btn-action-icon me-2">
                                    <span><i class="fe fe-edit"></i></span>
                                </a>
                            </td>
                        </tr>
                    `;
                
                    // Append the new row to the table body
                    tableBody.append(newRow);

                } else {
                    alert('Package not found');
                    clearPackageFormFields(); // Reset fields if needed
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); // Log error for debugging
                alert('An error occurred while fetching package details.');
                clearPackageFormFields(); // Reset fields if needed
            }
        });
    }
});




    $(document).on('keyup', '.gst_tax', function() {
        var gst_tax = $(this).val();
        $('#gst_tax').val(gst_tax);
        $('.gst_tax').text('$' + gst_tax);

        // Get package amount and GST tax values
        var package_amt = parseFloat($('#package_amt').val()) || 0; // Default to 0 if not a number
        var discout = parseFloat($('#discout').val())
        // Calculate the total amount including GST
        var total_amt = (package_amt + gst_tax);
        // Display the calculated total amount
        $('.total_amt').text('$' + total_amt.toFixed(2)); // 

    });
    $(document).on('keyup', '.discount', function() {
        // Get the current discount value
        var discount = parseFloat($(this).val()) || 0; // Default to 0 if not a number
        $('#discount').val(discount);

        // Update the displayed discount value
        $('.discount').text('$' + discount);

        // Get package amount and GST tax values
        var package_amt = parseFloat($('#package_amt').val()) || 0; // Default to 0 if not a number
        var gst_tax = parseFloat($('#gst_tax').val()) || 0; // Default to 0 if not a number

        // Calculate the discount amount
        var discountAmount = (package_amt * discount) / 100;

        // Calculate the amount after discount
        var amountAfterDiscount = package_amt - discountAmount;

        // Calculate the total amount including GST
        var total_amt = amountAfterDiscount + (amountAfterDiscount + gst_tax) / 100;

        // Display the calculated total amount
        $('.total_amt').text('$' + total_amt.toFixed(2)); // Format to 2 decimal places
    });



});
</script>