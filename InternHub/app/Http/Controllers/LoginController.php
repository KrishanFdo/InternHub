<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function authenticate(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $email = $request->input('email');
        $password = $request->input('password');

        if($request->input('role')=='user'){
            if(Auth::attempt(['email'=>$email,'password'=>$password])){
                $user = User::where('email',$email)->first();
                Auth::login($user);
                return redirect('/userhome');
            }else{
                return redirect()->back()->with('error', 'Invalid username and password');
            }
        }
        else if($request->input('role')=='admin'){
            if(Auth::guard('webadmin')->attempt(['email'=>$email,'password'=>$password])){
                $admin = Admin::where('email',$email)->first();
                Auth::guard('webadmin')->login($admin);
                return redirect('/home');
            }else{
                return redirect()->back()->with('error', 'Invalid username and password');
            }
        }

    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }

    public function adminlogout(){
        Auth::guard('webadmin')->logout();
        return redirect('/login');
    }
}
