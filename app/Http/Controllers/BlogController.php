<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('status', '1')->get();

        return view('blog.index', compact('blogs'));
    }

    public function viewPost($slug)
    {
        $blog = Blog::where('slug', $slug)->first();

        return view('blog.postdetails', compact('blog'));
    }
}
