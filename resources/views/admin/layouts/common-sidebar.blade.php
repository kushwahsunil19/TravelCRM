<div class="main-wrapper">

    <!-- Header -->
    <div class="header header-one">
        <a href="{{route('dashboard')}}"
            class="d-inline-flex d-sm-inline-flex align-items-center d-md-inline-flex d-lg-none align-items-center device-logo">
            <img src="assets/img/logo.png" class="img-fluid logo2" alt="Logo">
        </a>
        <div class="main-logo d-inline float-start d-lg-flex align-items-center d-none d-sm-none d-md-none">
            <div class="logo-white">
                <a href="{{route('dashboard')}}">
                    <img src="assets/img/logo-full-white.png" class="img-fluid logo-blue" alt="Logo">
                </a>
                <a href="{{route('dashboard')}}">
                    <img src="assets/img/logo-small-white.png" class="img-fluid logo-small" alt="Logo">
                </a>
            </div>
            <div class="logo-color">
                <a href="{{route('dashboard')}}">
                    <img src="{{url('public/assets/img/logo2.png')}}" class="img-fluid logo-blue" alt="Logo">
                </a>
                <a href="{{route('dashboard')}}">
                    <img src="{{url('public/assets/img/logo-small.png')}}" class="img-fluid logo-small" alt="Logo">
                </a>
            </div>
        </div>
        <!-- Sidebar Toggle -->
        <a href="javascript:void(0);" id="toggle_btn">
            <span class="toggle-bars">
                <span class="bar-icons"></span>
                <span class="bar-icons"></span>
                <span class="bar-icons"></span>
                <span class="bar-icons"></span>
            </span>
        </a>
        <!-- /Sidebar Toggle -->

        <!-- Search -->
        <!-- <div class="top-nav-search">
				<form>
					<input type="text" class="form-control" placeholder="Search here">
					<button class="btn" type="submit"><img src="assets/img/icons/search.svg" alt="img"></button>
				</form>
			</div> -->
        <!-- /Search -->

        <!-- Mobile Menu Toggle -->
        <a class="mobile_btn" id="mobile_btn">
            <i class="fas fa-bars"></i>
        </a>
        <!-- /Mobile Menu Toggle -->

        <!-- Header Menu -->
        <ul class="nav nav-tabs user-menu">
            <!-- Flag -->
            <!-- <li class="nav-item dropdown has-arrow flag-nav">
					<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button">
						<img src="assets/img/flags/us1.png" alt="flag" ><span>English</span>
					</a>
					<div class="dropdown-menu dropdown-menu-end">
						<a href="javascript:void(0);" class="dropdown-item">
							<img src="assets/img/flags/us.png" alt="flag" ><span>English</span>
						</a>
						<a href="javascript:void(0);" class="dropdown-item">
							<img src="assets/img/flags/fr.png" alt="flag" ><span>French</span>
						</a>
						<a href="javascript:void(0);" class="dropdown-item">
							<img src="assets/img/flags/es.png" alt="flag" ><span>Spanish</span>
						</a>
						<a href="javascript:void(0);" class="dropdown-item">
							<img src="assets/img/flags/de.png" alt="flag" ><span>German</span>
						</a>
					</div>
				</li> -->
            <!-- /Flag -->
            <!-- <li class="nav-item dropdown  flag-nav dropdown-heads">
					<a class="nav-link" data-bs-toggle="dropdown" href="#" role="button">
						<i class="fe fe-bell"></i> <span class="badge rounded-pill"></span>
					</a>
					<div class="dropdown-menu notifications">
						<div class="topnav-dropdown-header">
							<div class="notification-title">Notifications <a href="notifications.html">View all</a></div>
							<a href="javascript:void(0)" class="clear-noti d-flex align-items-center">Mark all as read <i class="fe fe-check-circle"></i></a>
						</div>
						<div class="noti-content">
							<ul class="notification-list">
								<li class="notification-message">
									<a href="profile.html">
										<div class="d-flex">
											<span class="avatar avatar-md active">
												<img class="avatar-img rounded-circle" alt="avatar-img" src="assets/img/profiles/avatar-02.jpg">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Lex Murphy</span> requested access to <span class="noti-title">UNIX directory tree hierarchy</span></p>
												<div class="notification-btn">
													<span class="btn btn-primary">Accept</span>
													<span class="btn btn-outline-primary">Reject</span>
												</div>
												<p class="noti-time"><span class="notification-time">Today at 9:42 AM</span></p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="profile.html">
										<div class="d-flex">
											<span class="avatar avatar-md active">
												<img class="avatar-img rounded-circle" alt="avatar-img" src="assets/img/profiles/avatar-10.jpg">
											</span>
											<div class="media-body"> 
												<p class="noti-details"><span class="noti-title">Ray Arnold</span> left 6 comments <span class="noti-title">on Isla Nublar SOC2 compliance report</span></p>
												<p class="noti-time"><span class="notification-time">Yesterday at 11:42 PM</span></p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="profile.html">
										<div class="d-flex">
											<span class="avatar avatar-md">
												<img class="avatar-img rounded-circle" alt="avatar-img" src="assets/img/profiles/avatar-13.jpg">
											</span>
											<div class="media-body">   
												<p class="noti-details"><span class="noti-title">Dennis Nedry</span> commented on <span class="noti-title"> Isla Nublar SOC2 compliance report</span></p>
												<blockquote>
													“Oh, I finished de-bugging the phones, but the system's compiling for eighteen minutes, or twenty.  So, some minor systems may go on and off for a while.”
												</blockquote>
												<p class="noti-time"><span class="notification-time">Yesterday at 5:42 PM</span></p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="profile.html">
										<div class="d-flex">
											<span class="avatar avatar-md">
												<img class="avatar-img rounded-circle" alt="avatar-img" src="assets/img/profiles/avatar-05.jpg">
											</span>
											<div class="media-body">  
												<p class="noti-details"><span class="noti-title">John Hammond</span> created <span class="noti-title">Isla Nublar SOC2 compliance report</span></p>
												<p class="noti-time"><span class="notification-time">Last Wednesday at 11:15 AM</span></p>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</div>
						<div class="topnav-dropdown-footer">
							<a href="#">Clear All</a>
						</div>
					</div>
				</li> -->
            <li class="nav-item  has-arrow dropdown-heads ">
                <a href="javascript:void(0);" class="win-maximize">
                    <i class="fe fe-maximize"></i>
                </a>
            </li>
            <!-- User Menu -->
            <li class="nav-item dropdown">
                <a href="javascript:void(0)" class="user-link  nav-link" data-bs-toggle="dropdown">
                    <span class="user-img">
                        <img src="{{ Auth::user()->profile ? url('public/profile/' . Auth::user()->profile) : url('public/assets/img/profiles/default.png') }}" alt="img" class="profilesidebar">
                        <span class="animate-circle"></span>
                    </span>
                    <span class="user-content">
                        <span class="user-details"> @if(Auth::user()->roles->isEmpty())
                            <em>No Roles Assigned</em>
                            @else
                            @foreach(Auth::user()->roles as $role)
                            {{ ucfirst($role->name) }}
                            @endforeach
                            @endif</span>
                        <span class="user-name"> {{ Auth::user()->name }}</span>
                    </span>
                </a>
                <div class="dropdown-menu menu-drop-user">
                    <div class="profilemenu">
                        <div class="subscription-menu">
                            <ul>
                                <li>
                                    <a class="dropdown-item" href="{{url('profile')}}">Profile</a>
                                </li>
                                <!-- <li>
										<a class="dropdown-item" href="settings.html">Settings</a>
									</li> -->
                            </ul>
                        </div>
                        <div class="subscription-logout">
                            <ul>
                                <li class="pb-0">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
									document.getElementById('logout-form').submit();">Log Out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <!-- /User Menu -->

        </ul>

        <!-- /Header Menu -->

    </div>
    <!-- /Header -->


    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <nav class="greedys sidebar-horizantal">
                    <ul class="list-inline-item list-unstyled links">
                        <li class="menu-title"><span>Main</span></li>
                        <li class="submenu">
                            <a href="{{route('dashboard')}}"><i class="fe fe-home"></i> <span> Dashboard</span> <span
                                    class="menu-arrow"></span></a>

                            <!-- <ul>
									<li><a href="{{route('dashboard')}}" class="active">Admin Dashboard</a></li>
								</ul> -->

                        </li>
                        <!-- <li class="submenu">
								<a href="#"><i class="fe fe-grid"></i> <span> Applications</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="#">Chat</a></li>
									<li><a href="#">Calendar</a></li>
									<li><a href="#">Email</a></li>
								</ul>
							</li> -->
                        <!-- <li class="submenu">
								<a href="#"><i class="fe fe-user"></i> <span> Super Admin</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="#">Companies</a></li>
									<li><a href="#">Subscription</a></li>
									<li><a href="#">Packages</a></li>
									<li><a href="#">Domain Request</a></li>
									<li><a href="#">Domain</a></li>
									<li><a href="#">Purchase Transaction</a></li>
								</ul>
							</li> -->

                        <!-- <li class="submenu">
                            <a href="#"><i class="fe fe-users"></i><span>Customers</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="#"><i class="fe fe-users"></i> <span>Customers</span></a></li>
                                <li>
                                    <a href="#"><i class="fe fe-file"></i> <span>Customer Details</span></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fe fe-user"></i> <span>Vendors</span></a>
                                </li>
                            </ul>
                        </li> -->
                        <!-- Quotations -->
                        <li class="menu-title"><span>Manage Quotations </span></li>

                        <li class="submenu">

                            <a href="{{route('quotations.index')}}"><i class="fe fe-file"></i> <span>Manage
                                    Quotations</span><span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="{{route('branches.index')}}">Branches </a></li>
                                <li><a href="{{route('packages.index')}}">Packeses</a></li>
                                <li><a href="{{route('partners.index')}}">Partners</a></li>
                                <li><a href="{{route('quotations.index')}}">Quatations</a></li>

                            </ul>
                        </li>

                        <!-- Quotations -->

                        <li class="menu-title"><span>Inventory</span></li>
                        <!-- <li class="submenu">
								<a href="#"><i class="fe fe-package"></i> <span> Products / Services</span> <span class="menu-arrow"></span></a>
								<ul>
									<li><a href="#">Product List</a></li>
									<li><a href="#">Category</a></li>
									
									<li><a href="#">Units</a></li>
								</ul>
							</li> -->
                        <li>
                            <a href="#"><i class="fe fe-user"></i> <span>Inventory</span></a>
                        </li>

                        <li class="submenu">
                            <a href="#"><i class="fe fe-file-plus"></i><span>Signature</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="#"><i class="fe fe-clipboard"></i> <span>List of Signature</span></a></li>
                                <li><a href="#"><i class="fe fe-box"></i> <span>Signature Invoice</span></a></li>

                            </ul>
                        </li>

                        <li class="menu-title"><span>Sales</span></li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-file"></i> <span>Invoices</span><span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="#">Invoices List</a></li>
                                <li><a href="#">Invoice Details (Admin)</a></li>
                                <li><a href="#">Invoice Details (Customer)</a></li>
                                <li><a href="#">Invoice Templates</a></li>
                            </ul>
                        </li>
                    </ul>
                    <button class="viewmoremenu">More Menu</button>
                    <ul class="hidden-links hidden">
                        <!-- <li>
								<a href="#"><i class="fe fe-clipboard"></i> <span>Recurring Invoices</span></a>
							</li>
							<li>
								<a href="#"><i class="fe fe-edit"></i> <span>Credit Notes</span></a>
							</li>
							<li class="menu-title"><span>Purchases</span></li>							
							<li>
								<a href="#"><i class="fe fe-shopping-cart"></i> <span>Purchases</span></a>
							</li>
							<li>
								<a href="#"><i class="fe fe-shopping-bag"></i> <span>Purchase Orders</span></a>
							</li>
							<li>
								<a href="#"><i class="fe fe-file-text"></i> <span>Debit Notes</span></a>
							</li> -->
                        invoice
                        <li class="menu-title"><span>Finance & Accounts</span></li>
                        <li>
                            <a href="#"><i class="fe fe-file-plus"></i> <span>Expenses</span></a>
                        </li>
                        <li>
                            <a href="#"><i class="fe fe-credit-card"></i> <span>Payments</span></a>
                        </li>

                        <li class="menu-title"><span>Quotations</span></li>
                        <li>
                            <a href="quotations.html"><i class="fe fe-clipboard"></i> <span>Quotations</span></a>
                        </li>
                        <li>
                            <a href="delivery-challans.html"><i class="fe fe-file-text"></i> <span>Delivery
                                    Challans</span></a>
                        </li>

                        <li class="menu-title"><span>Reports</span></li>
                        <li>
                            <a href="payment-summary.html"><i class="fe fe-credit-card"></i> <span>Payment
                                    Summary</span></a>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-box"></i><span>Reports</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="expense-report.html">Expense Report</a></li>
                                <li><a href="purchase-report.html">Purchase Report</a></li>
                                <li><a href="purchase-return.html">Purchase Return Report</a></li>
                                <li><a href="sales-report.html">Sales Report</a></li>
                                <li><a href="sales-return-report.html">Sales Return Report</a></li>
                                <li><a href="quotation-report.html">Quotation Report</a></li>
                                <li><a href="payment-report.html">Payment Report</a></li>
                                <li><a href="stock-report.html">Stock Report</a></li>
                                <li><a href="low-stock-report.html">Low Stock Report</a></li>
                                <li><a href="income-report.html">Income Report</a></li>
                                <li><a href="tax-purchase.html">Tax Report</a></li>
                                <li><a href="profit-loss-list.html">Profit & Loss</a></li>
                            </ul>
                        </li>
                        </li>

                        <li class="menu-title"><span>User Management</span></li>
                        <li>
                            <a href="users.html"><i class="fe fe-user"></i> <span>Users</span></a>
                        </li>
                        <li>
                            <a href="roles-permission.html"><i class="fe fe-clipboard"></i> <span>Roles &
                                    Permission</span></a>
                        </li>
                        <li>
                            <a href="delete-account-request.html"><i class="fe fe-trash-2"></i> <span>Delete Account
                                    Request</span></a>
                        </li>

                        <li class="menu-title"><span>Membership</span></li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-book"></i> <span> Membership</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="membership-plans.html">Membership Plans</a></li>
                                <li><a href="membership-addons.html">Membership Addons</a></li>
                                <li><a href="subscribers.html">Subscribers</a></li>
                                <li><a href="transactions.html">Transactions</a></li>
                            </ul>
                        </li>

                        <li class="menu-title"><span>Content (CMS)</span></li>
                        <li>
                            <a href="pages.html"><i class="fe fe-folder"></i> <span>Pages</span></a>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-book"></i> <span> Blog</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="all-blogs.html">All Blogs</a></li>
                                <li><a href="categories.html">Categories</a></li>
                                <li><a href="blog-comments.html">Blog Comments</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-map-pin"></i> <span> Location</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="countries.html">Countries</a></li>
                                <li><a href="states.html">States</a></li>
                                <li><a href="cities.html">Cities</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="testimonials.html"><i class="fe fe-message-square"></i>
                                <span>Testimonials</span></a>
                        </li>
                        <li>
                            <a href="faq.html"><i class="fe fe-alert-circle"></i> <span>FAQ</span></a>
                        </li>

                        <li class="menu-title"><span>Support</span></li>
                        <li>
                            <a href="contact-messages.html"><i class="fe fe-printer"></i> <span>Contact
                                    Messages</span></a>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-save"></i> <span> Tickets</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="tickets.html">Tickets</a></li>
                                <li><a href="tickets-list.html">Tickets List</a></li>
                                <li><a href="tickets-kanban.html">Tickets Kanban</a></li>
                                <li><a href="ticket-details.html">Ticket Overview</a></li>
                            </ul>
                        </li>

                        <li class="menu-title"><span>Pages</span></li>
                        <li>
                            <a href="profile.html"><i class="fe fe-user"></i> <span>Profile</span></a>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-lock"></i> <span> Authentication </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="#"> Login </a></li>
                                <li><a href="#"> Register </a></li>
                                <li><a href="#"> Forgot Password </a></li>
                                <li><a href="#"> Lock Screen </a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fe fe-x-square"></i> <span>Error Pages</span></a>
                        </li>
                        <li>
                            <a href="#"><i class="fe fe-file"></i> <span>Blank Page</span></a>
                        </li>
                        <li>
                            <a href="#"><i class="fe fe-image"></i> <span>Vector Maps</span></a>
                        </li>

                        <li class="menu-title">
                            <span>UI Interface</span>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-pocket"></i> <span>Base UI </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="alerts.html">Alerts</a></li>
                                <li><a href="accordions.html">Accordions</a></li>
                                <li><a href="avatar.html">Avatar</a></li>
                                <li><a href="badges.html">Badges</a></li>
                                <li><a href="buttons.html">Buttons</a></li>
                                <li><a href="buttongroup.html">Button Group</a></li>
                                <li><a href="breadcrumbs.html">Breadcrumb</a></li>
                                <li><a href="cards.html">Cards</a></li>
                                <li><a href="carousel.html">Carousel</a></li>
                                <li><a href="dropdowns.html">Dropdowns</a></li>
                                <li><a href="grid.html">Grid</a></li>
                                <li><a href="images.html">Images</a></li>
                                <li><a href="lightbox.html">Lightbox</a></li>
                                <li><a href="media.html">Media</a></li>
                                <li><a href="modal.html">Modals</a></li>
                                <li><a href="offcanvas.html">Offcanvas</a></li>
                                <li><a href="pagination.html">Pagination</a></li>
                                <li><a href="popover.html">Popover</a></li>
                                <li><a href="progress.html">Progress Bars</a></li>
                                <li><a href="placeholders.html">Placeholders</a></li>
                                <li><a href="rangeslider.html">Range Slider</a></li>
                                <li><a href="spinners.html">Spinner</a></li>
                                <li><a href="sweetalerts.html">Sweet Alerts</a></li>
                                <li><a href="tab.html">Tabs</a></li>
                                <li><a href="toastr.html">Toasts</a></li>
                                <li><a href="tooltip.html">Tooltip</a></li>
                                <li><a href="typography.html">Typography</a></li>
                                <li><a href="video.html">Video</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-box"></i> <span>Elements </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="ribbon.html">Ribbon</a></li>
                                <li><a href="clipboard.html">Clipboard</a></li>
                                <li><a href="drag-drop.html">Drag & Drop</a></li>
                                <li><a href="rating.html">Rating</a></li>
                                <li><a href="text-editor.html">Text Editor</a></li>
                                <li><a href="counter.html">Counter</a></li>
                                <li><a href="scrollbar.html">Scrollbar</a></li>
                                <li><a href="notification.html">Notification</a></li>
                                <li><a href="stickynote.html">Sticky Note</a></li>
                                <li><a href="timeline.html">Timeline</a></li>
                                <li><a href="horizontal-timeline.html">Horizontal Timeline</a></li>
                                <li><a href="form-wizard.html">Form Wizard</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-bar-chart"></i> <span> Charts </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="chart-apex.html">Apex Charts</a></li>
                                <li><a href="chart-js.html">Chart Js</a></li>
                                <li><a href="chart-morris.html">Morris Charts</a></li>
                                <li><a href="chart-flot.html">Flot Charts</a></li>
                                <li><a href="chart-peity.html">Peity Charts</a></li>
                                <li><a href="chart-c3.html">C3 Charts</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-award"></i> <span> Icons </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <!-- <li><a href="icon-fontawesome.html">Fontawesome Icons</a></li>
									<li><a href="icon-feather.html">Feather Icons</a></li>
									<li><a href="icon-ionic.html">Ionic Icons</a></li>
									<li><a href="icon-material.html">Material Icons</a></li>
									<li><a href="icon-pe7.html">Pe7 Icons</a></li>
									<li><a href="icon-simpleline.html">Simpleline Icons</a></li>
									<li><a href="icon-themify.html">Themify Icons</a></li>
									<li><a href="icon-weather.html">Weather Icons</a></li>
									<li><a href="icon-typicon.html">Typicon Icons</a></li>
									<li><a href="icon-flag.html">Flag Icons</a></li> -->
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-sidebar"></i> <span> Forms </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <!-- <li><a href="form-basic-inputs.html">Basic Inputs </a></li>
									<li><a href="form-input-groups.html">Input Groups </a></li>
									<li><a href="form-horizontal.html">Horizontal Form </a></li>
									<li><a href="form-vertical.html"> Vertical Form </a></li>
									<li><a href="form-mask.html">Form Mask </a></li>
									<li><a href="form-validation.html">Form Validation </a></li>
									<li><a href="form-select2.html">Form Select2 </a></li>
									<li><a href="form-fileupload.html">File Upload </a></li> -->
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fe fe-layout"></i> <span> Tables </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="tables-basic.html">Basic Tables </a></li>
                                <li><a href="data-tables.html">Data Table </a></li>
                            </ul>
                        </li>

                        <li class="menu-title"><span>Settings</span></li>
                        <li>
                            <a href="settings.html"><i class="fe fe-settings"></i> <span>Settings</span></a>
                        </li>
                        <li class="menu-title">
                            <span>Extras</span>
                        </li>
                        <li>
                            <a href="#"><i class="fe fe-file-text"></i> <span>Documentation</span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"><i class="fe fe-lock"></i> <span>Change Log</span> <span
                                    class="badge badge-primary ms-auto">v2.0</span></a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i class="fa fa-list"></i> <span>Multi Level</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li class="submenu">
                                    <a href="javascript:void(0);"> <span>Level 1</span> <span
                                            class="menu-arrow"></span></a>
                                    <ul style="display: none;" class="level2">
                                        <li><a href="javascript:void(0);"><span>Level 2</span></a></li>
                                        <li class="submenu">
                                            <a href="javascript:void(0);"> <span> Level 2</span> <span
                                                    class="menu-arrow"></span></a>
                                            <ul style="display: none;" class="level3">
                                                <li><a href="javascript:void(0);">Level 3</a></li>
                                                <li><a href="javascript:void(0);">Level 3</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:void(0);"> <span>Level 2</span></a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0);"> <span>Level 1</span></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fe fe-power"></i> <span>Logout</span></a>
                        </li>
                    </ul>
                    <!-- /Settings -->
                </nav>
                <ul class="sidebar-vertical">
                    <!-- Main -->
                    <li class="menu-title"><span>Main</span></li>
                    <li class="submenu">
                        <a href="{{route('dashboard')}}"><i class="fe fe-home"></i> <span> Dashboard</span>@if(
                            Auth::user()->role=='admin') <span class="menu-arrow"></span>@endif</a>

                        <!-- <ul style="display: none;">
								<li><a class="active" href="{{route('dashboard')}}">Admin Dashboard</a></li>
							</ul> -->

                    </li>
                    <!-- <li class="submenu">
							<a href="#"><i class="fe fe-grid"></i> <span> Applications</span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="chat.html">Chat</a></li>
								<li><a href="calendar.html">Calendar</a></li>
								<li><a href="inbox.html">Email</a></li>
							</ul>
						</li> -->
                    <!-- /Main -->

                    <!-- <li class="submenu">
							<a href="#"><i class="fe fe-user"></i> <span> Super Admin</span> <span class="menu-arrow"></span></a>
							<ul>
								<li><a href="#">Companies</a></li>
								<li><a href="#">Subscription</a></li>
								<li><a href="#">Packages</a></li>
								<li><a href="#">Domain Request</a></li>
								<li><a href="#">Domain</a></li>
								<li><a href="#">Purchase Transaction</a></li>
							</ul>
						</li> -->

                    <!-- Customers -->
                    <!-- <li class="menu-title"><span>Customers</span></li>
                    <li>
                        <a href="#"><i class="fe fe-users"></i> <span>Customers</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fe fe-file"></i> <span>Customer Details</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fe fe-user"></i> <span>Vendors</span></a>
                    </li> -->
                    <!-- /Customers -->
                    <!-- Quotations -->
                    <li class="menu-title"><span>Manage Quotations </span></li>

                    <li class="submenu">

                        <a href="{{route('quotations.index')}}"><i class="fe fe-file"></i> <span>Manage
                                Quotations</span><span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{route('branches.index')}}">Branches </a></li>
                            <li><a href="{{route('packages.index')}}">Packeses</a></li>
                            <li><a href="{{route('partners.index')}}">Partners</a></li>
                            <li><a href="{{route('quotations.index')}}">Quatations</a></li>

                        </ul>
                    </li>

                    <!-- Quotations -->

                    <!-- Inventory -->
                    <!-- <li class="menu-title"><span>Inventory</span></li>
						<li class="submenu">
							<a href="#"><i class="fe fe-package"></i> <span> Products / Services</span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="product-list.html">Product List</a></li>
								<li><a href="category.html">Category</a></li>
								
								<li><a href="units.html">Units</a></li>
							</ul>
						</li> -->
                    <!-- <li>
							<a href="inventory.html"><i class="fe fe-user"></i> <span>Inventory</span></a>
						</li> -->
                    <!-- /Inventory -->

                    <!-- Signature -->
                    <!-- <li class="menu-title"><span>Signature</span></li>
						<li>
							<a  href="signature-list.html"><i class="fe fe-clipboard"></i> <span>List of Signature</span></a>
							<a  href="signature-invoice.html"><i class="fe fe-box"></i> <span>Signature Invoice</span></a>
						</li> -->
                    <!-- /Signature -->

                    <!-- Sales -->
                    <li class="menu-title"><span>Sales</span></li>
                    <li class="submenu">

                        <a href="#"><i class="fe fe-file"></i> <span>Invoices</span><span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="#">Invoices List</a></li>
                            <li><a href="#">Invoice Details (Admin)</a></li>
                            <li><a href="#">Invoice Details (Customer)</a></li>
                            <li><a href="#">Invoice Templates</a></li>
                        </ul>
                    </li>
                    <!-- <li>
							<a href="recurring-invoices.html"><i class="fe fe-clipboard"></i> <span>Recurring Invoices</span></a>
						</li>
						<li>
							<a href="credit-notes.html"><i class="fe fe-edit"></i> <span>Credit Notes</span></a>
						</li> -->
                    <!-- /Sales -->

                    <!-- Purchases -->
                    <!-- <li class="menu-title"><span>Purchases</span></li>							
						<li>
							<a href="purchases.html"><i class="fe fe-shopping-cart"></i> <span>Purchases</span></a>
						</li>
						<li>
							<a href="purchase-orders.html"><i class="fe fe-shopping-bag"></i> <span>Purchase Orders</span></a>
						</li>
						<li>
							<a href="debit-notes.html"><i class="fe fe-file-text"></i> <span>Debit Notes</span></a>
						</li> -->
                    <!-- /Purchases -->

                    <!-- Finance & Accounts -->
                    <li class="menu-title"><span>Finance & Accounts</span></li>
                    <li>
                        <a href="#"><i class="fe fe-file-plus"></i> <span>Expenses</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fe fe-credit-card"></i> <span>Payments</span></a>
                    </li>
                    <!-- /Finance & Accounts -->


                    <li class="menu-title"><span>Itineraries</span></li>
                    <li>
                        <a href="#"><i class="fe fe-clipboard"></i> <span>Itineraries</span></a>
                    </li>
                    <!-- <li>
							<a href="delivery-challans.html"><i class="fe fe-file-text"></i> <span>Delivery Challans</span></a>
						</li> -->
                    <!-- /Quotations -->

                    <!-- Reports -->
                    <li class="menu-title"><span>Reports</span></li>
                    <li>
                        <a href="#"><i class="fe fe-credit-card"></i> <span>Payment Summary</span></a>
                    <li class="submenu">
                        <a href="#"><i class="fe fe-box"></i><span>Reports</span> <span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="#">Expense Report</a></li>
                            <!-- <li><a href="purchase-report.html">Purchase Report</a></li>
								   <li><a href="purchase-return.html">Purchase Return Report</a></li> -->
                            <li><a href="#">Sales Report</a></li>
                            <!-- <li><a href="#">Sales Return Report</a></li> -->
                            <li><a href="#">Quotation Report</a></li>
                            <li><a href="#">Payment Report</a></li>
                            <!-- <li><a href="stock-report.html">Stock Report</a></li> -->
                            <!-- <li><a href="low-stock-report.html">Low Stock Report</a></li>
								   <li><a href="income-report.html">Income Report</a></li>
								   <li><a href="tax-purchase.html">Tax Report</a></li> -->
                            <li><a href="#">Profit & Loss</a></li>
                        </ul>
                    </li>
                    </li>
                    <!-- /Reports -->

                    <!-- User Management -->
                    <li class="menu-title"><span>User Management</span></li>
                    <li>
                        <a href="{{url('users')}}"><i class="fe fe-user"></i> <span>Users</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fe fe-clipboard"></i> <span>Roles & Permission</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fe fe-trash-2"></i> <span>Delete Account Request</span></a>
                    </li>
                    <!-- /User Management -->

                    <!-- Membership) -->
                    <!-- <li class="menu-title"><span>Membership</span></li>
						<li class="submenu">
							<a href="#"><i class="fe fe-book"></i> <span> Membership</span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="#">Membership Plans</a></li>
								<li><a href="#">Membership Addons</a></li>
								<li><a href="#">Subscribers</a></li>
								<li><a href="#">Transactions</a></li>
							</ul>
						</li> -->
                    <!-- /Membership) -->

                    <!-- Content (CMS) -->
                    <!-- <li class="menu-title"><span>Content (CMS)</span></li>
						<li>
							<a href="pages.html"><i class="fe fe-folder"></i> <span>Pages</span></a>
						</li>
						<li class="submenu">
							<a href="#"><i class="fe fe-book"></i> <span> Blog</span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="all-blogs.html">All Blogs</a></li>
								<li><a href="categories.html">Categories</a></li>
								<li><a href="blog-comments.html">Blog Comments</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#"><i class="fe fe-map-pin"></i> <span> Location</span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="countries.html">Countries</a></li>
								<li><a href="states.html">States</a></li>
								<li><a href="cities.html">Cities</a></li>
							</ul>
						</li>
						<li>
							<a href="testimonials.html"><i class="fe fe-message-square"></i> <span>Testimonials</span></a>
						</li>
						<li>
							<a href="faq.html"><i class="fe fe-alert-circle"></i> <span>FAQ</span></a>
						</li> -->
                    <!-- /Content (CMS) -->

                    <!-- Support -->
                    <!-- <li class="menu-title"><span>Support</span></li>							
						<li>
							<a href="contact-messages.html"><i class="fe fe-printer"></i> <span>Contact Messages</span></a>
						</li>
						<li class="submenu">
							<a href="#"><i class="fe fe-save"></i> <span> Tickets</span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="tickets.html">Tickets</a></li>
								<li><a href="tickets-list.html">Tickets List</a></li>
								<li><a href="tickets-kanban.html">Tickets Kanban</a></li>
								<li><a href="ticket-details.html">Ticket Overview</a></li>
							</ul>
						</li> -->
                    <!-- /Support -->



                    <!-- Pages -->
                    <!-- <li class="menu-title"><span>Pages</span></li>							
						<li>
							<a href="profile.html"><i class="fe fe-user"></i> <span>Profile</span></a>
						</li>
						<li class="submenu">
							<a href="#"><i class="fe fe-lock"></i> <span> Authentication </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="login.html"> Login </a></li>
								<li><a href="register.html"> Register </a></li>
								<li><a href="forgot-password.html"> Forgot Password </a></li>
								<li><a href="lock-screen.html"> Lock Screen </a></li>
							</ul>
						</li>
						<li>
							<a href="error-404.html"><i class="fe fe-x-square"></i> <span>Error Pages</span></a>
						</li>
						<li>
							<a href="blank-page.html"><i class="fe fe-file"></i> <span>Blank Page</span></a>
						</li>
						<li>
							<a href="maps-vector.html"><i class="fe fe-image"></i> <span>Vector Maps</span></a>
						</li> -->
                    <!-- /Pages -->

                    <!-- UI Interface -->
                    <!-- <li class="menu-title"> 
							<span>UI Interface</span>
						</li> -->
                    <!-- <li class="submenu">
							<a href="#"><i class="fe fe-pocket"></i> <span>Base UI </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="alerts.html">Alerts</a></li>                                    
								<li><a href="accordions.html">Accordions</a></li>
								<li><a href="avatar.html">Avatar</a></li> 
								<li><a href="badges.html">Badges</a></li>
								<li><a href="buttons.html">Buttons</a></li>   
								<li><a href="buttongroup.html">Button Group</a></li>                                  
								<li><a href="breadcrumbs.html">Breadcrumb</a></li>
								<li><a href="cards.html">Cards</a></li>
								<li><a href="carousel.html">Carousel</a></li>                                   
								<li><a href="dropdowns.html">Dropdowns</a></li>
								<li><a href="grid.html">Grid</a></li>
								<li><a href="images.html">Images</a></li>
								<li><a href="lightbox.html">Lightbox</a></li>
								<li><a href="media.html">Media</a></li>                              
								<li><a href="modal.html">Modals</a></li>
								<li><a href="offcanvas.html">Offcanvas</a></li>
								<li><a href="pagination.html">Pagination</a></li>
								<li><a href="popover.html">Popover</a></li>                                    
								<li><a href="progress.html">Progress Bars</a></li>
								<li><a href="placeholders.html">Placeholders</a></li>
								<li><a href="rangeslider.html">Range Slider</a></li>                                    
								<li><a href="spinners.html">Spinner</a></li>
								<li><a href="sweetalerts.html">Sweet Alerts</a></li>
								<li><a href="tab.html">Tabs</a></li>
								<li><a href="toastr.html">Toasts</a></li>
								<li><a href="tooltip.html">Tooltip</a></li>
								<li><a href="typography.html">Typography</a></li>
								<li><a href="video.html">Video</a></li>
							</ul>
						</li> -->
                    <!-- <li class="submenu">
							<a href="#"><i class="fe fe-box"></i> <span>Elements </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="ribbon.html">Ribbon</a></li>
								<li><a href="clipboard.html">Clipboard</a></li>
								<li><a href="drag-drop.html">Drag & Drop</a></li>
								<li><a href="rating.html">Rating</a></li>
								<li><a href="text-editor.html">Text Editor</a></li>
								<li><a href="counter.html">Counter</a></li>
								<li><a href="scrollbar.html">Scrollbar</a></li>
								<li><a href="notification.html">Notification</a></li>
								<li><a href="stickynote.html">Sticky Note</a></li>
								<li><a href="timeline.html">Timeline</a></li>
								<li><a href="horizontal-timeline.html">Horizontal Timeline</a></li>
								<li><a href="form-wizard.html">Form Wizard</a></li>
							</ul>
						</li> -->
                    <!-- <li class="submenu">
							<a href="#"><i class="fe fe-bar-chart"></i> <span> Charts </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="chart-apex.html">Apex Charts</a></li>
								<li><a href="chart-js.html">Chart Js</a></li>
								<li><a href="chart-morris.html">Morris Charts</a></li>
								<li><a href="chart-flot.html">Flot Charts</a></li>
								<li><a href="chart-peity.html">Peity Charts</a></li>
								<li><a href="chart-c3.html">C3 Charts</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#"><i class="fe fe-award"></i> <span> Icons </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="icon-fontawesome.html">Fontawesome Icons</a></li>
								<li><a href="icon-feather.html">Feather Icons</a></li>
								<li><a href="icon-ionic.html">Ionic Icons</a></li>
								<li><a href="icon-material.html">Material Icons</a></li>
								<li><a href="icon-pe7.html">Pe7 Icons</a></li>
								<li><a href="icon-simpleline.html">Simpleline Icons</a></li>
								<li><a href="icon-themify.html">Themify Icons</a></li>
								<li><a href="icon-weather.html">Weather Icons</a></li>
								<li><a href="icon-typicon.html">Typicon Icons</a></li>
								<li><a href="icon-flag.html">Flag Icons</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#"><i class="fe fe-sidebar"></i> <span> Forms </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="form-basic-inputs.html">Basic Inputs </a></li>
								<li><a href="form-input-groups.html">Input Groups </a></li>
								<li><a href="form-horizontal.html">Horizontal Form </a></li>
								<li><a href="form-vertical.html"> Vertical Form </a></li>
								<li><a href="form-mask.html">Form Mask </a></li>
								<li><a href="form-validation.html">Form Validation </a></li>
								<li><a href="form-select2.html">Form Select2 </a></li>
								<li><a href="form-fileupload.html">File Upload </a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#"><i class="fe fe-layout"></i> <span> Tables </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="tables-basic.html">Basic Tables </a></li>
								<li><a href="data-tables.html">Data Table </a></li>
							</ul>
						</li> -->
                    <!-- /UI Interface -->

                    <!-- Settings -->
                    <!-- <li class="menu-title"><span>Settings</span></li>							
						<li>
							<a href="settings.html"><i class="fe fe-settings"></i> <span>Settings</span></a>
						</li>
						<li>
							<a href="login.html"><i class="fe fe-power"></i> <span>Logout</span></a>
						</li> -->

                    <!-- Extras -->
                    <!-- <li class="menu-title"> 
							<span>Extras</span>
						</li>
						<li> 
							<a href="#"><i class="fe fe-file-text"></i> <span>Documentation</span></a>
						</li>
						<li> 
							<a href="javascript:void(0);"><i class="fe fe-lock"></i></i> <span>Change Log</span> <span class="badge badge-primary ms-auto">v2.0</span></a>
						</li>
						<li class="submenu">
							<a href="javascript:void(0);"><i class="fa fa-list"></i> <span>Multi Level</span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li class="submenu">
									<a href="javascript:void(0);"> <span>Level 1</span> <span class="menu-arrow"></span></a>
									<ul style="display: none;" class="level2">
										<li><a href="javascript:void(0);"><span>Level 2</span></a></li>
										<li class="submenu">
											<a href="javascript:void(0);"> <span> Level 2</span> <span class="menu-arrow"></span></a>
											<ul style="display: none;" class="level3">
												<li><a href="javascript:void(0);">Level 3</a></li>
												<li><a href="javascript:void(0);">Level 3</a></li>
											</ul>
										</li>
										<li><a href="javascript:void(0);"> <span>Level 2</span></a></li>
									</ul>
								</li>
								<li>
									<a href="javascript:void(0);"> <span>Level 1</span></a>
								</li>
							</ul>
						</li> -->
                    <!-- Extras -->
                    <li class="submenu">

                        <a href="#"><i class="fe fe-settings"></i> <span>Settings</span><span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="#">Permission</a></li>

                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <!-- /Sidebar -->