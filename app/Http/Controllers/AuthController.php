<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login_view()
    {
        return (view('signin'));
    }
    public function signup_view()
    {
        return (view('signup'));
    }
    public function signin_add(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', '=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('loginId', $user->id);
                return redirect('dashboard');
            } else {
                return back()->with('fail', 'Wrong email or passwordd');
            }
        } else {
            return back()->with('fail', 'Wrong emaill or password');
        }
    }

    public function signup_add(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'image' => 'required',

        ]);
        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->image = $request->file('image')->store('upload');
        $user->save();
        if ($user) {
            return back()->with('success', 'Registration successful');
        } else {
            return back()->with('fail', 'Something went wrong');
        }
    }
    public function dashbord_view(){
        $data=array();
        if(Session::has('loginId')){
            $data=User::where('id','=',session()->get('loginId'))->first();
        }
        return view('dashboard',compact('data'));
    }

    public function logout(){
        if(Session::has('loginId')){
            Session::pull('loginId');
        }
        return redirect('login');
    }
}
