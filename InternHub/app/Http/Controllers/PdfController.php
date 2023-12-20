<?php

namespace App\Http\Controllers;

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

    public function createNotice ($id) {
        //$data = RandomNotice::where('id',$id)->first();
       // $pdf = PDF::loadview('Notice',Compact('data'));
        //$fileName = ($data['Date']."_".$data['Topic'] ?? 'default') . '.pdf';
        //return $pdf->Stream($fileName);
    }
}
