<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = auth()->user()->reports()->with(['reportable'])->latest()->paginate(20);
        
        return view('reports.index', [
            'reports' => $reports
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reportable_type' => 'required|string|in:user,ad,message,proposition',
            'reportable_id' => 'required|integer',
            'reason' => 'required|string|in:spam,inappropriate,offensive,scam,other',
            'description' => 'required|string|max:1000',
        ]);

        $report = Report::create([
            'user_id' => auth()->id(),
            'reportable_type' => $validated['reportable_type'],
            'reportable_id' => $validated['reportable_id'],
            'reason' => $validated['reason'],
            'description' => $validated['description'],
            'status' => 'pending'
        ]);

        return back()->with('success', 'Signalement envoyé avec succès');
    }
} 