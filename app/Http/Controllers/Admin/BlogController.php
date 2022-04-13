<?php

namespace App\Http\Controllers\admin;

use App\Blog;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'DESC')->get();
        
        return view('admin.blogs.view', compact('blogs'));
    }

    public function addBlog()
    {

        return view('admin.blogs.addblog');
    }

    public function storeBlogPost(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'image' => 'required',
            'status' => 'required',
        ]);

        $blog = new Blog();
        $blog->title = $request->get('title');
        $blog->slug = Str::slug($request->get('title')).time();
        $blog->description = $request->get('description');
        $blog->content = $request->get('content');

        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $filename = 'blog_'.time() . '.' . $extension;
        $image->move('public/front/images/blogs', $filename);

        $blog->image = $filename;
        $blog->status = $request->get('status');

        $blog->save();

        $this->helper->one_time_message('success', 'Added Successfully');
        return redirect()->route('admin.allBlogs');

    }

    public function editBlog($id)
    {
        $blog = Blog::where('id', $id)->first();
        
        return view('admin.blogs.edit', compact('blog'));
    }

    public function updateBlog(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'status' => 'required',
        ]);

        $blog = Blog::where('id', $request->get('blog_id'))->first();

        $blog->title = $request->get('title');
        $blog->slug = Str::slug($request->get('title')).time();
        $blog->description = $request->get('description');
        $blog->content = $request->get('content');

        if($request->file('image') != ''){
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = 'blog_'.time() . '.' . $extension;
            $image->move('public/front/images/blogs', $filename);
            $blog->image = $filename;
        }

        $blog->status = $request->get('status');

        $blog->save();

        $this->helper->one_time_message('success', 'Updated Successfully');
        return redirect()->route('admin.allBlogs');
    }

    public function deleteBlogPost($id)
    {
        $blog = Blog::where('id', $id)->first();
        $blog->delete();

        $this->helper->one_time_message('error', 'Deleted Successfully');
        return redirect()->back();
    }
}
