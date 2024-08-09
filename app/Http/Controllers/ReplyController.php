<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'content' => 'required|string|max:1000',
        ]);
    
        $reply = new Reply();
        $reply->comment_id = $request->comment_id;
        $reply->user_id = auth()->id();
        $reply->content = $request->content;
        $reply->save();
    
        return redirect()->back();
    }
    
}
