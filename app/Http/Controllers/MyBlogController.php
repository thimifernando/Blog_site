<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Mail\BlogPosted;
use App\Models\Blog;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MyBlogController extends Controller
{
    public function index(Request $request)
    {
        //  dd($request->blog())

        

        $blog = Blog::where('user_id',auth()->user()->id)->get();

        // dd($blog);
       
        return view('myblog.index', compact('blog'));


        
    }

    
    public function create()
    {
        $user = Auth::user(); // Get the currently logged-in user
    
        $nonAdminUsers = User::where('user_role', '!=', 'ADMIN')
            ->where('id', '!=', $user->id) // Exclude the logged-in user
            ->pluck('fname', 'id');
       
        return view('myblog.add', compact('nonAdminUsers'));
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
        $blog->status = $request->status;
        $blog->save();
    
        if ($blog->status == 1) {
            // Fetch the emails of the users who are following the current user
            $followerEmails = User::whereIn('id', function($query) use ($user) {
                $query->select('user_id')
                      ->from('followers')
                      ->where('author_id', $user->id);
            })->pluck('email');
    
            // Send email to each follower
            foreach ($followerEmails as $email) {
                Mail::to($email)->send(new BlogPosted($blog, $user->fname, $user->email)); // Pass the logged-in user's name and email
            }
        }
    
        if ($request->has('user_id')) {
            foreach ($request->input('user_id') as $userId) {
                Tag::create([
                    'blog_id' => $blog->id,
                    'user_id' => $userId,
                ]);
            }
        }
    
        return redirect()->route('myblog.index')->with('notify_message', ['status' => 'success', 'msg' => 'Blog uploaded successfully!']);
}
    

    public function show(Request $request)
    {  
        //  dd($request->all());
        $blog = Blog::findOrFail($request->id);
        return view('myblog.view', compact('blog'));
    }
    public function edit(Request $request)
    {
        $user = Auth::user(); // Get the currently logged-in user
    
        $nonAdminUsers = User::where('user_role', '!=', 'ADMIN')
            ->where('id', '!=', $user->id) // Exclude the logged-in user
            ->pluck('fname', 'id');
        $blog = Blog::where('id',$request->id)->firstOrfail();
        return view('myblog.edit', compact('blog','nonAdminUsers'));
    }

    public function update(UpdateBlogRequest $request,$id)
    {
        // Find the blog entry by ID
        $blog = Blog::findOrFail($id);

        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('notify_message', ['status' => 'error', 'msg' => 'User not authenticated.']);
        }
    
        if ($blog->user_id !== $user->id) {
            return redirect()->back()->with('notify_message', ['status' => 'error', 'msg' => 'Unauthorized action.']);
        }
    
        if ($request->hasFile('img')) {
            if (!$request->file('img')->isValid()) {
                return redirect()->back()->with('notify_message', ['status' => 'error', 'msg' => 'Invalid image file.']);
            }
    
            // Delete the old image if exists
            if ($blog->img) {
                Storage::delete('public/' . $blog->img);
            }
    
            $file = $request->file('img');
            $file_name = $file->hashName();
            $file->store('public/blogs');
            $blog->img = 'blogs/' . $file_name;
        }
    
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->status = $request->status;
        $blog->save();
    
        // Handle tags
        if ($request->has('user_id')) {
            $blog->tags()->delete(); // Remove old tags
    
            foreach ($request->input('user_id') as $userId) {
                Tag::create([
                    'blog_id' => $blog->id,
                    'user_id' => $userId,
                ]);
            }
        }
    
        return redirect()->route('myblog.index')->with('notify_message', ['status' => 'success', 'msg' => 'Blog updated successfully!']);
    }

    public function updateStatus($id, $status)
    {
        $blog = Blog::find($id);
        if ($blog) {
            $blog->status = $status;
            $blog->save();

        $user = Auth::user();
        $message = '';

        if ($status == 1) {
            $message = 'Blog published successfully!';

            // Fetch the emails of the users who are following the current user
            $followerEmails = User::whereIn('id', function($query) use ($user) {
                $query->select('user_id')
                      ->from('followers')
                      ->where('author_id', $user->id);
            })->pluck('email');

            // Send email to each follower
            foreach ($followerEmails as $email) {
                Mail::to($email)->send(new BlogPosted($blog, $user->fname, $user->email)); // Pass the logged-in user's name and email
            }
        } elseif ($status == 0) {
            $message = 'Blog unpublished successfully!';
        } elseif ($status == 2) {
            $message = 'Blog saved as draft successfully!';
        }

        return redirect()->route('myblog.index')->with('notify_message', ['status' => 'success', 'msg' => $message]);
        }

        return redirect()->route('myblog.index')->with('notify_message', ['status' => 'error', 'msg' => 'Blog not found.']);
    }

    public function destroy(Request $request)
    {
        

        $blog = Blog::findOrfail($request->id);
       $blog->delete();

       return redirect()->route('myblog.index')->with('notify_message', ['status' => 'success', 'msg' => 'Blog Delete successfully!']);
    }
}
