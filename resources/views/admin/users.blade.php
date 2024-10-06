@extends('admin.layouts.master')
@section('content')


		<!-- Main Wrapper -->
		@extends('admin.layouts.common-sidebar')
		<!-- /Main Wrapper -->

				<!-- /Sidebar -->
	
			<!-- Page Wrapper -->
			<div class="page-wrapper">
				<div class="content container-fluid">				
					<!-- Page Header -->
					<div class="page-header">
						<div class="content-page-header ">
							<h5>Users</h5>
							<div class="list-btn">
								<ul class="filter-list">
									<!-- <li>
										<a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Filter"><span class="me-2"><img src="public/assets/img/icons/filter-icon.svg" alt="filter"></span>Filter </a>
									</li> -->
									<li>
										<a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_user"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add user</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-sm-12">
							<div class="card-table">
								<div class="card-body">
									<div class="table-responsive">
									<table class="table table-center table-hover datatable" id="users-table">
										<thead class="thead-light">
											<tr>
												<th>#</th>
												<th>User Name</th>
												<th>Email</th>
												<th>Mobile</th>
												<th>Role</th>
												<th>Created On</th>
												<th>Status</th>
												<th class="no-sort">Actions</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>

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
									<a href="javascript:void(0);" class="w-100" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										Customer	
										<span class="float-end"><i class="fa-solid fa-chevron-down"></i></span>
									</a> 
									</h6>
								</div>
							
								<div id="collapseOne" class="collapse show" aria-labelledby="headingOne"  data-bs-parent="#accordionExample1">
									<div class="card-body-chat">
										<div class="row">
											<div class="col-md-12">
												<div id="checkBoxes1">
													<div class="form-custom">														
														<input type="text" class="form-control" id="member_search1" placeholder="Search here">
														<span><img src="public/assets/img/icons/search.svg" alt="img"></span>
													</div>
													<div class="selectBox-cont">
														<label class="custom_check w-100">
															<input type="checkbox" name="username">
															<span class="checkmark"></span>  John Smith
														</label>
														<label class="custom_check w-100">
															<input type="checkbox" name="username">
															<span class="checkmark"></span>  Johnny
														</label>
														<label class="custom_check w-100">
															<input type="checkbox" name="username">
															<span class="checkmark"></span>  Robert
														</label>
														<label class="custom_check w-100">
															<input type="checkbox" name="username">
															<span class="checkmark"></span> Sharonda
														</label>
														<!-- View All -->
														<div class="view-content">
															<div class="viewall-One">	
																<label class="custom_check w-100">
																	<input type="checkbox" name="username">
																	<span class="checkmark"></span> Pricilla
																</label>
																<label class="custom_check w-100">
																	<input type="checkbox" name="username">
																	<span class="checkmark"></span> Randall
																</label>
															</div>
															<div class="view-all">
																<a href="javascript:void(0);" class="viewall-button-One"><span class="me-2">View All</span><span><i class="fa fa-circle-chevron-down"></i></span></a>
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
									<a href="javascript:void(0);" class="w-100 collapsed"  data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
										Select Date	
										<span class="float-end"><i class="fa-solid fa-chevron-down"></i></span>
									</a> 
									</h6>
								</div>
							
								<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"  data-bs-parent="#accordionExample2">
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

							<!-- By Status -->
							<div class="accordion accordion-last" id="accordionMain3">
								<div class="card-header-new" id="headingThree">
									<h6 class="filter-title">
									<a href="javascript:void(0);" class="w-100 collapsed"  data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
										By Status	
										<span class="float-end"><i class="fa-solid fa-chevron-down"></i></span>
									</a> 
									</h6>
								</div>
							
								<div id="collapseThree" class="collapse" aria-labelledby="headingThree"  data-bs-parent="#accordionExample3">
									<div class="card-body-chat">
										<div id="checkBoxes2">
											<div class="form-custom">														
												<input type="text" class="form-control" id="member_search2" placeholder="Search here">
												<span><img src="public/assets/img/icons/search.svg" alt="img"></span>
											</div>
											<div class="selectBox-cont">
												<label class="custom_check w-100">
													<input type="checkbox" name="bystatus">
													<span class="checkmark"></span> Active
												</label>
												<label class="custom_check w-100">
													<input type="checkbox" name="bystatus">
													<span class="checkmark"></span>  Restricted
												</label>
											</div>
										</div>	
									</div>
								</div>
							</div>
							<!-- /By Status -->
							<div class="filter-buttons">
								<button type="submit" class="d-inline-flex align-items-center justify-content-center btn w-100 btn-primary">
									Apply
								</button>
								<button type="submit" class="d-inline-flex align-items-center justify-content-center btn w-100 btn-secondary">
									Reset
								</button>
							</div>
						</form>
						
					</div>
				</div>
			</div>	
			<!--/Add Asset -->

			<!-- Add User -->
			<div class="modal custom-modal modal-lg fade" id="add_user" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Add User</h4>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
								
							</button>
						</div>
						<form id="addUserForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
						@csrf <!-- Include CSRF token for security -->
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12">
										<div class="card-body">
											<div class="form-groups-item">
												<br><br><br><br>
												<div class="profile-picture">
													<div class="upload-profile">

														<label class="avatar avatar-xxl profile-cover-avatar" for="avatar_upload">
															<img class="avatar-img" src="{{ asset('public/assets/img/profiles/default.png') }}" alt="Profile Image" id="blah">
															<input type="file" id="avatar_upload" accept="image/*" name="profile" onchange="previewImage(event)">
															<span class="avatar-edit">
																<i class="fe fe-edit avatar-uploader-icon shadow-soft"></i>
															</span>
														</label>
													</div>                                    
												</div>
												<div class="row">
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="input-block mb-3">
															<label>First Name</label>
															<input type="text" class="form-control" placeholder="Enter First Name" name="first_name" required>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="input-block mb-3">
															<label>Last Name</label>
															<input type="text" class="form-control" placeholder="Enter Last Name" name="last_name" required>
														</div>
													</div>
												
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="input-block mb-3">
															<label>Email</label>
															<input type="email" class="form-control" placeholder="Enter Email Address" name="email" required>
														</div>											
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="input-block mb-3">
															<label>Phone Number</label>
															<input type="text" class="form-control" placeholder="Enter Phone Number" name="mobile" required>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">											 
														<div class="input-block mb-3">
															<label>Role</label>
															<select class="select" name="role" required>
																<option value="">Select Role</option>
																@foreach ($roles as $role)
																	<option value="{{ $role->id }}">{{ $role->name }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">											 
														<div class="input-block ">
															<label>Status</label>
															<select class="select" name="status" required>
																<option value="">Select Status</option>
																<option value="1">Active</option>
																<option value="0">Inactive</option>
															</select>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="pass-group" id="3">
															<div class="input-block">
																<label>Password</label>
																<input type="password" class="form-control pass-input" name="password" required>
															</div>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="pass-group" id="passwordInput2">
															<div class="input-block">
																<label>Confirm Password</label>
																<input type="password" class="form-control pass-input" name="password_confirmation" required>
															</div>
														</div>
													</div>
												
												</div>
											</div>						
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Cancel</button>
								<button type="submit" class="btn btn-primary paid-continue-btn">Add User</button>
							</div>
						</form>

					</div>
				</div>
			</div>
			<!-- /Add User -->

			<!-- Edit User -->
		<!-- Edit User Modal -->
<div class="modal custom-modal modal-lg fade" id="edit_user" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="form-header modal-header-title text-start mb-0">
                    <h4 class="mb-0">Edit User</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
			<form id="editUserForm"  method="POST" enctype="multipart/form-data">
			@csrf
                @method('PUT') <!-- Spoofing PUT for update -->
                <input type="hidden" name="user_id" id="user_id"> <!-- Hidden field for user ID -->

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">
                                <!-- Profile Picture -->
								<div class="profile-picture">
								<img id="blahedit" alt="your image" width="100" height="100" />
								<input type="file"  name="profile" 	onchange="document.getElementById('blahedit').src = window.URL.createObjectURL(this.files[0])">
								</div>

								
                                <!-- Form Fields -->
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" id="edit_first_name" placeholder="Enter First Name" name="first_name" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" id="edit_last_name" placeholder="Enter Last Name" name="last_name" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>Email</label>
                                            <input type="email" class="form-control" id="edit_email" placeholder="Enter Email Address" name="email" required>
                                        </div>											
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-block mb-3">
                                            <label>Phone Number</label>
                                            <input type="text" class="form-control" id="edit_mobile" placeholder="Enter Phone Number" name="mobile" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">											 
                                        <div class="input-block mb-3">
                                            <label>Role</label>
                                            <select class="select" id="edit_role" name="role" required>
                                                <option value="">Select Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
									<div class="col-lg-4 col-md-6 col-sm-12">											 
                                        <div class="input-block">
                                            <label>Status</label>
                                            <select class="select" id="edit_status" name="status" required>
                                                <option value="">Select Status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="pass-group">
                                            <div class="input-block">
                                                <label>Password</label>
                                                <input type="password" class="form-control" id="edit_password" name="password" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="pass-group">
                                            <div class="input-block">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation" >
                                            </div>
                                        </div>
                                    </div>

                                   
                                </div>
                            </div>						
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Cancel</button>
                    <button type="submit" class="btn btn-primary paid-continue-btn">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

			<!-- /Edit User -->

			<!-- Delete Items Modal -->
			<div class="modal custom-modal fade" id="delete_modal" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-body">
							<div class="form-header">
								<h3>Delete Users</h3>
								<p>Are you sure want to delete?</p>
							</div>
							<div class="modal-btn delete-action">
								<div class="row">
									<div class="col-6">
										<a href="#" class="btn btn-primary paid-continue-btn">Delete</a>
									</div>
									<div class="col-6">
										<a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel</a>
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
			<span data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas"><img src="public/assets/img/icons/siderbar-icon2.svg" class="feather-five" alt="layout"></span> 
		</div> 
		<div class="offcanvas offcanvas-end border-0 " tabindex="-1" id="theme-settings-offcanvas"> 
			<div class="sidebar-headerset">
				<div class="sidebar-headersets">
					<h2>Customizer</h2>
					<h3>Customize your overview Page layout</h3>
				</div>
				<div class="sidebar-headerclose">
					<a data-bs-dismiss="offcanvas" aria-label="Close"><img src="public/assets/img/close.png" alt="img"></a>
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
										<img src="public/assets/img/vertical.png" alt="img">
									</label> 
								</div> 
								<h5 class="fs-13 text-center mt-2">Vertical</h5> 
							</div> 
							<div class="col-4"> 
								<div class="form-check card-radio p-0"> 
								<input id="customizer-layout02" name="data-layout" type="radio" value="horizontal" class="form-check-input"> 
									<label class="form-check-label  avatar-md w-100" for="customizer-layout02"> 
										<img src="public/assets/img/horizontal.png" alt="img">
									</label> 
								</div> 
								<h5 class="fs-13 text-center mt-2">Horizontal</h5> 
							</div> 
							<div class="col-4 d-none"> 
								<div class="form-check card-radio p-0"> 
									<input id="customizer-layout03" name="data-layout" type="radio" value="twocolumn" class="form-check-input"> 
									<label class="form-check-label  avatar-md w-100" for="customizer-layout03"> 
										<img src="public/assets/img/two-col.png" alt="img">
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
												<img src="public/assets/img/vertical.png" alt="img">
											</label> 
										</div> 
										<h5 class="fs-13 text-center mt-2 mb-2">Blue</h5> 
									</div>
								<div class="col-4"> 
									<div class="form-check card-radio p-0"> 
										<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-light" value="light"> 
										<label class="form-check-label  avatar-md w-100" for="layout-mode-light"> 
											<img src="public/assets/img/vertical.png" alt="img">
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2 mb-2">Light</h5> 
								</div> 
								<div class="col-4"> 
									<div class="form-check card-radio dark  p-0 "> 
										<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-dark" value="dark"> 
										<label class="form-check-label avatar-md w-100 " for="layout-mode-dark"> 
											<img src="public/assets/img/vertical.png" alt="img">
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2 mb-2">Dark</h5> 
								</div> 
								<div class="col-4 d-none"> 
									<div class="form-check card-radio p-0"> 
										<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-orange" value="orange"> 
										<label class="form-check-label  avatar-md w-100 " for="layout-mode-orange"> 
											<img src="public/assets/img/vertical.png" alt="img">
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2 mb-2">Orange</h5> 
								</div> 
								<div class="col-4 d-none"> 
									<div class="form-check card-radio maroon p-0"> 
										<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-maroon" value="maroon"> 
										<label class="form-check-label  avatar-md w-100 " for="layout-mode-maroon"> 
											<img src="public/assets/img/vertical.png" alt="img">
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2 mb-2">Brink Pink</h5> 
								</div> 
								<div class="col-4 d-none"> 
									<div class="form-check card-radio purple p-0"> 
										<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-purple" value="purple"> 
										<label class="form-check-label  avatar-md w-100 " for="layout-mode-purple"> 
											<img src="public/assets/img/vertical.png" alt="img">
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
											<img src="public/assets/img/vertical.png" alt="img">
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2">Fluid</h5> 
								</div> 
								<div class="col-4"> 
									<div class="form-check card-radio p-0 "> 
										<input class="form-check-input" type="radio" name="data-layout-width" id="layout-width-boxed" value="boxed"> 
										<label class="form-check-label avatar-md w-100 px-2" for="layout-width-boxed"> 
											<img src="public/assets/img/boxed.png" alt="img"> 
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
										<img src="public/assets/img/vertical.png" alt="img">
									</label> 
								</div> 
								<h5 class="fs-13 text-center mt-2">Light</h5> 
							</div> 
							<div class="col-4"> 
								<div class="form-check card-radio p-0"> 
									<input class="form-check-input" type="radio" name="data-topbar" id="topbar-color-dark" value="dark"> 
									<label class="form-check-label  avatar-md w-100" for="topbar-color-dark"> 
										<img src="public/assets/img/dark.png" alt="img">
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
											<img src="public/assets/img/vertical.png" alt="img">
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2">Default</h5> 
								</div> 

								<div class="col-4 d-none"> 
									<div class="form-check sidebar-setting card-radio p-0"> 
										<input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-compact" value="md"> 
										<label class="form-check-label  avatar-md w-100" for="sidebar-size-compact"> 
											<img src="public/assets/img/compact.png" alt="img">
										</label> 
									</div> 
									<h5 class="fs-13 text-center mt-2">Compact</h5> 
								</div> 

								<div class="col-4"> 
									<div class="form-check sidebar-setting card-radio p-0 "> 
										<input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-small-hover" value="sm-hover" > 
										<label class="form-check-label avatar-md w-100" for="sidebar-size-small-hover"> 
											<img src="public/assets/img/small-hover.png" alt="img">
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
											<img src="public/assets/img/compact.png" alt="img">
										</label>
										</div> 
									<h5 class="fs-13 text-center mt-2">Default</h5> 
								</div> 
								<div class="col-4"> 
									<div class="form-check sidebar-setting card-radio p-0"> 
										<input class="form-check-input" type="radio" name="data-layout-style" id="sidebar-view-detached" value="detached"> 
										<label class="form-check-label  avatar-md w-100" for="sidebar-view-detached"> 
											<img src="public/assets/img/detached.png" alt="img">
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
		@endsection
		<!-- Include Toastr CSS -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">


<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function() {
	toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right", // Position of the toast
        "preventDuplicates": false,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000", // Duration for which the toast is shown
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn", // Use fadeIn or slideDown
        "hideMethod": "fadeOut" // Use fadeOut or slideUp
    };
	if ($.fn.DataTable.isDataTable('#users-table')) {
        $('#users-table').DataTable().destroy();
    }
	$('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('users.data') }}',
            type: 'GET'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'first_name', name: 'first_name' },
            { data: 'email', name: 'email' },
            { data: 'mobile', name: 'mobile' },
            { data: 'role', name: 'role', orderable: false, searchable: false }, // Dropdown column
            { data: 'created_at', name: 'created_at' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false } // Action column
        ],
        pageLength: 10 // Limit to 10 records per page
    });

    $('#users-table').on('change', '.role-select', function() {

    var roleId = $(this).val(); // Get the selected role ID
    var userId = $(this).data('user-id'); // Get the user ID from data attribute
    if (roleId) { // Check if a role is selected
        $.ajax({
            url: '{{ route("users.updateRole") }}', // Use named route for better maintainability
            type: 'post',
            data: {
                role_id: roleId,
                user_id: userId,
                _token: '{{ csrf_token() }}' // Include CSRF token
            },
            success: function(response) {
				toastr.success(response.message);
				table.ajax.reload(null, false);
                // Optionally, update the UI to reflect the change
            },
            error: function(xhr) {
                alert('Error assigning role: ' + xhr.responseJSON.message);
            }
        });
    }
});
$('#addUserForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the form from submitting normally

    var formData = new FormData(this); // Create FormData object from the form

    $.ajax({
        url: $(this).attr('action'), // Get the action URL from the form
        type: 'POST',
        data: formData, // Send FormData object
        contentType: false, // Important for file upload
        processData: false, // Important for file upload
        success: function(response) {
            toastr.success(response.message); // Display success message

            // Optionally, reset the form or close the modal
            $('#add_user').modal('hide');
            $('#addUserForm')[0].reset(); // Reset the form
            $('#users-table').DataTable().ajax.reload(null, false); // Reload and stay on the current page
        },
        error: function(xhr) {
            if (xhr.responseJSON.errors) {
                $.each(xhr.responseJSON.errors, function(key, value) {
                    toastr.error(value[0]); // Display each error message
                });
            } else {
                toastr.error('Error uploading profile.'); // Generic error message
            }
        }
    });
});
function previewImage(event) {
        const file = event.target.files[0]; // Get the selected file
        const reader = new FileReader(); // Create a FileReader object

        // Define the onload function for the reader
        reader.onload = function(e) {
            // Set the src of the image to the result of the reader
            document.getElementById('blahedit').src = e.target.result;
        };

        // Read the file as a Data URL
        if (file) {
            reader.readAsDataURL(file); // This will trigger the onload event
        } else {
            // If no file is selected, set to default image
            document.getElementById('blahedit').src = "{{ url('public/assets/img/profiles/default.png') }}"; // Change to your default image URL
        }
    }

