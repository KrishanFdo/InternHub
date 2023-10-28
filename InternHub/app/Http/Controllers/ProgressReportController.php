<?php

namespace App\Http\Controllers;

use App\Models\ProgressReport;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use App\Rules\UniqueReportForUser;

class ProgressReportController extends Controller
{

    public function show(){
        $reports = ProgressReport::where("s_id",auth()->user()->id);
        return view('submit_report',compact('reports'));
    }
    public function submit_report(Request $request){
        $request->validate([
            'period'=>['required', new UniqueReportForUser],
            'projects'=> 'required',
            'tasks_completed'=> 'required',
            'technologies_learned'=>'required',
            'technologies_used'=>'required',
            'problems_encountered'=>'required',
            'description'=>'required',
        ]);

        $report = new ProgressReport();
        $report->s_id = auth()->user()->id;
        $report->period = $request->period;
        $report->projects = nl2br($request->projects);
        $report->tasks_completed = nl2br($request->tasks_completed);
        $report->technologies_learned = nl2br($request->technologies_learned);
        $report->technologies_used = nl2br($request->technologies_used);
        $report->problems_encountered = nl2br($request->problems_encountered);
        $report->description = nl2br($request->description);

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
        $reports = ProgressReport::where('s_id','')->get();
        $scnumber = null;
        $name = "";
        return view('progress_reports',compact('scnumbers','reports','scnumber','name'));
    }
    public function filtered_reports(Request $request){
        $scnumber = $request->scnumber;
        $id = User::where('scnumber',$request->scnumber)->pluck('id')->first();
        $name = User::where('scnumber',$request->scnumber)->pluck('name')->first();
        $reports = ProgressReport::where('s_id',$id)->orderByRaw(
            "CASE
                WHEN period = 'Week1-Week4' THEN 1
                WHEN period = 'Week5-Week8' THEN 2
                WHEN period = 'Week9-Week12' THEN 3
                WHEN period = 'Week13-Week16' THEN 4
                WHEN period = 'Week17-Week20' THEN 5
                WHEN period = 'Week21-Week24' THEN 6
                ELSE 5
            END"
        )->get();
        $scnumbers = User::distinct()->pluck('scnumber');
        return view('progress_reports',compact('scnumbers','reports','scnumber','name'));
    }
}
