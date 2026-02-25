<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Display all posts on the index page
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::latest()->get() // Fetch posts ordered by latest first
        ]);
    }

    // Show create post form
    public function create()
    {
        return view('posts.create');
    }

    // Store new post in database
    public function store(Request $request)
    {
        Post::create($request->validate([
            'title' => 'required',        
            'description' => 'nullable'  
        ]));

        return redirect()->route('posts.index'); // Redirect to posts list
    }

    // Show edit form for selected post
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    // Update selected post data
    public function update(Request $request, Post $post)
    {
        $post->update($request->validate([
            'title' => 'required',       
            'description' => 'nullable'  
        ]));

        return redirect()->route('posts.index'); // Redirect after update
    }

    // Delete selected post
    public function destroy(Post $post)
    {
        $post->delete(); // Remove post from database

        return redirect()->route('posts.index'); // Redirect back to list
    }
}