$(document).on('click', '.edit-user', function() {
    var userId = $(this).data('id'); // Get user ID from the button

    // Make an AJAX request to fetch the user data
    $.ajax({
        url: '{{ route("users.edit", ":id") }}'.replace(':id', userId), // Replace ':id' with the actual user ID
        type: 'GET',
        success: function(response) {
			var user = response.user;
            // Populate the form fields with the fetched data
            $('#user_id').val(user.id); // Hidden user ID
            $('#edit_first_name').val(user.first_name);
            $('#edit_last_name').val(user.last_name);
            $('#edit_email').val(user.email);
            $('#edit_mobile').val(user.mobile);
            $('#edit_role').val(response.role_id).change(); // Assuming 'role_id' is the field containing the user's role
            $('#edit_status').val(user.status).change(); // Assuming 'status' is 1 or 0

            // Handle profile image
			if (user.profile) {
                // Set the profile image source
                $('#blahedit').attr('src', '{{ url("public/profile") }}/' + user.profile);
            } else {
                // Set to default image if no profile exists
                $('#blahedit').attr('src', '{{ url("public/assets/img/profiles/default.png") }}');
            }

            // Open the modal
            $('#edit_user').modal('show');
        },
        error: function(xhr) {
            toastr.error('Error fetching user data.');
        }
    });
});

