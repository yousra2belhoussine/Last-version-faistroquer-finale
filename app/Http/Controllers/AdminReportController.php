<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminReportController extends Controller
{
    /**
     * Display a listing of reports.
     */
    public function index(Request $request)
    {
        $query = Report::query()
            ->with(['reporter', 'reportable'])
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->when($request->type, function ($q, $type) {
                $q->where('reportable_type', $type);
            });

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('reason', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $reports = $query->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Reports/Index', [
            'reports' => $reports,
            'filters' => $request->only(['status', 'type', 'search']),
        ]);
    }

    /**
     * Display the specified report.
     */
    public function show(Report $report)
    {
        $report->load([
            'reporter',
            'reportable',
            'adminActions',
        ]);

        // Load additional relationships based on reportable type
        if ($report->reportable_type === 'App\\Models\\Ad') {
            $report->load('reportable.user', 'reportable.category', 'reportable.region');
        } elseif ($report->reportable_type === 'App\\Models\\User') {
            $report->load('reportable.badges', 'reportable.reviews');
        }

        return Inertia::render('Admin/Reports/Show', [
            'report' => $report,
        ]);
    }

    /**
     * Resolve a report with specified action.
     */
    public function resolve(Request $request, Report $report)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete,edit_category,edit_details,close',
            'category_id' => 'required_if:action,edit_category|exists:categories,id',
            'details' => 'required_if:action,edit_details|array',
            'resolution_notes' => 'required|string',
        ]);

        // Create admin action record
        $report->adminActions()->create([
            'admin_id' => auth()->id(),
            'action' => $validated['action'],
            'details' => [
                'category_id' => $validated['category_id'] ?? null,
                'edited_details' => $validated['details'] ?? null,
                'notes' => $validated['resolution_notes'],
            ],
        ]);

        // Apply action to reported item
        switch ($validated['action']) {
            case 'delete':
                if ($report->reportable) {
                    $report->reportable->delete();
                }
                break;
            
            case 'edit_category':
                if ($report->reportable_type === 'App\\Models\\Ad') {
                    $report->reportable->update([
                        'category_id' => $validated['category_id'],
                    ]);
                }
                break;
            
            case 'edit_details':
                if ($report->reportable) {
                    $report->reportable->update($validated['details']);
                }
                break;
        }

        // Update report status
        $report->update([
            'status' => 'resolved',
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
        ]);

        // Notify users
        $report->reporter->notify(new ReportResolved($report));
        if ($report->reportable && method_exists($report->reportable, 'notify')) {
            $report->reportable->notify(new ContentReported($report));
        }

        return redirect()->route('admin.reports.show', $report)
            ->with('success', 'Report resolved successfully.');
    }
} 