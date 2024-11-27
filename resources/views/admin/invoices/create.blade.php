@extends('admin.layouts.master')
@section('content')


<!-- Main Wrapper -->
@include('admin.layouts.common-sidebar')

<!-- /Main Wrapper -->
<style>
.description-cell p {
    word-wrap: break-word !important;
    /* Ensure long words break */
    overflow-wrap: break-word !important;
    /* Ensure long words break */
    white-space: normal !important;
    /* Allow text to wrap naturally */
    max-width: 300px !important;
    text-align: justify !important;
    /* Optional: Limit the width of the cell */
}

.description-cell2 {
    word-wrap: break-word !important;
    /* Ensure long words break */
    overflow-wrap: break-word !important;
    /* Ensure long words break */
    white-space: normal !important;
    /* Allow text to wrap naturally */
    max-width: 300px !important;
    text-align: justify !important;
    /* Optional: Limit the width of the cell */
}

td {
    vertical-align: top;
    /* Align the content to the top of the cell */
}
</style>
<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="card mb-0">
            <div class="card-body">
                <div class="page-header">
                    <div class="content-page-header">
                        <h5>Create Invoice</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="quotation-card">
                            <form action="{{ route('invoices.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="input-block mb-3">
                                            <!-- <div class="mb-2">
                                                <label>Document Title</label>
                                            </div> -->
                                            <!-- <label class="custom_check me-3 mb-0">
                                            <input type="checkbox" name="invoice">
                                            <span class="checkmark"></span> Quotation
                                        </label>
                                        <label class="custom_check mb-0">
                                            <input type="checkbox" name="re_invoice">
                                            <span class="checkmark"></span> Estimate
                                        </label> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-item border-0 mb-0">
                                    <div class="row align-item-center">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="input-block mb-3">
                                                <label>Invoice No</label>
                                                <input type="number" class="form-control" name="invoice_no"
                                                    placeholder="" value="{{ $invoice_no}}" readonly>
                                                @if ($errors->has('invoice_no'))
                                                <span class="text-danger">{{ $errors->first('invoice_no') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="input-block mb-3">
                                                <label>Booking Reffrence No.</label>
                                                <input type="number" class="form-control" name="booking_reference_no"
                                                    placeholder="Enter Booking Reffrence No" value="{{ old('booking_reference_no')}}"
                                                    min="0" required>
                                                @if ($errors->has('booking_reference_no'))
                                                <span class="text-danger">{{ $errors->first('booking_reference_no') }}</span>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="input-block mb-3">
                                                <label> Branch</label>
                                                <ul class="form-group-plus css-equal-heights">
                                                    <li>
                                                        <select class="select" name="branch_id" id="branch_id" required>
                                                            <option value="">Select Branch</option>
                                                            @foreach ($branches as $branch)
                                                            <option value="{{ $branch->id }}"
                                                                {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                                {{ $branch->city }}
                                                            </option>
                                                            @endforeach
                                                        </select>

                                                    </li>
                                                    <li>
                                                        <a class="btn btn-primary form-plus-btn" href="#"
                                                            data-bs-toggle="modal" data-bs-target="#branch_details"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                        <!-- <a class="btn btn-primary form-plus-btn"
                                                            href="{{route('branches.create')}}"><i
                                                                class="fas fa-plus-circle"></i></a> -->
                                                    </li>

                                                </ul>
                                                @if ($errors->has('branch_id'))
                                                <span class="text-danger">{{ $errors->first('branch_id') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="input-block mb-3">
                                                <label> Partner</label>
                                                <ul class="form-group-plus css-equal-heights">
                                                    <li>
                                                        <select class="select" name="partner_id" id="partner_id"
                                                            required>
                                                            <option value="">Select Partner </option>
                                                            @foreach ($partners as $partner)
                                                            <option value="{{ $partner->id }}"
                                                                {{ old('partner_id') == $partner->id ? 'selected' : '' }}>
                                                                {{ $partner->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <a class="btn btn-primary form-plus-btn" href="#"
                                                            data-bs-toggle="modal" data-bs-target="#partner_details"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                        <!-- <a class="btn btn-primary form-plus-btn"
                                                            href="{{route('partners.create')}}"><i
                                                                class="fas fa-plus-circle"></i></a> -->
                                                    </li>
                                                </ul>
                                                @if ($errors->has('partner_id'))
                                                <span class="text-danger">{{ $errors->first('partner_id') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                      
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="input-block mb-3">
                                                <label>No. of Night</label>
                                                <input type="number" class="form-control" name="no_of_night"
                                                    placeholder="Enter No. of Night" value="{{ old('no_of_night')}}"  min="0">
                                                @if ($errors->has('no_of_night'))
                                                <span class="text-danger">{{ $errors->first('no_of_night') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="input-block mb-3">
                                                <label>No. of Passenger</label>
                                                <input type="number" class="form-control" name="no_of_passenger"
                                                    placeholder="Enter No. of Passenger" value="{{ old('no_of_passenger')}}"  min="0">
                                                @if ($errors->has('no_of_passenger'))
                                                <span class="text-danger">{{ $errors->first('no_of_passenger') }}</span>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="input-block mb-3">
                                                <label>Supplier</label>
                                                
                                                <select class="form-select @error('supplier') is-invalid @enderror"
                                                    multiple aria-label="supplier" id="suppliers"
                                                    name="supplier[]" style="height: 210px;">

                                                    @forelse ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}"
                                                        {{ in_array($supplier->id, old('supplier') ?? []) ? 'selected' : '' }}>
                                                        {{ $supplier->name }}
                                                    </option>
                                                    @empty

                                                    @endforelse
                                                </select>
                                                @if ($errors->has('supplier'))
                                                <span class="text-danger">{{ $errors->first('supplier') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-6 col-sm-12">
                                            <div class="input-block mb-3">
                                                <label> Package</label>
                                                <ul class="form-group-plus css-equal-heights">
                                                    <li>
                                                        <select class="select" name="package_id" id="package_id"
                                                            required>
                                                            <option value="">Select package </option>
                                                            @foreach ($packages as $package)
                                                            <option value="{{ $package->id }}"
                                                                {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                                                {{ $package->package_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <a class="btn btn-primary form-plus-btn" href="#"
                                                            data-bs-toggle="modal" data-bs-target="#package_details"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                        <!-- <a class="btn btn-primary form-plus-btn"
                                                            href="{{route('packages.create')}}"><i
                                                                class="fas fa-plus-circle"></i></a> -->
                                                    </li>
                                                </ul>
                                                @if ($errors->has('package_id'))
                                                <span class="text-danger">{{ $errors->first('package_id') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="form-group-item">
                                    <div class="card-table">
                                        <div class="card-body">
                                            <div class="table-responsive itme_table no-pagination">
                                                <table class="table">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Package Name</th>
                                                            <th>Discription</th>
                                                            <th>Amount</th>
                                                            <th>Net Amount</th>
                                                            <th class="no-sort">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="packageBody">
                                                        <tr class="odd">
                                                            <td valign="top" colspan="5" class="dataTables_empty"
                                                                style="text-align:center;">No data available in table
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                        <div class="col-lg-3">
                                                <div class="input-block mb-3">
                                                    <label>Currency</label>
                                                    <select class="select" name="currency_id" id="currency_id" onchange="updateCurrencyRate(this)" required>
                                                        <option value="">Select Currency </option>
                                                        @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}"  data-code="{{$currency->code}}"
                                                            data-symbol="{{$currency->symbol}}"
                                                            {{ old('currency_id') == $currency->id ? 'selected' : '' }}>
                                                            {{ $currency->code }}
                                                        </option>
                                                        @endforeach
                                                    </select>

                                                    @if ($errors->has('currency_id'))
                                                    <span class="text-danger">{{ $errors->first('currency_id') }}</span>
                                                    @endif
                                                    <input type="hidden" id="currency_symbol" value="₹">
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-block mb-2">
                                                    <label>Currency Rate </label>
                                                    <input type="number" class="form-control currency_rate"
                                                        name="currency_rate" id="currency_rate" placeholder="Enter Rate"
                                                        min="0" step="any" value="0.00" readonly>
                                                    @if ($errors->has('currency_rate'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('currency_rate') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <script>
                                                const baseCurrency = 'USD';
                                                const apiKey = 'db45eeefc8d49d0b5b537e69';
                                                const apiUrl = `https://v6.exchangerate-api.com/v6/${apiKey}/latest/${baseCurrency}`;
                                                const currencyRateInput = document.getElementById('currency_rate');

                                                async function updateCurrencyRate(selectElement) {
                                                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                                                    const targetCurrency = selectedOption.getAttribute('data-code');

                                                    if (!targetCurrency) {
                                                        currencyRateInput.value = "0.00";
                                                        console.log('No currency selected');
                                                        return;
                                                    }

                                                    try {
                                                        const response = await fetch(apiUrl);

                                                        if (!response.ok) {
                                                            console.error('API response not OK. Status:', response.status);
                                                            currencyRateInput.value = "0.00";
                                                            return;
                                                        }

                                                        const data = await response.json();

                                                        if (data.result === "success") {
                                                            const conversionRate = data.conversion_rates[targetCurrency];

                                                            if (conversionRate) {
                                                                currencyRateInput.value = conversionRate.toFixed(2); // Update input with conversion rate
                                                                console.log(`1 ${baseCurrency} = ${conversionRate.toFixed(2)} ${targetCurrency}`);
                                                            } else {
                                                                console.warn(`No conversion rate found for ${targetCurrency}`);
                                                                currencyRateInput.value = "0.00";
                                                            }
                                                        } else {
                                                            console.error('Invalid API response:', data);
                                                            currencyRateInput.value = "0.00";
                                                        }
                                                    } catch (error) {
                                                        console.error('Error fetching currency rate:', error);
                                                        currencyRateInput.value = "0.00";
                                                    }
                                                }
                                            </script>
                                            <div class="col-lg-3">
                                                <div class="input-block mb-3">
                                                    <label>Discount Type</label>
                                                    <select class="select" name="discount_type" id="discount_type">
                                                        <option value="">Select Discount Type </option>
                                                        <option value="Percentage">Percentage(%)</option>
                                                        <option value="Fixed">Fixed</option>
                                                    </select>
                                                    @if ($errors->has('vat'))
                                                    <span class="text-danger">{{ $errors->first('discount_type') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-block mb-2">
                                                    <label>Discount </label>
                                                    <input type="number" class="form-control discount" name="discount"
                                                        placeholder="Enter Discount" min="0" step="any" value="0.00">
                                                    @if ($errors->has('discount'))
                                                    <span class="text-danger">{{ $errors->first('discount') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-block mb-2">
                                                    <div class="input-block mb-2">
                                                        <label>Vat</label>
                                                        <input type="number" class="form-control vat" name="vat"
                                                            placeholder="Enter Vat" min="0" step="any" value="0.00">
                                                        <!-- <select class="select" name="vat" id="vat">
                                                            <option value="21">IVA - (21%)</option>
                                                            <option value="15">IRPF - (-15%)</option>
                                                            <option value="20">PDV - (20%)</option>
                                                        </select> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4"></div>
                                </div>
                                <div class="form-group-item border-0 p-0">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <div class="form-group-bank">
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <div class="input-block mb-3">
                                                            <label>Select Bank</label>
                                                            <select class="select" id="bank_id" name="bank_id">
                                                                <option value="">Select Bank</option>
                                                                @foreach($bankDetails as $res)
                                                                <option value="{{ $res->id}}">{{  $res->bank_name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-groups">
                                                            <a class="btn btn-primary" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#bank_details">Add Bank</a>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('bank_id'))
                                                    <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                                                    @endif
                                                </div>

                                                <div class="input-block mb-3 notes-form-group-info">
                                                    <label>Notes</label>
                                                    <textarea class="form-control" placeholder="Enter Notes"
                                                        name="note"></textarea>
                                                </div>
                                                <div class="input-block mb-3 notes-form-group-info mb-0">
                                                    <label>Terms and Conditions</label>
                                                    <textarea class="form-control"
                                                        placeholder="Enter Terms and Conditions"
                                                        name="term_condition"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <div class="form-group-bank">
                                                <div class="invoice-total-box">
                                                    <div class="invoice-total-inner">
                                                        <p>Package Amount <span class="amount">$0.00</span></p>
                                                        <input type="hidden" id="package_amt" value="0">
                                                        <p>Discount <span class="discount">$0.00</span></p>
                                                        <input type="hidden" id="discount" value="0">
                                                        <p>Vat <span class="vat">$0.00</span></p>
                                                        <input type="hidden" id="vat" value="0">
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
                                                    <div class="input-block service-upload service-upload-info mb-0">
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
                                <div class="text-end">
                                    <a href="{{route('invoices.index')}}" class="btn customer-btn-cancel">Cancel</a>
                                    <button type="submit" class="btn btn-primary  customer-btn-save">Create</button>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /Page Wrapper -->

<!-- Add vat & Discount Modal -->
<div class="modal custom-modal fade" id="add_discount" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="form-header modal-header-title text-start mb-0">
                    <h4 class="mb-0">Add vat & Discount</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="input-block mb-3">
                            <label>Rate</label>
                            <input type="number" class="form-control" placeholder="120">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="input-block mb-3">
                            <label>Discount Amount</label>
                            <input type="number" class="form-control" placeholder="0">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="input-block mb-0">
                            <label>vat</label>
                            <select class="select">
                                <option>N/A</option>
                                <option>5%</option>
                                <option>10%</option>
                                <option>15%</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn me-2">Back</a>
                <a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Save</a>
            </div>
        </div>
    </div>
</div>
<!-- /Add vat & Discount Modal -->

<!-- Delete Items Modal -->
<div class="modal custom-modal  fade" id="delete_discount" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Products</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Delete</a>
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


<!-- Add brach_detail Modal -->
<div class="modal custom-modal modal-lg fade" id="branch_details" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="form-header modal-header-title text-start mb-0">
                    <h4 class="mb-0">Add Branch Details</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="branch_details_form" action="{{ route('branches.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- Include CSRF token for security -->
                    <div class="row">
                        <div class="col-lg-12 col-md-6">
                            <div class="input-block mb-3">
                                <label>Branch Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="branch_name" placeholder="Enter Name">
                                @if ($errors->has('branch_name'))
                                <span class="text-danger">{{ $errors->first('branch_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="input-block mb-3">
                                <label>City</label>
                                <input type="text" class="form-control" name="city" placeholder="Enter City">
                                @if ($errors->has('city'))
                                <span class="text-danger">{{ $errors->first('city') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="input-block mb-3">
                                <label>Address</label>
                                <textarea class="form-control" name="address"></textarea>
                                @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-primary cancel me-2">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add brach_detail Modal -->
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
                                    <label>Country <span class="text-danger">*</span></label>
                                    <select id="country" class="form-control" name="country_id">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country'))
                                        <span class="text-danger">{{ $errors->first('country') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- State Dropdown -->
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>State <span class="text-danger">*</span></label>
                                    <select id="state_id" class="form-control" name="state_id">
                                        <option value="">Select State</option>
                                    </select>
                                    @if ($errors->has('state'))
                                        <span class="text-danger">{{ $errors->first('state') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- City Dropdown -->
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label>City <span class="text-danger">*</span></label>
                                    <select id="city_id" class="form-control" name="city_id">
                                        <option value="">Select City</option>
                                    </select>
                                    @if ($errors->has('city'))
                                        <span class="text-danger">{{ $errors->first('city') }}</span>
                                    @endif
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


<!-- Add Package Details Modal -->
<div class="modal custom-modal modal-lg fade" id="package_details" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="form-header modal-header-title text-start mb-0">
                    <h4 class="mb-0">Add Package Details</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="package_details_form" action="{{ route('packages.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- Include CSRF token for security -->
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label>Package Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="package_name"
                                    placeholder="Enter Package Name">
                                @if ($errors->has('package_name'))
                                <span class="text-danger">{{ $errors->first('package_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label>Amount</label>
                                <input type="text" class="form-control" name="amount" placeholder="Enter Amount">
                                @if ($errors->has('amount'))
                                <span class="text-danger">{{ $errors->first('amount') }}</span>
                                @endif
                            </div>
                        </div>
                         <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label>Net Amount</label>
                                <input type="number" class="form-control"  name="net_amount"
                                    placeholder="Enter Net Amount" min="0"
                                    step="any">
                                @if ($errors->has('net_amount'))
                                <span class="text-danger">{{ $errors->first('net_amount') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="input-block mb-3">
                                <label>Description</label>
                                <textarea class="form-control" name="description" id="description"></textarea>

                                @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
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
<!-- /Add package Details Modal -->
<!-- edit Package Details Modal -->
<div class="modal custom-modal modal-lg fade" id="edit_package_details" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="form-header modal-header-title text-start mb-0">
                    <h4 class="mb-0">Edit Package Details</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit_package_details_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Spoofing PUT for update -->
                    <input type="hidden" name="package_id" id="pkg_id"> <!-- Hidden field for user ID -->
                    <!-- Include CSRF token for security -->
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label>Package Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="package_name" id="edit_package_name"
                                    placeholder="Enter Package Name">
                                @if ($errors->has('package_name'))
                                <span class="text-danger">{{ $errors->first('package_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label>Amount</label>
                                <input type="text" class="form-control" id="edit_package_amt" name="amount"
                                    placeholder="Enter Amount">
                                @if ($errors->has('amount'))
                                <span class="text-danger">{{ $errors->first('amount') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label>Net Amount</label>
                                <input type="number" class="form-control" id="edit_package_net_amt" name="net_amount"
                                    placeholder="Enter Net Amount" min="0"
                                    step="any">
                                @if ($errors->has('net_amount'))
                                <span class="text-danger">{{ $errors->first('net_amount') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="input-block mb-3">
                                <label>Description</label>
                                <textarea class="form-control" name="description" id="description_edit"></textarea>

                                @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
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
<!-- /edit package Details Modal -->

<!-- Add Bank Details Modal -->
<div class="modal custom-modal fade" id="bank_details" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="form-header modal-header-title text-start mb-0">
                    <h4 class="mb-0">Add Bank Details</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bank_details_form" action="{{ route('bank-details.add') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- Include CSRF token for security -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="input-block mb-3">
                                <label>Bank Name <span class="text-danger">*</span></label>
                                <input type="text" name="bank_name" class="form-control" placeholder="Enter Bank Name">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="input-block mb-3">
                                <label>Account Number <span class="text-danger">*</span></label>
                                <input type="number" name="account_no" class="form-control"
                                    placeholder="Enter Account Number">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="input-block mb-3">
                                <label>Branch Name <span class="text-danger">*</span></label>
                                <input type="text" name="branch_name" class="form-control"
                                    placeholder="Enter Branch Name">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 iban_no">
                            <div class="input-block mb-3">
                                <label>IBAN No <span class="text-danger"></span></label>
                                <input type="text" name="iban_no" id="iban_no" class="form-control"
                                    placeholder="Enter IBAN No">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="input-block mb-0">
                                <label for="ifsc_code">IFSC Code <span class="text-danger">*</span></label>
                                <input type="text" name="ifsc_code" id="ifsc_code" class="form-control"
                                    placeholder="Enter IFSC Code">
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-primary cancel me-2">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Bank Details Modal -->
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

                <div id="layout-position d-none">
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

<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
$(document).ready(function() {
    $('#suppliers').select2({
        placeholder: "Select Supliers",
        allowClear: true
    });

});
</script>
<script>
$(document).ready(function() {
    CKEDITOR.replace('description');
    CKEDITOR.replace('description_edit');
});
</script>
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



    $('#bank_details_form').on('submit', function(e) {
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
                $('#bank_details').modal('hide'); // Close modal
                $('#bank_details_form')[0].reset(); // Reset the form
                // Populate the select box with the latest bank details
                var bankSelect = $('#bank_id');
                bankSelect.empty(); // Clear the existing options
                bankSelect.append(
                    '<option value="">Select Bank</option>'); // Add default option

                // Loop through the returned bank data and append to select box
                $.each(response.data, function(index, bank) {
                    bankSelect.append('<option value="' + bank.id + '">' + bank
                        .bank_name + '</option>');
                });

                // Refresh the select2 dropdown (if using select2)
                bankSelect.trigger('change');


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

    $('#branch_details_form').on('submit', function(e) {
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
                $('#branch_details').modal('hide'); // Close modal
                $('#branch_details_form')[0].reset(); // Reset the form
                // Populate the select box with the latest bank details
                var branchSelect = $('#branch_id');
                branchSelect.empty(); // Clear the existing options
                branchSelect.append(
                    '<option value="">Select Branch</option>'); // Add default option

                // Loop through the returned bank data and append to select box
                $.each(response.data, function(index, branch) {
                    branchSelect.append('<option value="' + branch.id + '">' +
                        branch
                        .branch_name + '</option>');
                });

                // Refresh the select2 dropdown (if using select2)
                branchSelect.trigger('change');


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
                $('#partner_details').modal('hide'); // Close modal
                $('#partner_details_form')[0].reset(); // Reset the form
                // Populate the select box with the latest bank details
                var partnerSelect = $('#partner_id');
                partnerSelect.empty(); // Clear the existing options
                partnerSelect.append(
                    '<option value="">Select Partner</option>'); // Add default option

                // Loop through the returned bank data and append to select box
                $.each(response.data, function(index, partner) {
                    partnerSelect.append('<option value="' + partner.id + '">' +
                        partner
                        .name + '</option>');
                });

                // Refresh the select2 dropdown (if using select2)
                partnerSelect.trigger('change');


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
    // add package
    $('#package_details_form').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
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
                $('#package_details').modal('hide'); // Close modal
                $('#package_details_form')[0].reset(); // Reset the form
                // Populate the select box with the latest bank details
                var packageSelect = $('#package_id');
                packageSelect.empty(); // Clear the existing options
                packageSelect.append(
                    '<option value="">Select Package</option>'); // Add default option

                // Loop through the returned bank data and append to select box
                $.each(response.data, function(index, package) {
                    packageSelect.append('<option value="' + package.id + '">' +
                        package
                        .package_name + '</option>');
                });

                // Refresh the select2 dropdown (if using select2)
                packageSelect.trigger('change');


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
    // onchange Symbol
    function updateSymbol() {
        var selectedOption = $('#currency_id option:selected'); // Get selected option
        var symbol = selectedOption.data('symbol'); // Get symbol from the data attribute

        if (!symbol) {
            symbol = '₹'; // Default to ₹ symbol if none selected
        }
        // Update all relevant fields with the new symbol

        var discount_type = $('#discount_type').val();
        var package_amt = $('#package_amt').val(); // Default to 0 if not a number
        var discount = $('.discount').val();
        var vat = $('.vat').val();
        $('#currency_symbol').val(symbol);
        calculation(package_amt, vat, discount, discount_type, symbol);

    }
    // Call the function on page load in case a currency is already selected
    updateSymbol();
    // Update symbol when the selection changes
    $('#currency_id').on('change', updateSymbol);
    // Symbol end

    $(document).on('click', '.edit_package', function() {
        var id = $(this).data('id'); // Get user ID from the button

        // Make an AJAX request to fetch the user data
        $.ajax({
            url: '{{ route("packages.edit", ":id") }}'.replace(':id',
                id), // Replace ':id' with the actual user ID
            type: 'GET',
            success: function(response) {
                var data = response.data;

                // Populate the form fields with the fetched data
                $('#pkg_id').val(data.id); // Hidden user ID
                $('#edit_package_name').val(data.package_name);
                $('#edit_package_amt').val(data.amount);
                $('#edit_package_net_amt').val(data.net_amount);
                $('#description_edit').val(data.description);
                if (CKEDITOR.instances['description_edit']) {
                    CKEDITOR.instances['description_edit'].setData(data.description);
                }
                // Open the modal
                $('#edit_package_details').modal('show');
            },
            error: function(xhr) {
                toastr.error('Error fetching user data.');
            }
        });
    });

    // Edit package
    $('#edit_package_details_form').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        var formData = new FormData(this); // FormData for file uploads
        var id = $('#pkg_id').val(); // Get user ID from hidden input
        $.ajax({
            url: '{{ route("packages.update", ":id") }}'.replace(':id', id), // Update route
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
                const tableBody = $('#packageBody');
                tableBody.empty(); // Clear existing rows
                var discount = $('.discount').val();
                var vat = $('.vat').val();
                var discount_type = $('#discount_type').val();
                var symbol = $('#currency_symbol').val();
                calculation(response.data.amount, vat, discount, discount_type,
                    symbol);
                // Ensure that the response contains the expected fields
                const packageData = response.data;

                // Create a new row with package details
                const newRow = `
                        <tr>
                            <td>${packageData.package_name }</td> <!-- Package Name -->
                            <td  class="description-cell">${packageData.description }</td> <!-- Description -->
                            <td>${packageData.amount }</td> <!-- Amount -->
                            <td>${packageData.net_amount }</td> <!-- Amount -->
                           <td class="d-flex align-items-center">
                                <!-- Edit button that calls the 'packages.edit' route -->
                                <a  class="btn-action-icon me-2">
                                    <span><i data-id="${packageData.id }" class="fe fe-edit edit_package"></i></span>
                                </a>
                            </td>
                        </tr>
                    `;

                // Append the new row to the table body
                tableBody.append(newRow);
                $('#edit_package_details').modal('hide'); // Close modal after success

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


    $(document).on('change', '#package_id', function() {
        var packageId = $(this).val();
        // Clear the existing table body
        const tableBody = $('#packageBody');
        tableBody.empty(); // Clear existing rows
        if (packageId) {
            $.ajax({
                url: '{{ route("packages.details", ":id") }}'.replace(':id', packageId),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response); // Log the response for debugging

                    if (response.success) {
                        // Update package amounts
                        // $('.amount').text('$' + response.data.amount);
                        $('#package_amt').val(response.data.amount);
                        // $('.total_amt').text('$' + response.data.amount);



                        // Ensure that the response contains the expected fields
                        const packageData = response.data;

                        // Create a new row with package details
                        const newRow = `
                        <tr>
                            <td>${packageData.package_name }</td> <!-- Package Name -->
                            <td  class="description-cell">${packageData.description }</td> <!-- Description -->
                            <td>${packageData.amount }</td> <!-- Amount -->
                            <td>${packageData.net_amount }</td> <!-- Amount -->
                           <td >
                                <!-- Edit button that calls the 'packages.edit' route -->
                                <a  class="btn-action-icon me-2">
                                    <span><i data-id="${packageData.id }" class="fe fe-edit edit_package"></i></span>
                                </a>
                            </td>
                        </tr>
                    `;

                        // Append the new row to the table body
                        tableBody.append(newRow);
                        var discount = $('.discount').val();
                        var vat = $('.vat').val();
                        var discount_type = $('#discount_type').val();
                        var symbol = $('#currency_symbol').val();
                        calculation(response.data.amount, vat, discount, discount_type,
                            symbol);

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
        } else {
            const tableBody = $('#packageBody');
            tableBody.empty(); // Clear existing rows
            const newRow = `<tr class="odd"> <td valign="top" colspan="4" class="dataTables_empty"
                                                                style="text-align:center;">No data available in table
                                                            </td>
                                                        </tr>
                    `;

            // Append the new row to the table body
            tableBody.append(newRow);

        }
    });

    $(document).on('change', '#discount_type', function() {
        var discount_type = $(this).val();
        var symbol = $('#currency_symbol').val();
        if (discount_type === 'Fixed') {
            var discount = $('.discount').val();
            var vat = $('.vat').val();
            var package_amt = $('#package_amt').val();

        } else {
            var discount = $('.discount').val();
            var vat = $('.vat').val();
            var package_amt = $('#package_amt').val();

        }
        calculation(package_amt, vat, discount, discount_type, symbol);
    });

    $(document).on('input', '.discount', function() {
        var discount_type = $('#discount_type').val();

        // Get the current discount value
        var discount = $(this).val(); // Default to 0 if not a number
        // alert(discount);
        // Get package amount and GST vat values
        var package_amt = $('#package_amt').val(); // Default to 0 if not a number
        var vat = $('.vat').val();
        var symbol = $('#currency_symbol').val();
        calculation(package_amt, vat, discount, discount_type, symbol);
    });

    $(document).on('input', '.vat', function() {
        var vat = $(this).val();
        var discount_type = $('#discount_type').val();
        var package_amt = $('#package_amt').val(); // Default to 0 if not a number
        var discount = $('.discount').val();
        var symbol = $('#currency_symbol').val();
        calculation(package_amt, vat, discount, discount_type, symbol);
    });

    function calculation(amount, tax, discount, discount_type, symbol) {
        // Parse discount and tax values as floats, default to 0 if not a number
        var discount = parseFloat(discount) || 0;
        var vat = parseFloat(tax) || 0;
        var package_amt = parseFloat(amount) || 0;

        // Update the input and display values
        $('#discount').val(discount);
        $('#vat').val(vat);

        $('.vat').text(vat.toFixed(2) + '%');
        $('.amount').text(symbol + package_amt.toFixed(2));
        // Calculate the discount amount based on discount type
        var discountAmount = 0;
        if (discount_type === 'Fixed') {
            discountAmount = discount; // For fixed discount, use the discount value directly
            $('.discount').text(symbol + discount.toFixed(2));
        } else if (discount_type === 'Percentage') {

            discountAmount = (package_amt * discount) / 100; // For percentage discount
            $('.discount').text(discount.toFixed(2) + '%');
        } else {
            $('.discount').text(symbol + discount.toFixed(2));
        }

        // Calculate the amount after applying the discount
        var amountAfterDiscount = package_amt - discountAmount;
        // Calculate the GST amount based on the amount after discount
        var gstAmount = (amountAfterDiscount * vat) / 100;

        // Calculate the total amount including GST
        var total_amt = amountAfterDiscount + gstAmount;

        // Display the calculated total amount with 2 decimal places
        $('.total_amt').text(symbol + total_amt.toFixed(2));

        // Optional: You can remove this alert in the final version

    }

    function toggleIBANField() {
        var selectedBranch = $.trim($('#branch_id option:selected').text()).toLowerCase();
        if (selectedBranch === 'dubai') {
            //$('#currency_id').next('.select2-container').css('pointer-events', 'none');

            var currencySelect = $('#currency_id'); // Currency select element
            currencySelect.val('4').trigger('change');
            $('.iban_no').show();
            // Change label text to SWIFT Code
            $('label[for="ifsc_code"]').text('SWIFT Code');
            // Change placeholder to Enter SWIFT Code
            $('#ifsc_code').attr('placeholder', 'Enter SWIFT Code');
        } else {
           // $('#currency_id').next('.select2-container').css('pointer-events', 'none');

            var currencySelect = $('#currency_id'); 
            currencySelect.val('1').trigger('change');
            $('.iban_no').hide();
            // Revert back to IFSC Code for other branches
            $('label[for="ifsc_code"]').text('IFSC Code');
            // Revert placeholder to Enter IFSC Code
            $('#ifsc_code').attr('placeholder', 'Enter IFSC Code');
        }
    }

    // Check the branch on page load (for edit case)
    toggleIBANField();

    // Listen for changes in the branch selection
    $('#branch_id').change(function() {
        toggleIBANField();
    });

}); //end redy function
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // When a country is selected, load the respective states
        $(document).on('change', '#country', function () {
            var countryId = $(this).val();
            $('#state_id').prop('disabled', false).empty().append('<option value="">Select State</option>');
            $('#city').prop('disabled', true).empty().append('<option value="">Select City</option>');

            if (countryId) {
                let fullUrl = '{{ url("/states") }}/' + countryId;
                $.ajax({
                    url: fullUrl, // Adjust URL as per your route
                    method: 'GET',
                    success: function (states) {
                        // Ensure that the response is parsed as an array
                        if (Array.isArray(states)) {
                            states.forEach(function (state) {
                                //  alert(state.id );
                                $('#state_id').append('<option value="' + state.id + '">' + state.name + '</option>');
                            });
                        } else {
                            console.error("Invalid response format");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching states: ", error);
                    }
                });
            }
        });



        // When a state is selected, load the respective cities
        $(document).on('change', '#state_id', function () {
            var stateId = $(this).val();
            $('#city_id').prop('disabled', false).empty().append('<option value="">Select City</option>');

            if (stateId) {
                let fullUrl = '{{ url("/cities") }}/' + stateId;
                $.ajax({
                    url: fullUrl, // Get cities for the selected state
                    method: 'GET',
                    success: function (cities) {
                        cities.forEach(function (city) {
                            $('#city_id').append('<option value="' + city.id + '">' + city.name + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>
<!-- /Theme Setting -->
@endsection