$('#editUserForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    var formData = new FormData(this); // FormData for file uploads
    var userId = $('#user_id').val(); // Get user ID from hidden input
    $.ajax({
        url: '{{ route("users.update", ":id") }}'.replace(':id', userId), // Update route
        type: 'POST', // POST method with method override
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-HTTP-Method-Override': 'PUT' // Spoofing PUT
        },
        success: function(response) {
            toastr.success('User updated successfully.');
            $('#edit_user').modal('hide'); // Close modal after success
            $('#users-table').DataTable().ajax.reload(null, false); // Reload and stay on the current page
        },
        error: function(xhr) {
            // Display error messages from the server if any
            let errors = xhr.responseJSON.errors;
            if (errors) {
                $.each(errors, function(key, value) {
                    toastr.error(value[0]);
                });
            } else {
                toastr.error('Error updating user.');
            }
        }
    });
});




$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
$(document).on('click', '.delete-user', function() {
    var userId = $(this).data('id');
    var urlData = "{{ route('users.destroy', ':id') }}".replace(':id', userId);

    // Confirm deletion
    if (confirm("Are you sure you want to delete this user?")) {
		$.ajax({
			url: urlData,
			type: 'DELETE',
			success: function(response) {
				toastr.success(response.success); // Adjusted to match your response
				$('#users-table').DataTable().ajax.reload();
			},
			error: function(xhr) {
				toastr.error(xhr.responseJSON.message); // Display error message
			}
		});
    }
});
});
</script>
