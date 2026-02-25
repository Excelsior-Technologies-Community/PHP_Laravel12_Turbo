#  PHP_Laravel12_Turbo

<p align="center">
<a href="#"><img src="https://img.shields.io/badge/Laravel-12-red" alt="Laravel Version"></a>
<a href="#"><img src="https://img.shields.io/badge/PHP-8.2%2B-blue" alt="PHP Version"></a>
<a href="#"><img src="https://img.shields.io/badge/Hotwire-Turbo-green" alt="Turbo Laravel"></a>
<a href="#"><img src="https://img.shields.io/badge/SPA--Like-Navigation-purple" alt="SPA Like"></a>
<a href="#"><img src="https://img.shields.io/badge/CRUD-Posts-orange" alt="CRUD"></a>
</p>

---

##  Overview

**PHP_Laravel12_Turbo** is a modern Laravel 12 CRUD application built using **Hotwire Turbo** to achieve SPA-like navigation **without React or Vue**.

Turbo automatically converts normal links and forms into background AJAX requests, allowing partial page updates and smooth navigation while keeping the simplicity of Blade templates.

This project demonstrates a **Posts CRUD system** with a modern admin-style UI using pure CSS.

---

##  Features

*  Turbo Drive navigation (no full page reload)
*  Turbo Frames (partial UI updates)
*  Automatic AJAX form submission
*  Modern admin UI (Pure CSS)
*  Blade templating
*  SPA-like experience without frontend frameworks
*  MySQL database support

---


##  Folder Structure

```
app/
 ├── Http/Controllers/
 │   └── PostController.php
 ├── Models/
 │   └── Post.php

resources/
 └── views/
     ├── layouts/
     │   └── app.blade.php
     └── posts/
         ├── index.blade.php
         ├── create.blade.php
         ├── edit.blade.php
         └── partials/
             └── row.blade.php

routes/
 └── web.php

database/
 └── migrations/
     └── create_posts_table.php
```

---

## Tech Stack

* Laravel 12
* Hotwire Turbo (turbo-laravel)
* Blade
* Vite
* MySQL
* PHP 8.2+

---

## Step 1 — Create Laravel Project

```bash
composer create-project laravel/laravel turbo-app

php artisan serve
```

Open: http://127.0.0.1:8000

---

## Step 2 — Install Turbo Laravel

```bash
composer require hotwired-laravel/turbo-laravel

php artisan turbo:install
```

This command automatically:
* installs Turbo JS
* updates app.js
* configures Vite
* adds middleware
* publishes config

---

## Step 3 — Frontend

```bash
npm install
npm run dev
```

---

## Step 4 — Database

`.env`

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

---

## Step 5 — Create Model + Migration + Controller

```bash
php artisan make:model Post -mcr
```

This creates:
* Model
* Migration
* Controller (resource)

---

## Step 6 — Migration

`database/migrations/xxxx_create_posts_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

Run migration:

```bash
php artisan migrate
```

---

## Step 7 — Model

`app/Models/Post.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];
}
```

---

## Step 8 — Routes

`routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Create all CRUD routes (index, create, store, show, edit, update, destroy) for posts
Route::resource('posts', PostController::class);

