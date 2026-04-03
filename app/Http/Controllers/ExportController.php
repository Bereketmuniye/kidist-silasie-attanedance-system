<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function downloadExport(Request $request)
    {
        // Get data from session
        $csvContent = session('export_data');
        $filename = session('export_filename');
        
        // Clear session data
        session()->forget(['export_data', 'export_filename']);
        
        // Check if data exists
        if (!$csvContent || !$filename) {
            return redirect()->back()->with('error', 'No export data available');
        }
        
        // Return file download
        return response()->make($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }
}
