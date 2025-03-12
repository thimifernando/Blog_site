<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {        
        {        
            $query = Blog::with('user', 'tags.user')->where('status', 1);
    
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhereHas('tags.user', function($q) use ($search) {
                          $q->where('fname', 'like', '%' . $search . '%');
                      });
                });
            }
            
            // Adding pagination with 10 results per page
            $blogs = $query->paginate(5);
    
            return view('home', compact('blogs'));
        }
    }
}
