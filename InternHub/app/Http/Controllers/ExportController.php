<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;

class ExportController extends Controller
{
    public function exportFilteredUsers(Request $request){
        $serializedUsers = $request->query('users');
        $fields = json_decode($serializedUsers, true);
        $query = User::query();
        $flag=0;
        // Apply filters based on user selections
        $selectedscnumber = $fields['selectedscnumber'];
        $selectedcompany = $fields['selectedcompany'];
        $selectedspecial = $fields['selectedspecial'];


        if($selectedscnumber!="All"){
            $query->where('scnumber', $selectedscnumber);
            $flag = 1;
        }

        if($selectedcompany!="All"){
            $query->where('company', $selectedcompany);
            $flag = 1;
        }

        if($selectedspecial!=""){
            $query->where('special', $selectedspecial);
            $flag = 1;
        }

        // Add more conditions for other filters (position, workplace, qualifications)

        $users = $query->get();

        if($flag==0){
            $users=User::all();
        }

        return Excel::download(new UsersExport($users), 'Interns.xlsx');
    }
}
