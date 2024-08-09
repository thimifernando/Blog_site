<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'blog_id' => 'required|exists:blogs,id'
        ]);

        $like = Like::firstOrCreate([
            'user_id' => auth()->id(),
            'blog_id' => $request->blog_id
        ]);

        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $like = Like::where('user_id', auth()->id())
                    ->where('blog_id', $id)
                    ->first();

        if ($like) {
            $like->delete();
        }

        return redirect()->back();
    }
}
