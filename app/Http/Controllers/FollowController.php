<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function index()
    {
        $currentUserId = auth()->id();

        // Retrieve the list of users followed by the current user
        $following = Follower::where('author_id', $currentUserId)
            ->with('user') // Eager load the 'user' relationship
            ->get()
            ->pluck('user'); // Extract the user objects

        return view('folow.index',compact('following'));
    }

    public function create()
    {
        $currentUserId = auth()->id(); 


    $alreadyFollowedIds = Follower::where('author_id', $currentUserId)
                                  ->pluck('user_id')
                                  ->toArray();


    $folow = User::where('user_role', '!=', 'ADMIN')
                 ->where('id', '!=', $currentUserId) 
                 ->whereNotIn('id', $alreadyFollowedIds)
                 ->pluck('fname', 'id');

    return view('folow.add', compact('folow'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'array', 
            'user_id.*' => 'exists:users,id', 
        ]);

        $followerIds = $request->input('user_id', []); 

     
        $currentUserId = auth()->id();

        // Loop through each user ID and create a follower record
        foreach ($followerIds as $followerId) {
            // Avoid duplicating followers
            if (!Follower::where('user_id', $followerId)
                        ->where('author_id', $currentUserId)
                        ->exists()) {
                Follower::create([
                    'user_id' => $followerId,
                    'author_id' => $currentUserId,
                ]);
            }
        }

        // Redirect or return a response
        return redirect()->route('follow.index')->with('notify_message', ['status' => 'success', 'msg' => 'User followed successfully!']);
    }

    public function destroy($userId)
    {
        $currentUserId = Auth::id();

        // Find the follower record to delete
        $follower = Follower::where('author_id', $currentUserId)
                            ->where('user_id', $userId)
                            ->first();

        if ($follower) {
            $follower->delete();
            return redirect()->route('follow.index')->with('notify_message', ['status' => 'success', 'msg' => 'User Unfollowed successfully!']);
        }

        return redirect()->route('follow.index')->with('error', 'Follow record not found.');
    }
}
