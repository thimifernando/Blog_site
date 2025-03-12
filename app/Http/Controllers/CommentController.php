<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        //Validate the request
        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'content' => 'required|string|max:1000',
        ]);

        // Create a new comment
        Comment::create([
            'user_id' => Auth::id(), // Assuming the user is logged in
            'blog_id' => $request->input('blog_id'),
            'content' => $request->input('content'),
        ]);

        // Redirect back to the blog page with a success message
        return redirect()->back()->with('success', 'Comment added successfully.');
    }

}
