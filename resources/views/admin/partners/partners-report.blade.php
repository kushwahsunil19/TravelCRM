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
                <h5>Partners Report</h5>
                <div class="list-btn">
                    <ul class="filter-list">
                     <li>
										<a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip"
											data-bs-placement="bottom" title="Filter"><span class="me-2"><img src="{{url('public/assets/img/icons/filter-icon.svg')}}" alt="filter"></span>Filter </a>
									</li>
								   	<li>
										<div class="dropdown dropdown-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Download">
											<a href="#" class="btn-filters" data-bs-toggle="dropdown" aria-expanded="false"><span><i class="fe fe-download"></i></span></a>
											<div class="dropdown-menu dropdown-menu-end">
												<ul class="d-block">
													<li>
														<a class="d-flex align-items-center download-item" href="{{route('partners.partners-report.downloadPDF')}}" download><i class="far fa-file-pdf me-2"></i>PDF</a>
													</li>
													<li>
														<a class="d-flex align-items-center download-item" href="{{route('partners.partners-report.downloadCSV')}}" download><i class="far fa-file-text me-2"></i>CVS</a>
													</li>
												</ul>
											</div>
										</div>														
									</li>
								 <!--	<li>
										<a class="btn-filters" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Print"><span><i class="fe fe-printer"></i></span> </a>
									</li>
									<li>
										<a class="btn btn-import" href="javascript:void(0);"><span><i class="fe fe-check-square me-2"></i>Import Customer</span></a>
									</li> -->
                        
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
  

        <!-- /Search Filter -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-center table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>

                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($partners as $partner)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td> <!-- Serial number -->
                                        <td>
                                            <h2 class="table-avatar">
                                                @php
                                                $avatar = $partner->image ? url('public/profile/' . $partner->image) :
                                                url('public/assets/img/profiles/default.png');
                                                @endphp
                                                <a href="" class="avatar avatar-md me-2"><img
                                                        class="avatar-img rounded-circle" src="{{$avatar}}"
                                                        alt="User Image"></a>
                                                <a href="">{{ $partner->name }} <span><span class="__cf_email__"
                                                            data-cfemail="c5b5b7aca6aca9a9a485a0bda4a8b5a9a0eba6aaa8">[{{ $partner->email }}]</span></span></a>

                                        <td>{{ $partner->mobile }}</td>

                                        <td>{{ $partner->city }}</td>
                                        <td>{{ $partner->state }}</td>
                                        <td>{{ $partner->country }}</td>

                                        <td>

                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item edit_partner"
                                                                data-id="{{$partner->id}}"><i
                                                                    class="far fa-edit me-2"></i>Edit</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete_modal{{$partner->id}}"><i
                                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                                        </li>
                                                        <!-- <li>
																		<a class="dropdown-item" href="{{ route('partners.show', $partner->id) }}"><i class="far fa-eye me-2"></i>View</a>
																	</li> -->
                                                        <!-- <li>
																		<a class="dropdown-item" href="active-customers.html"><i class="fa-solid fa-power-off me-2"></i>Activate</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="deactive-customers.html"><i class="far fa-bell-slash me-2"></i>Deactivate</a>
																	</li> -->
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- Delete Items Modal -->
                                            <div class="modal custom-modal fade" id="delete_modal{{$partner->id}}"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="form-header">
                                                                <h3>Delete Partner</h3>
                                                                <p>Are you sure want to delete?</p>
                                                            </div>
                                                            <div class="modal-btn delete-action">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <form
                                                                            action="{{ route('partners.destroy', $partner->id) }}"
                                                                            method="POST" style="display:inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                data-bs-dismiss="modal"
                                                                                class="w-100 btn btn-danger paid-continue-btn">Delete</button>

                                                                        </form>

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
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No partners found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
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
            <form action="{{ route('partners.partners-report') }}" method="GET" autocomplete="off">
                <!-- Name Filter -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                           placeholder="Enter name" value="{{ request('name') }}">
                </div>

                <!-- Email Filter -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control"
                           placeholder="Enter email" value="{{ request('email') }}">
                </div>

                <!-- Phone Filter -->
                <div class="form-group">
                    <label for="mobile">Phone</label>
                    <input type="text" name="mobile" id="mobile" class="form-control"
                           placeholder="Enter phone number" value="{{ request('mobile') }}">
                </div>

                <!-- City Filter -->
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" class="form-control"
                           placeholder="Enter city" value="{{ request('city') }}">
                </div>

                <!-- State Filter -->
                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" name="state" id="state" class="form-control"
                           placeholder="Enter state" value="{{ request('state') }}">
                </div>

                <!-- Country Filter -->
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" name="country" id="country" class="form-control"
                           placeholder="Enter country" value="{{ request('country') }}">
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