// Redirect homepage (/) to posts listing page
Route::get('/', fn () => redirect('/posts'));
```

---

## Step 9 — Controller

`app/Http/Controllers/PostController.php`

```php
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
            'posts' => Post::latest()->get()
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

        return redirect()->route('posts.index');
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

        return redirect()->route('posts.index');
    }

    // Delete selected post
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index');
    }
}
```

---

## Step 10 — Layout + CSS

`resources/views/layouts/app.blade.php`

```blade
<!DOCTYPE html>
<html>
<head>
    <title>Turbo Laravel CRUD</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
        body{background:linear-gradient(135deg,#eef2f7,#d9e4f5);min-height:100vh;padding:40px;}
        .container{max-width:900px;margin:auto;background:#fff;padding:35px;border-radius:14px;box-shadow:0 15px 40px rgba(0,0,0,0.08);}
        h1{text-align:center;margin-bottom:25px;color:#2d3748;}
        .btn{padding:10px 16px;border:none;border-radius:8px;cursor:pointer;text-decoration:none;color:white;font-weight:600;font-size:14px;transition:.3s;}
        .btn-primary{background:#4f46e5;}
        .btn-primary:hover{background:#4338ca;transform:translateY(-1px);}
        .btn-danger{background:#ef4444;}
        .btn-danger:hover{background:#dc2626;}
        .btn-warning{background:#f59e0b;}
        .btn-warning:hover{background:#d97706;}
        label{font-weight:600;color:#374151;}
        input,textarea{width:100%;padding:12px;margin-top:8px;margin-bottom:18px;border:1px solid #e5e7eb;border-radius:8px;font-size:15px;}
        input:focus,textarea:focus{outline:none;border-color:#4f46e5;box-shadow:0 0 0 3px rgba(79,70,229,.15);}
        .card{background:#f9fafb;border-radius:12px;padding:18px;margin-bottom:15px;border:1px solid #eee;transition:.3s;}
        .card:hover{transform:translateY(-3px);box-shadow:0 10px 25px rgba(0,0,0,0.08);}
        .card h3{color:#111827;margin-bottom:6px;}
        .card p{color:#6b7280;margin-bottom:12px;}
        .top-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;}
        hr{border:none;border-top:1px solid #eee;margin:20px 0;}
    </style>
</head>

<body>
<div class="container">
<h1> Turbo Laravel CRUD</h1>
@yield('content')
</div>
</body>
</html>
```

---

## Step 11 — Index (Turbo Frame)

`resources/views/posts/index.blade.php`

```blade
@extends('layouts.app')

@section('content')

<div class="top-bar">
    <h2>All Posts</h2>

    <a href="{{ route('posts.create') }}" class="btn btn-primary">
        + Create Post
    </a>
</div>

<hr>

<turbo-frame id="posts">
    @foreach($posts as $post)
        @include('posts.partials.row')
    @endforeach
</turbo-frame>

@endsection
```

---

## Step 12 — Row Partial (Turbo Frame)

`resources/views/posts/partials/row.blade.php`

```blade
<turbo-frame id="post-{{ $post->id }}">

<div class="card">

    <h3>{{ $post->title }}</h3>
    <p>{{ $post->description }}</p>

    <a href="{{ route('posts.edit',$post) }}"
       class="btn btn-warning">Edit</a>

    <form method="POST"
          action="{{ route('posts.destroy',$post) }}"
          style="display:inline;">
        @csrf
        @method('DELETE')

        <button class="btn btn-danger">
            Delete
        </button>
    </form>

</div>

</turbo-frame>
```

---

## Step 13 — Create View

`resources/views/posts/create.blade.php`

```blade
@extends('layouts.app')

@section('content')

<h2>Create Post</h2>
<hr>

<form method="POST" action="{{ route('posts.store') }}">
@csrf

<label>Title</label>
<input name="title" placeholder="Enter title">

<label>Description</label>
<textarea name="description" placeholder="Write something..."></textarea>

<button class="btn btn-primary">Save Post</button>

</form>

@endsection
```

---

## Step 14 — Edit View (Inline Update)

`resources/views/posts/edit.blade.php`

```blade
<turbo-frame id="post-{{ $post->id }}">

<div class="card">

<form method="POST" action="{{ route('posts.update',$post) }}">
@csrf
@method('PUT')

<label>Title</label>
<input name="title" value="{{ $post->title }}">

<label>Description</label>
<textarea name="description">{{ $post->description }}</textarea>

<button class="btn btn-primary">Update</button>

</form>

</div>

</turbo-frame>
```

---

## Run

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

Open: http://127.0.0.1:8000

---

## Expected Output

* Dashboard (Index)

  <img width="896" height="354" alt="Screenshot 2026-02-25 112433" src="https://github.com/user-attachments/assets/5c2bde77-0fb4-48e5-8702-78792cce7af9" />
---
* Create

  <img width="899" height="449" alt="Screenshot 2026-02-25 112230" src="https://github.com/user-attachments/assets/53dc9d62-df41-49ee-811f-7a35b7c38c19" />
---
* Edit

  <img width="896" height="522" alt="Screenshot 2026-02-25 112420" src="https://github.com/user-attachments/assets/e2104156-01b6-4be9-adf9-1cd1a773b10a" />
---
* Delete instantly

---

##  How Turbo Works

---

### 1️ Normal Laravel (Without Turbo)

When you click **Edit** or **Create**:

```
Click Link
↓
Browser reloads full page
↓
CSS reload
JS reload
Navbar reload
Content reload
```

**Result:**

*  White flash during navigation
*  Slower user experience
*  Entire page re-rendered

---

### 2️ With Turbo Enabled

Turbo automatically intercepts link clicks and form submissions.

```
Click Link / Submit Form
↓
Turbo sends background request (AJAX)
↓
Server returns HTML (Blade View)
↓
Turbo replaces only required DOM area
↓
Done  (No full reload)
```

**Result:**

*  No page refresh
*  Smooth navigation
*  SPA-like experience

---

## Final Result

* Laravel 12 + Turbo Laravel
* SPA-like CRUD
* Modern UI
* Partial page updates



