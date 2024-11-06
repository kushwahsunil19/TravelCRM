@php
$url = request()->path();
$url = explode('/',$url);
$endurl = end($url);
$url = $_SERVER['REQUEST_URI'];
@endphp
<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="content-page-header">
                <h5>Invoices</h5>
                <div class="list-btn">
                    <ul class="filter-list">
                        
                        <li>
										<a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Filter"><span class="me-2"><img src="{{url('public/assets/img/icons/filter-icon.svg')}}" alt="filter"></span>Filter </a>
									</li>
									
                                   <li>
                                <div class="dropdown dropdown-action" data-bs-toggle="tooltip"
                                     data-bs-placement="bottom" title="Download">
                                    <a href="#" class="btn-filters" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span><i class="fe fe-download"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                    
                                   <ul>

        <li>
            <a class="d-flex align-items-center download-item" href="{{ route('invoice.downloadPDF', request()->query() )}}">
                <i class="far fa-file-pdf me-2"></i> PDF
            </a>
        </li>
        <li>
            <a class="d-flex align-items-center download-item" href="{{ route('invoices.downloadCSV', request()->query() )}}">
                <i class="far fa-file-pdf me-2"></i> CSV
            </a>
        </li>


</ul>



 


                    <li>
                            <a class="btn btn-primary" href="{{route('invoices.create')}}"><i
                                    class="fa fa-plus-circle me-2" aria-hidden="true"></i>New Invoice</a>
                        </li>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <!-- <div id="filter_inputs" class="card filter-card">
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
        </div> -->
        <!-- /Search Filter -->
        @php
          $total_invoice_amt = 0;
          $total_outstanding_amt = 0;
          $total_overdue_amt = 0;
          $total_cancelled_amt = 0;
          $total_drapt_amt = 0;
          $total_recurring_amt = 0;
          $symbol =  '₹';
        @endphp  
        @foreach ($invoices as $invoice)
            @php
            $symbol = isset($invoice->currency->symbol) ?
            $invoice->currency->symbol : '₹';
            $package_amt = $invoice->package->amount;
            // GST Tax in percentage
            $tax = $invoice->vat;
            // Discount in percentage
            $discount = $invoice->discount;
            // Calculate discount amount (discount percentage applied to the package amount)
            if($invoice->discount_type=='Fixed'){
            $discount_amt = $discount;
            }else{
            $discount_amt = ($package_amt * $discount) / 100;
            }
            // Amount after discount
            $amount_after_discount = $package_amt - $discount_amt;
            $tax_amt = ($amount_after_discount * $tax) / 100;
            $total_invoice_amt += $amount_after_discount + $tax_amt;
            @endphp              
        @endforeach
        <!-- Inovices card -->
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12 d-flex">
                <div class="card inovices-card w-100">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="inovices-widget-icon bg-info-light">
                                <img src="{{url('public/assets/img/icons/receipt-item.svg')}}" alt="invoice">
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Total Invoice</div>
                                <div class="dash-counts">
                                    <p>{{number_format($total_invoice_amt,2)}}</p>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="d-flex justify-content-between align-items-center">
                            <p class="inovices-all">No of Invoice <span class="rounded-circle bg-light-gray">02</span>
                            </p>
                            <p class="inovice-trending text-success-light">02 <span class="ms-2"><i
                                        class="fe fe-trending-up"></i></span></p>
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- <div class="col-xl-3 col-lg-4 col-sm-6 col-12 d-flex">
                <div class="card inovices-card w-100">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="inovices-widget-icon bg-primary-light">
                                <img src="{{url('public/assets/img/icons/transaction-minus.svg')}}" alt="invoice">

                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Outstanding</div>
                                <div class="dash-counts">
                                    <p>{{ number_format($total_outstanding_amt, 2) }}</p>
                                </div>
                            </div>
                        </div>
                         <div class="d-flex justify-content-between align-items-center">
                            <p class="inovices-all">No of Invoice <span class="rounded-circle bg-light-gray">03</span>
                            </p>
                            <p class="inovice-trending text-success-light">04 <span class="ms-2"><i
                                        class="fe fe-trending-up"></i></span></p>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12 d-flex">
                <div class="card inovices-card w-100">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="inovices-widget-icon bg-warning-light">
                                <img src="{{url('public/assets/img/icons/archive-book.svg')}}" alt="invoice">

                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Total Overdue</div>
                                <div class="dash-counts">
                                    <p>{{number_format($total_overdue_amt,2)}}</p>
                                </div>
                            </div>
                        </div>
                         <div class="d-flex justify-content-between align-items-center">
                            <p class="inovices-all">No of Invoice <span class="rounded-circle bg-light-gray">01</span>
                            </p>
                            <p class="inovice-trending text-danger-light">03 <span class="ms-2"><i
                                        class="fe fe-trending-down"></i></span></p>
                        </div> 
                    </div>
                </div>
            </div> -->
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12 d-flex">
                <div class="card inovices-card w-100">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="inovices-widget-icon bg-primary-light">
                                <img src="{{url('public/assets/img/icons/clipboard-close.svg')}}" alt="invoice">


                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Cancelled</div>
                                <div class="dash-counts">
                                    <p>{{$total_cancelled_amt}}</p>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="d-flex justify-content-between align-items-center">
                            <p class="inovices-all">No of Invoice <span class="rounded-circle bg-light-gray">04</span>
                            </p>
                            <p class="inovice-trending text-danger-light">05 <span class="ms-2"><i
                                        class="fe fe-trending-down"></i></span></p>
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- <div class="col-xl-2 col-lg-4 col-sm-6 col-12 d-flex">
                <div class="card inovices-card w-100">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="inovices-widget-icon bg-green-light">
                                <img src="{{url('public/assets/img/icons/message-edit.svg')}}" alt="invoice">
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Draft</div>
                                <div class="dash-counts">
                                    <p>{{$symbol}}{{$total_drapt_amt}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="inovices-all">No of Invoice <span class="rounded-circle bg-light-gray">06</span>
                            </p>
                            <p class="inovice-trending text-danger-light">02 <span class="ms-2"><i
                                        class="fe fe-trending-down"></i></span></p>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-xl-2 col-lg-4 col-sm-6 col-12 d-flex">
                <div class="card inovices-card w-100">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="inovices-widget-icon bg-danger-light">
                                <img src="{{url('public/assets/img/icons/3d-rotate.svg')}}" alt="invoice">

                            </span>
                            <div class="dash-count">
                                <div class="dash-title">Recurring</div>
                                <div class="dash-counts">
                                    <p>{{$symbol}}{{ $total_recurring_amt}}</p>
                                </div>
                            </div>
                        </div>
                         <div class="d-flex justify-content-between align-items-center">
                            <p class="inovices-all">No of Invoice <span class="rounded-circle bg-light-gray">03</span>
                            </p>
                            <p class="inovice-trending text-success-light">02 <span class="ms-2"><i
                                        class="fe fe-trending-up"></i></span></p>
                        </div>>
                    </div>
                </div>
            </div> -->
        </div>
        <!-- /Inovices card -->
        <!-- All Invoice -->
        <div class="card invoices-tabs-card">
            <div class="invoices-main-tabs">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="invoices-tabs">
                            <ul>
                                <li><a href="{{route('invoices.index')}}"
                                        class="{{($endurl=='invoices') ? 'active' : '' }}">All</a></li>
                                <li><a href="{{route('invoices.invoices-paid')}}"
                                        class="{{strpos($url,'invoices-paid') !== false ? 'active' : '' }}">Paid</a>
                                </li>
                                <!-- <li><a href="{{route('invoices.invoices-overdue')}}"
                                        class="{{strpos($url,'invoices-overdue') !== false ? 'active' : '' }}">Overdue</a>
                                </li>
                                <li><a href="{{route('invoices.invoices-cancelled')}}"
                                        class="{{strpos($url,'invoices-cancelled') !== false ? 'active' : '' }}">Cancelled</a>
                                </li>
                                <li><a href="{{route('invoices.invoices-recurring')}}"
                                        class="{{strpos($url,'invoices-recurring') !== false ? 'active' : '' }}">Partially
                                        Paid</a></li>
                                <li><a href="{{route('invoices.invoices-unpaid')}}"
                                        class="{{strpos($url,'invoices-unpaid') !== false ? 'active' : '' }}">Unpaid</a>
                                </li>
                                <li><a href="{{route('invoices.invoices-refunded')}}"
                                        class="{{strpos($url,'invoices-refunded') !== false ? 'active' : '' }}">Refunded</a>
                                </li>
                                <li><a href="{{route('invoices.invoices-draft')}}"
                                        class="{{strpos($url,'invoices-draft') !== false ? 'active' : '' }}">Draft</a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /All Invoice -->
        <!-- Table -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-center table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>S.No </th>
                                        <th>invoice No</th>
                                        <th>Branch</th>
                                        <th>Package</th>
                                        <th>Invoice To</th>
                                        <th>Discount Type</th>
                                        <th>Discount</th>
                                        <th>Vat</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($invoices as $invoice)

                                    @php
                                    $symbol = isset($invoice->currency->symbol) ?
                                    $invoice->currency->symbol : '₹';
                                    $package_amt = $invoice->package->amount;
                                    // GST Tax in percentage
                                    $tax = $invoice->vat;
                                    // Discount in percentage
                                    $discount = $invoice->discount;
                                    // Calculate discount amount (discount percentage applied to the package amount)
                                    if($invoice->discount_type=='Fixed'){
                                    $discount_amt = $discount;
                                    }else{
                                    $discount_amt = ($package_amt * $discount) / 100;
                                    }
                                    // Amount after discount
                                    $amount_after_discount = $package_amt - $discount_amt;
                                    $tax_amt = ($amount_after_discount * $tax) / 100;
                                    $total_amt = $amount_after_discount + $tax_amt;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td> <!-- Serial number -->
                                        <td>{{ $invoice->invoice_no }}</td>
                                        <td>{{ ($invoice->branch->city)?$invoice->branch->city:'' }}</td>
                                        <td>{{ isset($invoice->package->package_name)?$invoice->package->package_name:'' }}
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                @php
                                                $avatar = $invoice->partner->image ? url('public/profile/' .
                                                $invoice->partner->image) :
                                                url('public/assets/img/profiles/default.png');
                                                @endphp
                                                <a href="" class="avatar avatar-md me-2"><img
                                                        class="avatar-img rounded-circle" src="{{$avatar}}"
                                                        alt="User Image"></a>
                                                <a href="">{{$invoice->partner->name }} <span><span class="__cf_email__"
                                                            data-cfemail="c5b5b7aca6aca9a9a485a0bda4a8b5a9a0eba6aaa8">[{{ $invoice->partner->email }}]</span></span></a>
                                        </td>

                                        <td>{{ $invoice->discount_type }}</td>
                                        <td>{{ $invoice->discount }}{{ ($invoice->discount_type=='Fixed')?'':'%'}}
                                        </td>
                                        <td>{{ $invoice->vat }}%</td>
                                        <td>{{$symbol}}{{ number_format($total_amt, 2) }}</td>
                                        <td>

                                            <div class="dropdown dropdown-action">
                                                <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown"
                                                    aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul>

                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('invoices.edit', $invoice->id) }}"><i
                                                                    class="far fa-edit me-2"></i>Edit</a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete_modal{{$invoice->id}}"><i
                                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                                        </li>

                                                        <li>
                                                            <form method="GET"
                                                                action="{{ route('invoice.estimate', $invoice->id) }}">
                                                                <button type="submit" class="dropdown-item"><i
                                                                        class="fe fe-download me-2"></i>Invoice</button>
                                                            </form>
                                                            <!-- <a class="dropdown-item" href="javascript:void(0);"><i
                                                                    class="fe fe-download me-2"></i>Download</a> -->
                                                        </li>

                                                        <!-- <li>
																		<a class="dropdown-item" href="{{ route('invoices.show', $invoice->id) }}"><i class="far fa-eye me-2"></i>View</a>
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
                                            <div class="modal custom-modal fade" id="delete_modal{{$invoice->id}}"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="form-header">
                                                                <h3>Delete invoice</h3>
                                                                <p>Are you sure want to delete?</p>
                                                            </div>
                                                            <div class="modal-btn delete-action">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <form
                                                                            action="{{ route('invoices.destroy', $invoice->id) }}"
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
                                        <td colspan="9" class="text-center">No invoices found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Table -->

    </div>
</div>
<!-- /Page Wrapper -->