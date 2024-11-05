@extends('admin.layouts.master')
@section('content')

<!-- Main Wrapper -->
@include('admin.layouts.common-sidebar')

<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="content-page-header">
                <h5>Users</h5> <!-- Updated title for clarity -->
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
                                                href="{{ route('user-wise-report.downloadPDF', request()->query()) }}">
                                                <i class="far fa-file-pdf me-2"></i>PDF
                                            </a>
                                        </li>
                                        <li>
                                            <a class="d-flex align-items-center download-item"
                                                href="{{ route('user-wise-report.downloadCSV', request()->query()) }}">
                                                <i class="far fa-file-text me-2"></i>CSV
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        @if(collect(getPermission())->contains('name', 'create-user'))
                        <li>
                            <a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#add_user"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add
                                user</a>
                        </li>
                        @endif
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
                    <form action="{{ route('users.index') }}" method="GET" autocomplete="off">
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
                                  id="reset-btn">
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($users->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">No data available</td>
                                    </tr>
                                    @else
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->mobile ?? 'N/A' }}</td>
                                        <td>{{ $user->roles->isNotEmpty() ? $user->roles->first()->name : 'No Role' }}
                                        </td>
                                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                             
                                        <td>@if($user->status == 1) <span class="badge  bg-success-light">Active</span>@else<span class="badge  bg-danger-light">Inactive</span>@endif</td>
                                        <!-- Added status display -->
                                        <td>
                                            <a href="#" class="btn-action-icon" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul>
                                                    <li>
                                                        <a class="dropdown-item edit-user" href="javascript:void(0);"
                                                            data-bs-toggle="modal" data-bs-target="#edit_user"
                                                            data-id="{{ $user->id }}">
                                                            <i class="far fa-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal{{$user->id}}"><i
                                                                class="far fa-trash-alt me-2"></i>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- Delete Items Modal -->
                                            <div class="modal custom-modal fade" id="delete_modal{{$user->id}}"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="form-header">
                                                                <h3>Delete User</h3>
                                                                <p>Are you sure want to delete?</p>
                                                            </div>
                                                            <div class="modal-btn delete-action">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <form
                                                                            action="{{ route('users.destroy', $user->id) }}"
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
                                    @endforeach
                                    @endif
                                </tbody>
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
                    <form id="addUserForm" action="{{ route('users.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Include CSRF token for security -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <div class="form-groups-item">
                                            <div class="profile-picture">
                                                <div class="upload-profile">
                                                    <div class="profile-img">
                                                        <img id="blah" class="avatar"
                                                            src="assets/img/profiles/avatar-14.jpg" alt="profile-img">
                                                    </div>
                                                    <div class="add-profile">
                                                        <h5>Upload a New Photo</h5>
                                                    </div>
                                                </div>
                                                <div class="img-upload">
                                                    <label class="btn btn-upload">
                                                        Upload <input type="file" name="profile"
                                                            onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                                    </label>
                                                    <!-- <a class="btn btn-remove">Remove</a> -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label>First Name</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter First Name" name="first_name" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label>Last Name</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Last Name" name="last_name" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label>Email</label>
                                                        <input type="email" class="form-control"
                                                            placeholder="Enter Email Address" name="email" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label>Phone Number</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Phone Number" name="mobile" required>
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
                                                            <input type="password" class="form-control pass-input"
                                                                name="password" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="pass-group" id="passwordInput2">
                                                        <div class="input-block">
                                                            <label>Confirm Password</label>
                                                            <input type="password" class="form-control pass-input"
                                                                name="password_confirmation" required>
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
                            <button type="button" data-bs-dismiss="modal"
                                class="btn btn-back cancel-btn me-2">Cancel</button>
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
                    <form id="editUserForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Spoofing PUT for update -->
                        <input type="hidden" name="user_id" id="user_id"> <!-- Hidden field for user ID -->

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <!-- Profile Picture -->
                                        <div class="profile-picture">
                                            <div class="upload-profile">
                                                <div class="profile-img">
                                                    <img id="blahedit" class="avatar"
                                                        src="assets/img/profiles/avatar-14.jpg" alt="profile-img">
                                                </div>
                                                <div class="add-profile">
                                                    <h5>Upload a New Photo</h5>
                                                </div>
                                            </div>
                                            <div class="img-upload">
                                                <label class="btn btn-upload">
                                                    Upload <input type="file" name="profile"
                                                        onchange="document.getElementById('blahedit').src = window.URL.createObjectURL(this.files[0])">
                                                </label>
                                                <!-- <a class="btn btn-remove">Remove</a> -->
                                            </div>
                                        </div>


                                        <!-- Form Fields -->
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <label>First Name</label>
                                                    <input type="text" class="form-control" id="edit_first_name"
                                                        placeholder="Enter First Name" name="first_name" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <label>Last Name</label>
                                                    <input type="text" class="form-control" id="edit_last_name"
                                                        placeholder="Enter Last Name" name="last_name" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" id="edit_email"
                                                        placeholder="Enter Email Address" name="email" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <label>Phone Number</label>
                                                    <input type="text" class="form-control" id="edit_mobile"
                                                        placeholder="Enter Phone Number" name="mobile" required>
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
                                                        <input type="password" class="form-control" id="edit_password"
                                                            name="password">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="pass-group">
                                                    <div class="input-block">
                                                        <label>Confirm Password</label>
                                                        <input type="password" class="form-control"
                                                            id="edit_password_confirmation"
                                                            name="password_confirmation">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-bs-dismiss="modal"
                                class="btn btn-back cancel-btn me-2">Cancel</button>
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
                                    <a href="#" data-bs-dismiss="modal"
                                        class="btn btn-primary paid-cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Items Modal -->
    </div>
</div>
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

 $(document).on('click','#reset-btn',function(){
    window.location.href = '{{ route("users.index") }}'; 
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
                // $('#addUserForm')[0].reset(); // Reset the form
                // $('#users-table').DataTable().ajax.reload(null,
                //     false); // Reload and stay on the current page
                    $('#addUserForm')[0].reset(); // Reset the form
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


    $(document).on('click', '.edit-user', function() {
        var userId = $(this).data('id'); // Get user ID from the button

        // Make an AJAX request to fetch the user data
        $.ajax({
            url: '{{ route("users.edit", ":id") }}'.replace(':id',
                userId), // Replace ':id' with the actual user ID
            type: 'GET',
            success: function(response) {
                var user = response.user;
                // Populate the form fields with the fetched data
                $('#user_id').val(user.id); // Hidden user ID
                $('#edit_first_name').val(user.first_name);
                $('#edit_last_name').val(user.last_name);
                $('#edit_email').val(user.email);
                $('#edit_mobile').val(user.mobile);
                $('#edit_role').val(response.role_id)
                    .change(); // Assuming 'role_id' is the field containing the user's role
                $('#edit_status').val(user.status).change(); // Assuming 'status' is 1 or 0

                // Handle profile image
                if (user.profile) {
                    // Set the profile image source
                    $('#blahedit').attr('src', '{{ url("public/profile") }}/' + user
                        .profile);
                } else {
                    // Set to default image if no profile exists
                    $('#blahedit').attr('src',
                        '{{ url("public/assets/img/profiles/default.png") }}');
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
                // $('#users-table').DataTable().ajax.reload(null,
                //     false); // Reload and stay on the current page
                setTimeout(function() {
                window.location.reload(); // Reload the page after the delay
               }, 3000); // 5-second delay
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
}); // end ready function
</script>

@endsection