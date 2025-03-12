<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    
    public function index(Request $request)
    {
        

        $blogs = Blog::when($request->filled('title'), function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->title . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(2); // Adjust the number of results per page as needed
    
        return view('blog.index', compact('blogs'));
  
    }

    public function create()
    {
        return view('blog.add');
    }

    public function store(StoreBlogRequest $request)
    {


        if (!$request->hasFile('img')) {
            return redirect()->back()->with('notify_message', ['status' => 'error', 'msg' => 'No image uploaded.']);
        }
    
        if (!$request->file('img')->isValid()) {
            return redirect()->back()->with('notify_message', ['status' => 'error', 'msg' => 'Invalid image file.']);
        }
    
        $file = $request->file('img');
        $file_name = $file->hashName();
        $file->store('public/blogs');
    
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('notify_message', ['status' => 'error', 'msg' => 'User not authenticated.']);
        }
    
        $blog = new Blog();
        $blog->user_id = $user->id;
        $blog->title = $request->title;
        $blog->content = $request->content;
       
        
  
        $blog->img = 'blogs/'.$file_name;
        $blog->status = '0';
       
        $blog->save();
    
        return redirect()->route('blog.index')->with('notify_message', ['status' => 'success', 'msg' => 'Blog uploaded successfully!']);
    }

    public function show(Request $request)
    {
        $blog = Blog::findOrFail($request->id);
        return view('blog.view', compact('blog'));
    }
    public function edit(UpdateBlogRequest $request)
    {
        $blog = Blog::where('id',$request->id)->firstOrfail();
        return view('blog.edit', compact('blog'));
    }


    public function destroy(Request $request)
    {
        

       $blog = Blog::find($request->blog);
       $blog->delete();

       return redirect()->route('blog.index');
   }



}

