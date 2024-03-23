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
use Illuminate\Support\Facades\Validator;

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
        $user->credits = $u->credits;
        $user->company = $u->company;
        $user->c_address = $u->c_address;
        $user->hr_number = $u->hr_number;
        $user->s_date = $u->s_date;
        $user->e_date = $u->e_date;
        $user->supervisor = $u->supervisor;
        $user->s_email = $u->s_email;
        $user->s_mobile = $u->s_mobile;
        $user->technologies = $u->technologies;
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
        $u = User::where('id',$id)->first();
        $email = $u->email;
        $name = $u->name;

        try{
            Mail::to($email)->send(new RemoveMail($name));
            User::where('id',$id)->delete();
            if (File::exists('storage/'.$u->imgpath)) {
                if($u->imgpath != 'images/default.png')
                    File::delete('storage/'.$u->imgpath);
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

    public function update_user_password(Request $request){
        $request->validate([
            'new_password' => 'confirmed',
        ]);

        $user = Auth::user();

        $id = $request->input('id');
        $old_password = $request->input('old_password');
        $new_password = $request->input('new_password');

        if(!Hash::check($old_password,$user->password))
            return redirect()->back()->with('error', 'Old Password is Incorrect.');

        // $u is the user object used to update password
        $u = User::find($id);
        $u->password = Hash::make($new_password);

        try{
            Mail::to($u->email)->send(new UserPasswordChange($u->name));
        }
        catch(Exception $e){
            return redirect()->back()->with('mailerror', 'Unsuccessful! Network Error or any other error');
        }
        $u->save();

        return redirect()->back()->with('success', 'Password Changed successfully.');
    }

    public function edit()
    {
        // Fetch the user's current profile data
        $user = auth()->user();

        return view('profileedit', compact('user'));
    }

    public function update(Request $request)
    {

        Validator::extend('scnumber', function ($attribute, $value, $parameters, $validator) {
            // Define the pattern for the custom code (SC/Year/Digits)
            $pattern = '/^SC\/\d{4}\/\d{4,5}$/';

            // Use preg_match to check if the value matches the pattern
            return preg_match($pattern, $value) === 1;
        });

        Validator::replacer('scnumber', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'Invalid format. Correct format is "SC/YYYY/NNNNN".');
        });

        Validator::extend('mobile', function ($attribute, $value, $parameters, $validator) {
            // Define the pattern for the custom code (SC/Year/Digits)
            $pattern = '/^\+94\d{9}$/';
            $pattern2 = '/^0\d{9}$/';
            // Use preg_match to check if the value matches the pattern
            return preg_match($pattern, $value) || preg_match($pattern2, $value);
        });

        Validator::replacer('mobile', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'Invalid format. Correct format is +94XXXXXXXXX or 0#########.');
        });

        Validator::extend('min_words', function ($attribute, $value, $parameters, $validator) {
            $wordCount = str_word_count($value);
            return $wordCount >= 150;
        });

        Validator::replacer('min_words', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'There should be minimum 150 words.');
        });

       $request->validate([
            //personal details
            //'name'=>'required',
            'mobile'=>'required|mobile',
            //"scnumber"=>'required|scnumber|unique:registers,scnumber|unique:users,scnumber',
            //'email' => 'required|email|unique:registers,email|unique:users,email',
            'special'=>'required',
            'gpa'=>['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'credits'=>['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,heic,heif|max:5128',


            //industrial training details
            'company'=>'required',
            'c_address'=>'required',
            'hr_number'=>'required|mobile',
            's_date'=>'required|date',
            'e_date'=>'required|date',
            'supervisor'=>'required',
            's_email'=>'required|email',
            's_mobile'=>'required|mobile',
            'technologies'=>'required',
            'description'=>'required|min_words'
        ]);
        // Fetch the user's current profile data
        $id = Auth::user()->id;
        $user = User::find($id);
        if ($request->hasFile('image')) {
            if ($user->imgpath !== 'images/default.png') {
                File::delete('storage/'.$user->imgpath);
            }
            $image = $request->file('image');
            $originalName = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $filename = $this->generateUniqueFilename($originalName, $extension);

            $imgpath = $image->storeAs('images',$filename,'public');
            $user->imgpath = $imgpath;
        }

        $requestData = $request->all();
        $requestData['description'] = nl2br($requestData['description']);
        $requestData['technologies'] = nl2br($requestData['technologies']);

        try{
            $user->update($requestData);
            $user = User::find($id);

            return redirect()->back()->with('success', 'Profile updated successfully')->with('user', $user);
        }
        catch(Exception $e){
            return redirect()->back()->with('fail','Update Fail')->with('user',$user);
        }

    }

    private function generateUniqueFilename($originalName, $extension)
    {
        // You can use various strategies here to generate a unique filename
        // For example, appending a timestamp or a random string to the original name.
        $filename = pathinfo($originalName, PATHINFO_FILENAME);
        $filename = Str::slug($filename); // Convert to a URL-friendly slug
        $filename = $filename . '_' . time() . '.' . $extension;

        return $filename;
    }

    public function remove_image(){
        $user = User::find(Auth::user()->id);
        if ($user->imgpath !== 'images/default.png') {
            File::delete('storage/'.$user->imgpath);
            $imgpath = 'images/default.png';
            $user->imgpath = $imgpath;
            try{
                $user->save();
                return redirect()->back()->with('user', $user);;
            }
            catch(Exception $e){
                return redirect()->back()->with('fail','Update Fail')->with('user',$user);
            }
        }else
            return redirect()->back();
    }
}
