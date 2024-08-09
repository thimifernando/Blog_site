<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('fname','email')
        ->where('user_role', 'US')
        ->get();
    //    dd($users);
        return view('user.index',compact('users'));
    }
}
