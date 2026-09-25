<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Dashboard
     */
    public function index()
    {
        $totalPosts = Post::count();

        $publishedPosts = Post::where('status', 'published')->count();

        $draftPosts = Post::where('status', 'draft')->count();

        $todayPosts = Post::whereDate('created_at', today())->count();

        $thisWeekPosts = Post::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ])->count();

        $thisMonthPosts = Post::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])->count();

        $publishedPercentage = $totalPosts > 0
            ? round(($publishedPosts / $totalPosts) * 100, 1)
            : 0;

        $draftPercentage = $totalPosts > 0
            ? round(($draftPosts / $totalPosts) * 100, 1)
            : 0;

        // Latest post
        $latestPost = Post::latest('created_at')->first();

        // Oldest post
        $oldestPost = Post::oldest('created_at')->first();

        // Recent posts
        $recentPosts = Post::latest('created_at')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalPosts',
            'publishedPosts',
            'draftPosts',
            'todayPosts',
            'thisWeekPosts',
            'thisMonthPosts',
            'publishedPercentage',
            'draftPercentage',
            'latestPost',
            'oldestPost',
            'recentPosts'
        ));
    }
}