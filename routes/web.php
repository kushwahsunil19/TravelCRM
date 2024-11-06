<?php

use App\Http\Controllers\admin\ExpensesController;
use App\Http\Controllers\admin\ExpensesReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{AuthController,ForgotPasswordController,ProfileController,UserController,QuotationController,ItineraryController,PartnerController,BranchController,PackageController,CurrencyController,RolesPermissionController,VendorController,InvoiceController,SupplierController,QuotationReportController,SupplierReportController,PartnerReportController,BankController,StaffwiseController,HotelReportController};
use App\Http\Controllers\Admin\ProfitAndLoss;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/clear', function () {
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
   return "Cache cleared successfully";
});

Route::controller(AuthController::class)->group(function() {
    Route::get('/', 'login')->name('login');
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
   
});
Route::get('admin/invoices/download-csv', [InvoiceController::class, 'downloadCSV'])->name('invoices.downloadCSV');


Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::middleware(['auth'])->group(function() {
    Route::resource('profile', ProfileController::class);
    Route::get('/dashboard',[AuthController::class, 'dashboard'] )->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Resource route for users
    Route::resource('users', UserController::class); // Adjust middleware as needed
    // Route to download the report as a PDF
    Route::get('/users-pdf', [UserController::class, 'downloadPDF'])->name('user-wise-report.downloadPDF');

    // Route to download the report as a CSV
    Route::get('/users-csv', [UserController::class, 'downloadCSV'])->name('user-wise-report.downloadCSV');

    Route::resource('itineraries', ItineraryController::class); // Adjust middleware as needed
    Route::get('/itineraries-data', [ItineraryController::class, 'getdata'])->name('itineraries.data');

    Route::resource('quotations', QuotationController::class); // Adjust middleware as needed
    Route::get('/quotations-data', [QuotationController::class, 'getdata'])->name('quotations.data');

    Route::resource('partners', PartnerController::class); // Adjust middleware as needed
    Route::get('/partners-data', [PartnerController::class, 'getdata'])->name('partners.data');
    Route::resource('branches', BranchController::class);
    Route::resource('packages', PackageController::class);
    Route::resource('currencies', CurrencyController::class);
    Route::resource('banks', BankController::class);
   


    Route::get('packages/{id}/details', [PackageController::class, 'getPackageDetails'])->name('packages.details');
    // Optional: Route to restore soft-deleted packages
    Route::post('packages/{id}/restore', [PackageController::class, 'restore'])->name('packages.restore');
    Route::resource('quotations', QuotationController::class); 
    Route::get('/quotation/pdf/{id}', [QuotationController::class, 'generateQuotationPDF'])->name('quotation.estimate');
    Route::post('/bank-details', [QuotationController::class, 'addBankDetail'])->name('bank-details.add');
    Route::get('quotations/preview/{id}', [QuotationController::class, 'preview'])->name('quotations.preview');
    Route::resource('roles-permission', RolesPermissionController::class);
    Route::get('permission/{id}', [RolesPermissionController::class, 'getPermission'])->name('permission.details');
    Route::put('/roles/{role}/permissions', [RolesPermissionController::class, 'updatePermissions'])->name('roles.updatePermissions');
    Route::resource('vendors', VendorController::class); 
    Route::resource('invoices', InvoiceController::class); 
    Route::get('/invoices-paid', [InvoiceController::class, 'getInvoicesPaid'])->name('invoices.invoices-paid');
    Route::get('/invoices-overdue', [InvoiceController::class, 'getInvoicesOverdue'])->name('invoices.invoices-overdue');
    Route::get('/invoices-cancelled', [InvoiceController::class, 'getInvoicesCancelled'])->name('invoices.invoices-cancelled');
    Route::get('/invoices-recurring', [InvoiceController::class, 'getInvoicesRecurring'])->name('invoices.invoices-recurring');
    Route::get('/invoices-unpaid', [InvoiceController::class, 'getInvoicesUnpaid'])->name('invoices.invoices-unpaid');
    Route::get('/invoices-refunded', [InvoiceController::class, 'getInvoicesRefunded'])->name('invoices.invoices-refunded');
    Route::get('/invoices-draft', [InvoiceController::class, 'getInvoicesPaid'])->name('invoices.invoices-draft');
    Route::get('/invoices/pdf/{id}', [InvoiceController::class, 'generateQuotationPDF'])->name('invoice.estimate');
    Route::get('invoices/preview/{id}', [InvoiceController::class, 'preview'])->name('invoice.preview');
    Route::get('/invoices/pdf/{id}', [InvoiceController::class, 'generateQuotationPDF'])->name('invoice.estimate');
    Route::get('/convert-invoice/{id}', [QuotationController::class, 'convertToInvoice'])->name('convert-invoice.estimate');

    Route::resource('suppliers', SupplierController::class);
    Route::get('/admin/quotations/download-csv', [QuotationReportController::class, 'downloadCSV'])->name('quotations.downloadCSV');
    Route::get('/admin/quotations/download-pdf', [QuotationReportController::class, 'downloadPDF'])->name('quotations.downloadPDF');
    Route::resource('quotation-report', QuotationReportController::class);
    Route::resource('profit-loss', ProfitAndLoss::class);
    Route::get('/profit-loss/filter', [ProfitAndLoss::class, 'filter'])->name('profit-loss.filter');
    Route::get('/profit-loss-pdf', [ProfitAndLoss::class, 'downloadPDF'])->name('profit-loss.downloadPDF');
    Route::get('/profit-loss-csv', [ProfitAndLoss::class, 'downloadCSV'])->name('profit-loss.downloadCSV');

    // Route::post('quotations/{id}/restore', [QuotationController::class, 'restore'])->name('quotations.restore');

    Route::get('/pdf', [InvoiceController::class, 'downloadPDF'])->name('invoice.downloadPDF');

    Route::get('/supplier-report', [SupplierReportController::class, 'index'])->name('supplier.supplier-report');


    // Route to download the supplier report as a PDF
    Route::get('/supplier-report/pdf', [SupplierReportController::class, 'downloadPDF'])->name('supplier-report.downloadPDF');


    Route::get('/partners-report', [PartnerReportController::class, 'index'])->name('partners.partners-report');
  // Route to download the partner report as PDF
  Route::get('/partners-report/pdf', [PartnerReportController::class, 'downloadPDF'])->name('partners.partners-report.downloadPDF');
    
  // Route to download the partner hot as CSV
  Route::get('/partners-report/csv', [PartnerReportController::class, 'downloadCSV'])->name('partners.partners-report.downloadCSV');

    Route::get('/expenses',[ExpensesController::class,'index'])->name('expenses.index');
    Route::get('/expenses-report-pdf',[ExpensesController::class,'downloadPDF'])->name('expenses.downloadPDF');
    Route::get('/expenses-report-csv',[ExpensesController::class,'downloadCSV'])->name('expenses.downloadCSV');
    Route::get('/suplyer/delete-exp/{id}', [SupplierController::class, 'deleteExp'])->name('suplyer.delete-exp');
    Route::delete('expenses/{id}', [ExpensesController::class, 'destroy'])->name('expenses.destroy');
    // Route to download the supplier report as a CSV
    Route::get('/supplier-report/downloadCSV', [SupplierReportController::class, 'downloadCSV'])->name('supplier-report.downloadCSV');
// Route::post('/users', [UserController::class, 'store'])->name('users.store');
// Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
// Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');

// Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('/assing-role', [UserController::class, 'updateRole'])->name('users.updateRole');


    //staff-wise report

    Route::get('/staff-report', [StaffwiseController::class, 'index'])->name('staff-wise-report.index');

// Route to download the report as a PDF
Route::get('/staff-report/download-pdf', [StaffwiseController::class, 'downloadPDF'])->name('staff-wise-report.downloadPDF');

// Route to download the report as a CSV
Route::get('/staff-report/download-csv', [StaffwiseController::class, 'downloadCSV'])->name('staff-wise-report.downloadCSV');
  Route::get('/hotel-report/pdf', [HotelReportController::class, 'downloadPDF'])->name('hotel-report.downloadPDF');
  Route::get('/hotel-report/CSV', [HotelReportController::class, 'downloadCSV'])->name('hotel-report.downloadCSV');
  Route::get('/hotel-report',[HotelReportController::class,'index'])->name('hotel-report.index');
// Route for fetching users data via AJAX

});