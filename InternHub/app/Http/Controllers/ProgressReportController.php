<?php

namespace App\Http\Controllers;

use App\Models\ProgressReport;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class ProgressReportController extends Controller
{

    public function show(){
        $reports = ProgressReport::where("s_id",auth()->user()->id);
        return view('submit_report',compact('reports'));
    }
    public function submit_report(Request $request){
        $request->validate([
            'a1'=>'required',
            'a2'=> 'required',
            'a3'=> 'required',
        ]);

        $report = new ProgressReport();
        $report->s_id = auth()->user()->id;
        $report->a1 = $request->a1;
        $report->a2 = $request->a2;
        $report->a3 = $request->a3;

        try{
            $report->save();

            return redirect()->back()->with('success', 'Report Submitted successfully');
        }
        catch(Exception $e){
            return redirect()->back()->with('fail','Submition Fail');
        }

    }

    public function reports(){
        $scnumbers = User::distinct()->pluck('scnumber');
        $reports = ProgressReport::where('id','')->get();
        $scnumber = null;
        $name = "";
        return view('progress_reports',compact('scnumbers','reports','scnumber','name'));
    }
    public function filtered_reports(Request $request){
        $scnumber = $request->scnumber;
        $id = User::where('scnumber',$request->scnumber)->pluck('id')->first();
        $name = User::where('scnumber',$request->scnumber)->pluck('name')->first();
        $reports = ProgressReport::where('s_id',$id)->get();
        $scnumbers = User::distinct()->pluck('scnumber');
        return view('progress_reports',compact('scnumbers','reports','scnumber','name'));
    }
}
