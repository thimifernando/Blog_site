<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\WelcomeMail;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('senter');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
       
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // dd($request);
            
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function create()
    {
        return view('user.add');
    }

    public function store(StoreUserRequest $request)
    {
        
        $use = new User();
        // dd($request->all());
        $use->fname = $request->fname;
        $use->email = $request->email;
        $use->user_role = 'US';
        $use->password = Hash::make($request->password);
        $use->phone = $request->phone;

        $use->save();

        // Mail::to($use->email)->send(new WelcomeMail($use));

        return redirect()->route('dashboard')->with('notify_message', ['status' => 'success', 'msg' => 'Registration successfully!']);
    }
     public function edit(Request $request)
    {
        $use = User::findOrFail($request->user);
        return view('profile.edit', compact('use'));
    }



    public function update(UpdateUserRequest $request)

    {

        $use = User::find($request->user);
        $use->fname = $request->fname;

        $use->email = $request->email;
        if (!empty($request->password)) {
            $use->password = Hash::make($request->password);
        }
        $use->user_role = 'US';
        $use->phone = $request->phone;
       
        // dd($request->all());
        $use->save();
 

        return redirect()->route('profile')->with('notify_message', ['status' => 'success', 'msg' => 'Profile Updated successfully!']);
    
    }






    



}
