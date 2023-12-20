<?php

namespace App\Http\Controllers;

use App\Models\ProgressReport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

class PdfController extends Controller
{
    public function userpdf(Request $request){
        $item = User::where('id',$request->id)->first();
        $pdf = PDF::loadview('pdf.userpdf',compact('item'));
        $fileName = ($item['scnumber']."_"."Registration_Details" ?? 'default') . '.pdf';
        return $pdf->Stream($fileName);
    }

    public function preportpdf(Request $request){
        $id = User::where('scnumber',$request->scnumber)->pluck('id')->first();
        $scnumber = $request->scnumber;
        $report = ProgressReport::where('s_id',$id)->where('period',$request->period)->get()->first();
        $pdf = PDF::loadview('pdf.preportpdf',compact('report','scnumber'));
        $fileName = ($scnumber."_"."Progress_Report_".$report->period ?? 'default') . '.pdf';
        return $pdf->Stream($fileName);
    }

}
