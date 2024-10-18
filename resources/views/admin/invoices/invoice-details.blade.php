@extends('admin.layouts.master')
@section('content')

		<!-- Main Wrapper -->
		@include('admin.layouts.common-sidebar')
		<!-- /Main Wrapper -->

			<!-- Page Wrapper -->
			<div class="page-wrapper ">
				<div class="content container-fluid">
					<!-- Page Header -->
					<div class="card">
						<div class="card-body">
							<div class="page-header">
								<div class="content-invoice-header">
									<h5>Invoice Details</h5>
									<div class="list-btn">
									</div>
								</div>
							</div>
							<!-- /Page Header -->
							<div class="row justify-content-center">
								<div class="col-lg-12">
									<div class="invoice-card">
										<div class="card-bod">
											<div class="card-table">
												<div class="card-bod">
													<!-- Invoice Logo -->
													<div class="invoice-item invoice-item-one">
														<div class="row align-items-center">
															<div class="col-md-6">
																<div class="invoice-logo">
																	<img class="light-color-logo" src="assets/img/logo.png" alt="logo">
																	<img src="assets/img/logo-full-white.png" class="dark-white-logo" alt="logo">
																</div>
															</div>
															<div class="col-md-6">
																<div class="invoice-info">
																	<h1 class="text-warning">UNPAID</h1>
																</div>
															</div>
														</div>
													</div>
													<!-- /Invoice Logo -->
				
													<!-- Invoice Date -->
													<div class="invoice-item invoice-item-date">
														<div class="row">
															<div class="col-md-4">
																<p class="text-start invoice-details">
																	Issue Date<span>: </span><strong>13 Apr 2023</strong> 
																</p>
															</div>
															<div class="col-md-4">
																<p class="text-start invoice-details">
																	Due Date<span>: </span><strong>03 Jun 2023</strong><span class="text-danger">Due in 8 days</span>
																</p>
															</div>
															<div class="col-md-4">
																<p class="invoice-details">
																	Invoice No<span>: </span><strong>INV 00001</strong> 
																</p>
															</div>
														</div>
													</div>
													<!-- /Invoice Date -->
													
													<!-- Invoice To -->
													<div class="invoice-item invoice-item-two">
														<div class="row">
															<div class="col-md-4">
																<div class="invoice-info mb-3">
																	<strong class="customer-text-one">Invoiced To<span>:</span></strong>
																	<p class="invoice-details-two">
																		John Williams<br>
																		15 Hodges Mews, High Wycombe<br>
																		HP12 3JL<br>
																		United Kingdom
																	</p>
																</div>
															</div>
															<div class="col-md-4">
																<div class="invoice-info invoice-info2 mb-3">
																	<strong class="customer-text-one">Pay To<span>:</span></strong>
																	<p class="invoice-details-two">
																		Walter Roberson<br>
																		299 Star Trek Drive, Panama City,<br>
																		Florida, 32405,<br>
																		USA
																	</p>
																</div>
															</div>
															<div class="col-md-4">
																<div class="invoice-info invoice-info2 mb-3">
																	<strong class="customer-text-one">Payment Details<span>:</span></strong>
																	<p class="text-start invoice-details-two invoice-details mb-1">
																		PayPal<span>: </span><strong>examplepaypal.co</strong>
																	</p>
																	<p class="text-start invoice-details-two invoice-details mb-1">
																		Account<span>: </span><strong>examplepaypal.co</strong>
																	</p>
																	<p class="text-start invoice-details-t invoice-details">
																		Payment Term<span>: </span><strong>15 days</strong><span class="text-danger">Due in 8 days</span>
																	</p>
																	<div class="pay-btn">
																		<a href="javascript:void(0);" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#paynow_modal">Pay Now</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!-- /Invoice To -->
				
													<!-- Invoice Item -->
													<div class="invoice-item invoice-table-wrap">
														<div class="invoice-table-head">
															<h6>Items:</h6>
														</div>
														<div class="row">
															<div class="col-md-12">
																<div class="table-responsive">
																	<table class="table table-center table-hover mb-0">
																		<thead class="thead-light">
																			<tr>
																				<th>Product / Service</th>
																				<th>Quantity</th>
																				<th>Unit</th>
																				<th>Rate</th>
																				<th>Discount</th>
																				<th>Tax</th>
																				<th>Amount</th>
																			</tr>
																		</thead>
																		<tbody>
																			<tr>
																				<td>Nike Jordan</td>
																				<td>1</td>
																				<td>Pcs</td>
																				<td>$1360.00</td>
																				<td>0</td>
																				<td>0</td>
																				<td>$1360.00</td>
																			</tr>
																			<tr>
																				<td>Lobar Handy</td>
																				<td>1</td>
																				<td>Inch</td>
																				<td>$155.00</td>
																				<td>0</td>
																				<td>0</td>
																				<td>$155.00</td>
																			</tr>
																			<tr>
																				<td>Bold V3.2</td>
																				<td>1</td>
																				<td>Pcs</td>
																				<td>$1055.00</td>
																				<td>0</td>
																				<td>0</td>
																				<td>$1055.00</td>
																			</tr>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
													<!-- /Invoice Item -->
				
													<!-- Terms & Conditions -->
													<div class="terms-conditions">
														<div class="row align-items-center justify-content-between">
															<div class="col-lg-6 col-md-6">
																<div class="invoice-terms align-center">
																	<span class="invoice-terms-icon bg-white-smoke me-3">
																		<i class="fe fe-file-text"></i>
																	</span>
																	<div class="invocie-note">
																		<h6>Terms & Conditions</h6>
																		<p class="mb-0">Authoritatively envisioneer business action items through parallel sources.</p>
																	</div>
																</div>
																<div class="invoice-terms align-center">
																	<span class="invoice-terms-icon bg-white-smoke me-3">
																		<i class="fe fe-file-minus"></i>
																	</span>
																	<div class="invocie-note">
																		<h6>Note</h6>
																		<p class="mb-0">This is computer generated receipt and does not require physical signature.</p>
																	</div>
																</div>
															</div>
															<div class="col-lg-5 col-md-6">
																<div class="invoice-total-card">
																	<div class="invoice-total-box">
																		<div class="invoice-total-inner">
																			<p>Taxable <span>$360.00</span></p>
																			<p>Discount<span>$13.20</span></p>
																			<p>Vat <span>$0.00</span></p>
																		</div>
																		<div class="invoice-total-footer">
																			<h4>Total Amount <span>$347.80</span></h4>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="invoice-sign text-end">										
														<span class="d-block">Authorised Sign</span>
														<img class="img-fluid d-inline-block light-color-logo" src="assets/img/signature.png" alt="sign">
														<img class="img-fluid d-inline-block dark-white-logo" src="assets/img/signature-white.png" alt="sign">
													</div>
													<!-- /Terms & Conditions -->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Page Wrapper -->

			<!-- Pay Now Modal -->
			<div class="modal custom-modal fade pay-modal" id="paynow_modal" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-lg">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="modal-title">Invoice <span>#INV 00001</span></h4>
								<h5><span>Due Date : </span> 03 Jun 2023</h5>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
								
							</button>
						</div>
						<form action="#">
							<div class="modal-body ">
								<div class="row">
									<div class="payment-heading">
										<h5>Select a Payment Method</h5>
									</div>
									<div class="input-block mb-3 paynow-tab">
										<ul class="nav nav-pills d-flex row" id="pills-tab" role="tablist">
											<li class="nav-item col-sm-4" role="presentation">
											  <button class="nav-link active cash" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Cash<i class="fe fe-dollar-sign"></i></button>
											</li>
											<li class="nav-item col-sm-4" role="presentation">
											  <button class="nav-link cheque" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Cheque<i class="fe fe-file-text"></i></button>
											</li>
											<li class="nav-item col-sm-4" role="presentation">
												<button class="nav-link cheque"  data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">CreditCard<i class="fe fe-file-text"></i></button>
											</li>
										</ul>	
									</div>	
									<div class="tab-content pt-0" id="pills-tabContent">
										<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
											<div class="input-block mb-3">
												<label>Amount <span class="text-danger"> *</span></label>
												<input type="text" class="form-control" placeholder="Enter Amount">	
											</div>
										</div>
										<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
											<div class="input-block mb-3">
												<label>Amount <span class="text-danger"> *</span></label>
												<input type="text" class="form-control" placeholder="Enter Amount">	
											</div>
											<div class="input-block mb-3">
												<label>Cheque Number <span class="text-danger"> *</span></label>
												<input type="text" class="form-control" placeholder="Enter Cheque Number">	
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Cancel</button>
								<button type="submit" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">pay Now</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /Pay Now Modal -->
			
		</div>
		<!-- /Main Wrapper -->

			<!--Theme Setting -->
		<div class="settings-icon"> 
			<span data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas"><img src="assets/img/icons/siderbar-icon2.svg" class="feather-five" alt="layout"></span> 
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
									<input id="customizer-layout01" name="data-layout" type="radio" value="vertical" class="form-check-input"> 
									<label class="form-check-label avatar-md w-100" for="customizer-layout01"> 
										<img src="assets/img/vertical.png" alt="img">
									</label> 
								</div> 
								<h5 class="fs-13 text-center mt-2">Vertical</h5> 
							</div> 
							<div class="col-4"> 
								<div class="form-check card-radio p-0"> 
								<input id="customizer-layout02" name="data-layout" type="radio" value="horizontal" class="form-check-input"> 
									<label class="form-check-label  avatar-md w-100" for="customizer-layout02"> 
										<img src="assets/img/horizontal.png" alt="img">
									</label> 
								</div> 
								<h5 class="fs-13 text-center mt-2">Horizontal</h5> 
							</div> 
							<div class="col-4 d-none"> 
								<div class="form-check card-radio p-0"> 
									<input id="customizer-layout03" name="data-layout" type="radio" value="twocolumn" class="form-check-input"> 
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
											<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-blue" value="blue"> 
											<label class="form-check-label  avatar-md w-100" for="layout-mode-blue"> 
												<img src="assets/img/vertical.png" alt="img">
											</label> 
										</div> 
										<h5 class="fs-13 text-center mt-2 mb-2">Blue</h5> 
									</div>
								<div class="col-4"> 
									<div class="form-check card-radio p-0"> 
										<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-light" value="light"> 
										<label class="form-check-label  avatar-md w-100" for="layout-mode-light"> 
											<img src="assets/img/vertical.png" alt="img">
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2 mb-2">Light</h5> 
								</div> 
								<div class="col-4"> 
									<div class="form-check card-radio dark  p-0 "> 
										<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-dark" value="dark"> 
										<label class="form-check-label avatar-md w-100 " for="layout-mode-dark"> 
											<img src="assets/img/vertical.png" alt="img">
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2 mb-2">Dark</h5> 
								</div> 
								<div class="col-4 d-none"> 
									<div class="form-check card-radio p-0"> 
										<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-orange" value="orange"> 
										<label class="form-check-label  avatar-md w-100 " for="layout-mode-orange"> 
											<img src="assets/img/vertical.png" alt="img">
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2 mb-2">Orange</h5> 
								</div> 
								<div class="col-4 d-none"> 
									<div class="form-check card-radio maroon p-0"> 
										<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-maroon" value="maroon"> 
										<label class="form-check-label  avatar-md w-100 " for="layout-mode-maroon"> 
											<img src="assets/img/vertical.png" alt="img">
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2 mb-2">Brink Pink</h5> 
								</div> 
								<div class="col-4 d-none"> 
									<div class="form-check card-radio purple p-0"> 
										<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-purple" value="purple"> 
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
										<input class="form-check-input" type="radio" name="data-layout-width" id="layout-width-fluid" value="fluid"> 
										<label class="form-check-label avatar-md w-100" for="layout-width-fluid"> 
											<img src="assets/img/vertical.png" alt="img">
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2">Fluid</h5> 
								</div> 
								<div class="col-4"> 
									<div class="form-check card-radio p-0 "> 
										<input class="form-check-input" type="radio" name="data-layout-width" id="layout-width-boxed" value="boxed"> 
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
								<input type="radio" class="btn-check" name="data-layout-position" id="layout-position-fixed" value="fixed"> 
								<label class="btn btn-light w-sm" for="layout-position-fixed">Fixed</label> 

								<input type="radio" class="btn-check" name="data-layout-position" id="layout-position-scrollable" value="scrollable"> 
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
									<input class="form-check-input" type="radio" name="data-topbar" id="topbar-color-light" value="light"> 
									<label class="form-check-label avatar-md w-100" for="topbar-color-light"> 
										<img src="assets/img/vertical.png" alt="img">
									</label> 
								</div> 
								<h5 class="fs-13 text-center mt-2">Light</h5> 
							</div> 
							<div class="col-4"> 
								<div class="form-check card-radio p-0"> 
									<input class="form-check-input" type="radio" name="data-topbar" id="topbar-color-dark" value="dark"> 
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
										<input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-default" value="lg" > 
										<label class="form-check-label avatar-md w-100" for="sidebar-size-default"> 
											<img src="assets/img/vertical.png" alt="img">
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2">Default</h5> 
								</div> 

								<div class="col-4 d-none"> 
									<div class="form-check sidebar-setting card-radio p-0"> 
										<input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-compact" value="md"> 
										<label class="form-check-label  avatar-md w-100" for="sidebar-size-compact"> 
											<img src="assets/img/compact.png" alt="img">
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2">Compact</h5> 
								</div> 

								<div class="col-4"> 
									<div class="form-check sidebar-setting card-radio p-0 "> 
										<input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-small-hover" value="sm-hover" > 
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
										<input class="form-check-input" type="radio" name="data-layout-style" id="sidebar-view-default" value="default"> 
										<label class="form-check-label avatar-md w-100" for="sidebar-view-default"> 
											<img src="assets/img/compact.png" alt="img">
										</label>
										</div> 
									<h5 class="fs-13 text-center mt-2">Default</h5> 
								</div> 
								<div class="col-4"> 
									<div class="form-check sidebar-setting card-radio p-0"> 
										<input class="form-check-input" type="radio" name="data-layout-style" id="sidebar-view-detached" value="detached"> 
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
									<div class="form-check sidebar-setting card-radio p-0" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient.show"> 
										<input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-light" value="light"> 
										<label class="form-check-label  avatar-md w-100" for="sidebar-color-light"> 
											<span class="bg-light bg-sidebarcolor"></span>
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2">Light</h5> 
								</div> 
								<div class="col-4"> 
									<div class="form-check sidebar-setting card-radio p-0" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient.show"> 
										<input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-dark" value="dark"> 
										<label class="form-check-label  avatar-md w-100" for="sidebar-color-dark"> 
											<span class="bg-darks bg-sidebarcolor"></span>
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2">Dark</h5> 
								</div> 
								<div class="col-4 d-none"> 
									<div class="form-check sidebar-setting card-radio p-0"> 
										<input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-gradient" value="gradient"> 
										<label class="form-check-label avatar-md w-100" for="sidebar-color-gradient"> 
											<span class="bg-gradients bg-sidebarcolor"></span>
										</label>  
									</div> 
									<h5 class="fs-13 text-center mt-2">Gradient</h5> 
								</div>
								<div class="col-4 d-none"> 
									<button class="btn btn-link avatar-md w-100 p-0 overflow-hidden border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient" aria-expanded="false"> 
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
						<a href="https://themeforest.net/item/smarthr-bootstrap-admin-panel-template/21153150" target="_blank" class="btn btn-primary w-100 bor-rad-50">Buy Now</a> 
					</div> 
				</div> 
			</div> 
		</div>
		<!-- /Theme Setting -->		
	@endsection