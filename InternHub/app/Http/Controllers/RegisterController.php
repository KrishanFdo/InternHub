<?php

namespace App\Http\Controllers;

use App\Mail\RegisterMail;
use App\Mail\RemoveMail;
use App\Models\Register;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    function register(Request $request){

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
            'name'=>'required',
            'mobile'=>'required|mobile',
            "scnumber"=>'required|scnumber|unique:registers,scnumber|unique:users,scnumber',
            'email' => 'required|email|unique:registers,email|unique:users,email',
            'special'=>'required',
            'gpa'=>['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'credits'=>'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'image' => 'image|mimes:jpeg,png,jpg,gif,HEIC,HEIF|max:5128',

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

        $name = $request->input("name");
        $scnumber = $request->input('scnumber');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $gpa = $request->input('gpa');
        $special = $request->input('special');
        $credits = $request->input('credits');
        $c_address = $request->input('c_address');
        $hr_number = $request->input('hr_number');
        $s_date = $request->input('s_date');
        $e_date = $request->input('e_date');
        $supervisor = $request->input('supervisor');
        $s_email = $request->input('s_email');
        $s_mobile = $request->input('s_mobile');
        $technologies = $request->input('technologies');
        $description = $request->input('description');

        if($request->input("company")=="Other")
            $company = $request->input("other-company");
        else
            $company = $request->input("company");

        if ($request->hasFile('image')){
            $image = $request->file('image');
            $originalName = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $filename = $this->generateUniqueFilename($originalName, $extension);

            // Store the file in the 'public' disk
            $imgpath = $image->storeAs('images',$filename,'public');
        }else $imgpath = 'images/default.png';


        $registers = new Register();
        $registers->name = $name;
        $registers->scnumber = $scnumber;
        $registers->mobile = $mobile;
        $registers->email = $email;
        $registers->gpa = $gpa;
        $registers->special = $special;
        $registers->credits = $credits;
        $registers->company = $company;
        $registers->c_address = $c_address;
        $registers->hr_number = $hr_number;
        $registers->s_date = $s_date;
        $registers->e_date = $e_date;
        $registers->supervisor = $supervisor;
        $registers->s_email = $s_email;
        $registers->s_mobile = $s_mobile;
        $registers->technologies = $technologies;
        $registers->description = $description;
        $registers->imgpath = $imgpath;
        $registers->save();

        try{
            Mail::to($registers->email)->send(new RegisterMail($registers->name));
        }
        catch(Exception $e){
            $reg = Register::where('scnumber',$scnumber)->first();
            if (File::exists('storage/'.$reg->imgpath)) {
                if($reg->imgpath != 'images/default.png')
                    File::delete('storage/'.$reg->imgpath);
            }
            Register::where('scnumber',$scnumber)->delete();
            return redirect()->back()->with('mailerror', 'Registration Unsuccessful! Network Error or any other error');
        }

        return redirect()->back()->with('success', 'Registered successfully! Check your Email-Inbox');


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

    public function admin_accept(){
        $selectedscnumber = "All";
        $selectedcompany = "All";
        $selectedspecial = "";

        $data = Register::all();
        $scnumbers = Register::distinct()->pluck('scnumber');
        $companies = Register::distinct()->pluck('company');
        return view('adminaccept',
         compact('data','scnumbers','companies','selectedscnumber','selectedcompany','selectedspecial'));
    }

    public function delete_register(Request $request){
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

    public function filtered_registers(Request $request)
    {
        $query = Register::query();
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
            $data=Register::all();
        }

        $scnumbers = Register::distinct()->pluck('scnumber');
        $companies = Register::distinct()->pluck('company');
        return view('adminaccept',
         compact('data','scnumbers','companies','selectedcompany','selectedscnumber','selectedspecial'));
    }

}
