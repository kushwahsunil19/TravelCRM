<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;
use PDF;

class PartnerReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Initialize query
        $query = Partner::query();

        // Apply filters based on request input
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('mobile')) {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('state')) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }

        if ($request->filled('country')) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }

        // Get the filtered partners
        $partners = $query->with(['city', 'state', 'country','invoices'])->get();
       echo "<pre>"; print_r($partners );die;

        return view('admin.partners.partners-report', compact('partners'));
    }

    /**
     * Download PDF report.
     */
    public function downloadPDF(Request $request)
    {
        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata'); 

        // Filtering logic
        $query = Partner::query();
        
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('mobile')) {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }

        // Get the filtered data
        $partners = $query->with(['city', 'state', 'country'])->get();

        // Check if partners exist before generating the PDF
        if ($partners->isEmpty()) {
            return redirect()->back()->with('error', 'No partners found for the selected filters.');
        }
     
        // Generate the PDF
        $pdf = PDF::loadView('admin.partners.partners-report-pdf', compact('partners'));

        // Generate the filename with correct format
        $timestamp = date('Y-m-d_H-i-s');
        $filename = 'partners_report_' . $timestamp . '.pdf';

        // Return the PDF with the correct headers
        return $pdf->download($filename);
    }

    /**
     * Download CSV report.
     */
    public function downloadCSV(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata'); 

        $query = Partner::query();
        $partners = $query->with(['city', 'state', 'country'])->get();

        if ($partners->isEmpty()) {
            return redirect()->back()->with('error', 'No partners found for the selected filters.');
        }

        // Create a CSV handle
        $handle = fopen('php://output', 'w');

        $timestamp = date('Y-m-d_H-i-s');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="partner_report_' . $timestamp . '.csv"');

        // Add CSV headers
        fputcsv($handle, [
            'S.No',
            'Partner Name',
            'Email',
            'Mobile',
            'City', 
            'State',
            'Country',
            
        ]);
        
        $serialNumber = 1;

        // Add the filtered data rows
        foreach ($partners as $partner) {
            fputcsv($handle, [
                $serialNumber++,
                $partner->name,
                $partner->email,
                $partner->mobile,
                $partner->city->name,
                $partner->state->name,
                $partner->country->name,
               
            ]);
        }

        fclose($handle);
        exit;
    }
}
