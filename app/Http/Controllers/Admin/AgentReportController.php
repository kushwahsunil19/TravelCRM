<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use PDF;

class AgentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Initialize query
        $query = Agent::query();

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

        // Get the filtered agents
        $agents = $query->get();

        return view('admin.agents.agents-report', compact('agents'));
    }

    /**
     * Download PDF report.
     */
    /**
 * Download PDF report.
 */
public function downloadPDF(Request $request)
{
    // Set the timezone to Indian Standard Time (IST)
    date_default_timezone_set('Asia/Kolkata'); 

    // Initialize the query
    $query = Agent::query();

    // Apply filters (similar to index method)
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

    // Get the filtered data
    $agents = $query->get();

    // Check if agents exist before generating the PDF
    if ($agents->isEmpty()) {
        return redirect()->back()->with('error', 'No agents found for the selected filters.');
    }

    // Load the PDF view with filtered agents data
    $pdf = PDF::loadView('admin.agents.agents-report-pdf', compact('agents'));

    // Format the date for the filename
    $timestamp = date('Y-m-d_H-i-s');
    $filename = 'agents_report_' . $timestamp . '.pdf';

    // Return the PDF download
    return $pdf->download($filename);
}




    /**
     * Download CSV report.
     */
    public function downloadCSV(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata'); 
    
        // Initialize query
        $query = Agent::query();
    
        // Reapply filters
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
    
        // Get the filtered data
        $agents = $query->get();
    
        if ($agents->isEmpty()) {
            return redirect()->back()->with('error', 'No agents found for the selected filters.');
        }
    
        // Create a CSV handle
        $handle = fopen('php://output', 'w');
    
        $timestamp = date('Y-m-d_H-i-s');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="agent_report_' . $timestamp . '.csv"');
    
        // Add CSV headers
        fputcsv($handle, [
            'S.No',
            'Agent Name',
            'Email',
            'Mobile',
            'City', 
            'State',
            'Country',
        ]);
        
        $serialNumber = 1;
    
        // Add the filtered data rows
        foreach ($agents as $agent) {
            fputcsv($handle, [
                $serialNumber++,
                $agent->name,
                $agent->email,
                $agent->mobile,
                $agent->city,
                $agent->state,
                $agent->country,
            ]);
        }
    
        fclose($handle);
        exit;
    }
    
}
