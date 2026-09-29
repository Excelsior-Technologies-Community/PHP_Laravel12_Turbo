<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Fetch recent activity logs.
     */
    public function index()
    {
        $activities = ActivityLog::with('post')
            ->latest()
            ->take(30)
            ->get();

        return view('activities.index', compact('activities'));
    }

    /**
     * Clear all activity logs.
     */
    public function clear(Request $request)
    {
        ActivityLog::truncate();

        if ($request->wantsTurboStream()) {
            return response()->view('activities.streams.clear')
                ->header('Content-Type', 'text/vnd.turbo-stream.html');
        }

        return back()->with('success', 'Activity logs cleared successfully.');
    }
}
