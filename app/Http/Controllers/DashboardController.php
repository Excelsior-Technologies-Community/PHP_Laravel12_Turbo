<?php

namespace App\Http\Controllers;

use App\Models\Post;

class DashboardController extends Controller
{
    /**
     * Display the post statistics dashboard.
     */
    public function index()
    {
        $totalPosts = Post::count();

        $publishedPosts = Post::where('status', 'published')->count();

        $draftPosts = Post::where('status', 'draft')->count();

        $todayPosts = Post::whereDate('created_at', today())->count();

        $latestPost = Post::latest()->first();

        $recentPosts = Post::latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalPosts',
            'publishedPosts',
            'draftPosts',
            'todayPosts',
            'latestPost',
            'recentPosts'
        ));
    }
}