</div>
<!-- /Main Wrapper -->
<!-- Add Partner Details Modal -->
<div class="modal custom-modal modal-lg fade" id="partner_details" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="form-header modal-header-title text-start mb-0">
                    <h4 class="mb-0">Add Partner Details</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="partner_details_form" action="{{ route('partners.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- Include CSRF token for security -->
                    <div class="row">
                        <div class="profile-picture">
                            <div class="upload-profile">
                                <div class="profile-img">
                                    <img id="blah" class="avatar" src="assets/img/profiles/avatar-14.jpg"
                                        alt="profile-img">
                                </div>
                                <div class="add-profile">
                                    <h5>Upload a New Photo</h5>
                                </div>
                            </div>
                            <div class="img-upload">
                                <label class="btn btn-upload">
                                    Upload <input type="file" name="image"
                                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                </label>
                                <!-- <a class="btn btn-remove">Remove</a> -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Name">
                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email"
                                        placeholder="Enter Email Address">
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Mobile <span class="text-danger">*</span></label>
                                    <input type="text" id="mobile_code" name="mobile" class="form-control"
                                        placeholder="Phone Number" name="name">
                                    @if ($errors->has('mobile'))
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" placeholder="Enter City">
                                    @if ($errors->has('city'))
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block">
                                    <label>State</label>
                                    <input type="text" class="form-control" name="state" placeholder="Enter State">
                                    @if ($errors->has('state'))
                                    <span class="text-danger">{{ $errors->first('state') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="pass-group">
                                    <div class="input-block">
                                        <label>Country</label>
                                        <input type="text" class="form-control" name="country"
                                            placeholder="Enter Country">
                                        @if ($errors->has('country'))
                                        <span class="text-danger">{{ $errors->first('country') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-primary cancel me-2">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Partner Details Modal -->
<!-- Edit Partner Details Modal -->
<div class="modal custom-modal modal-lg fade" id="edit_partner_details" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="form-header modal-header-title text-start mb-0">
                    <h4 class="mb-0">Add Partner Details</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="edit_partner_details_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Spoofing PUT for update -->
                    <input type="hidden" name="partner_id" id="partner_id">
                    <!-- Include CSRF token for security -->
                    <div class="row">
                        <div class="profile-picture">
                            <div class="upload-profile">
                                <div class="profile-img">
                                    <img id="blahedit" class="avatar" src="assets/img/profiles/avatar-14.jpg"
                                        alt="profile-img">
                                </div>
                                <div class="add-profile">
                                    <h5>Upload a New Photo</h5>
                                </div>
                            </div>
                            <div class="img-upload">
                                <label class="btn btn-upload">
                                    Upload <input type="file" name="image"
                                        onchange="document.getElementById('blahedit').src = window.URL.createObjectURL(this.files[0])">
                                </label>
                                <!-- <a class="btn btn-remove">Remove</a> -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="edit_name"
                                        placeholder="Enter Name">
                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="edit_email"
                                        placeholder="Enter Email Address">
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>Mobile <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile" class="form-control" placeholder="Phone Number"
                                        id="edit_mobile">
                                    @if ($errors->has('mobile'))
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" id="edit_city"
                                        placeholder="Enter City">
                                    @if ($errors->has('city'))
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block">
                                    <label>State</label>
                                    <input type="text" class="form-control" name="state" id="edit_state"
                                        placeholder="Enter State">
                                    @if ($errors->has('state'))
                                    <span class="text-danger">{{ $errors->first('state') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="pass-group">
                                    <div class="input-block">
                                        <label>Country</label>
                                        <input type="text" class="form-control" name="country" id="edit_country"
                                            placeholder="Enter Country">
                                        @if ($errors->has('country'))
                                        <span class="text-danger">{{ $errors->first('country') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-primary cancel me-2">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Partner Details Modal -->
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

<!-- Include Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript">
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
    $('#partner_details_form').on('submit', function(e) {
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
                // $('#partner_details').modal('hide'); // Close modal
                $('#partner_details_form')[0].reset(); // Reset the form
                setTimeout(function() {
                    window.location.reload(); // Reload the page after the delay
                }, 3000); // 5-second delay

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

    $(document).on('click', '.edit_partner', function() {
        var id = $(this).data('id'); // Get user ID from the button
        // Make an AJAX request to fetch the user data
        $.ajax({
            url: '{{ route("partners.edit", ":id") }}'.replace(':id',
                id), // Replace ':id' with the actual user ID
            type: 'GET',
            success: function(response) {
                var data = response.data;

                // Populate the form fields with the fetched data
                $('#partner_id').val(data.id); // Hidden user ID
                $('#edit_name').val(data.name);
                $('#edit_email').val(data.email);
                $('#edit_mobile').val(data.mobile);
                $('#edit_city').val(data.city);
                $('#edit_state').val(data.state);
                $('#edit_country').val(data.country);
                if (data.image) {
                    // Set the profile image source
                    $('#blahedit').attr('src', '{{ url("public/profile") }}/' + data
                        .image);
                } else {
                    // Set to default image if no profile exists
                    $('#blahedit').attr('src',
                        '{{ url("public/assets/img/profiles/default.png") }}');
                }
                // Open the modal
                $('#edit_partner_details').modal('show');
            },
            error: function(xhr) {
                toastr.error('Error fetching user data.');
            }
        });
    });
    // Edit Partner
    $('#edit_partner_details_form').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        var formData = new FormData(this); // FormData for file uploads
        var id = $('#partner_id').val(); // Get user ID from hidden input

        $.ajax({
            url: '{{ route("partners.update", ":id") }}'.replace(':id', id), // Update route
            type: 'POST', // POST method with method override
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-HTTP-Method-Override': 'PUT' // Spoofing PUT
            },
            success: function(response) {
                toastr.success(response.message);
                // Clear the existing table body            
                // $('#edit_partner_details').modal('hide'); // Close modal after success
                setTimeout(function() {
                    window.location.reload(); // Reload the page after the delay
                }, 3000);
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
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var filterToggle = document.getElementById('filterToggle'); // Make sure you have this element
        var filterSidebar = document.querySelector('.toggle-sidebar');

        filterToggle.addEventListener('click', function (event) {
            event.preventDefault();
            filterSidebar.classList.toggle('active');
        });

        // Close button functionality
        var closeSidebar = document.querySelector('.sidebar-closes');
        closeSidebar.addEventListener('click', function (event) {
            event.preventDefault();
            filterSidebar.classList.remove('active');
        });
    });

    function resetForm() {
        // Clear the input values
        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('mobile').value = '';
        document.getElementById('city').value = '';
        document.getElementById('state').value = '';
        document.getElementById('country').value = '';

        // Redirect to the main partners page to reset filters
        window.location.href = '{{route('partners.partners-report')}}';
    }
</script>
@endsection