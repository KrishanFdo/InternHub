<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\AcceptMail;
use App\Mail\RemoveMail;
use App\Mail\UserPasswordChange;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Exception;

class UserController extends Controller
{
    public function accept(Request $request){
        $mail_data = [];
        $id = $request->input('id');
        $u = Register::where('id',$id)->first(); //$u is user to be accepted

        $mail_data['message'] = "You registration has been accepted. Here your username and password for InternHub-DCS";
        $mail_data['username'] = $u->email;
        $mail_data['password'] = Str::random(8);

        $user = new User();
        $user->name = $u->name;
        $user->scnumber = $u->scnumber;
        $user->email = $u->email;
        $user->mobile = $u->mobile;
        $user->gpa = $u->gpa;
        $user->special = $u->special;
        $user->company = $u->company;
        $user->c_address = $u->c_address;
        $user->hr_number = $u->hr_number;
        $user->s_date = $u->s_date;
        $user->e_date = $u->e_date;
        $user->supervisor = $u->supervisor;
        $user->s_email = $u->s_email;
        $user->s_mobile = $u->s_mobile;
        $user->description = $u->description;
        $user->password = Hash::make($mail_data['password']);
        $user->imgpath = $u->imgpath;
        $user->save();
        try{
            Mail::to($user->email)->send(new AcceptMail($mail_data));
            Register::where('id',$id)->delete();
        }
        catch(Exception $e){
            User::where('scnumber',$u->scnumber)->delete();
            return redirect()->back()->with('mailerror', 'Accepting Unsuccessful! Network Error or any other error');
        }

        return redirect()->back()->with('success', 'User Accepted Successfully');

    }

    public function users(){
        $selectedscnumber = "All";
        $selectedcompany = "All";
        $selectedspecial = "";

        $data = User::all();
        $scnumbers = User::distinct()->pluck('scnumber');
        $companies = User::distinct()->pluck('company');
        return view('users',
         compact('data','scnumbers','companies','selectedscnumber','selectedcompany','selectedspecial'));

    }

    public function delete_user(Request $request){
        $id = $request->input('id');
        $reg = Register::where('id',$id)->first();
        $email = $reg->email;
        $name = $reg->name;

        try{
            Mail::to($email)->send(new RemoveMail($name));
            Register::where('id',$id)->delete();
            if (File::exists('storage/'.$reg->imgpath)) {
                if($reg->imgpath != 'images/default.png')
                    File::delete('storage/'.$reg->imgpath);
            }
        }
        catch(Exception $e){
            return redirect()->back()->with('mailerror', 'Removal Unsuccessful! Network Error or any other error');
        }



        return redirect()->back()->with('success', 'Record Removed successfully.');

    }

    public function filtered_users(Request $request)
    {
        $query = User::query();
        $flag=0;
        // Apply filters based on user selections
        $selectedscnumber = $request->input('scnumber');
        $selectedcompany = $request->input('company');
        $selectedspecial = $request->input('special');

        if ($request->has('scnumber')) {
            if($request->input('scnumber')!="All"){
                $query->where('scnumber', $request->input('scnumber'));
                $flag = 1;
            }
        }

        if ($request->has('company')) {
            if($request->input('company')!="All"){
                $query->where('company', $request->input('company'));
                $flag = 1;
            }
        }

        if ($request->has('special')) {
            if($request->input('special')!=""){
                $query->where('special', $request->input('special'));
                $flag = 1;
            }
        }

        // Add more conditions for other filters (position, workplace, qualifications)

        $data = $query->get();

        if($flag==0){
            $data=User::all();
        }

        $scnumbers = User::distinct()->pluck('scnumber');
        $companies = User::distinct()->pluck('company');
        return view('users',
         compact('data','scnumbers','companies','selectedcompany','selectedscnumber','selectedspecial'));
    }
}
