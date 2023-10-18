<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComplaintsController extends Controller
{

    public function index()
    {
        $complaints = Complaint::orderBy('created_at','DESC')->paginate( Complaint::$paginate );
        return view(
            'control_panel.complaints' ,
            [
                'complaints' => $complaints
            ]
        );
    }

    //add new complaint
    public function add(Request $request , $question)
    {
        if ($request->ajax())
        {
            $request->validate([
                'type' => 'required'
            ]);

            Complaint::create([
                'user_id' => auth()->user()->id,
                'type' => $request->type,
                'text' => ''.$request->text,
                'question_id' => $question
            ]);

        }
    }
       
    //get more compalints
    public function getMoreComplaints(Request $request)
    {
        if ($request->ajax())
        {
            // $complaints = Complaint::orderBy('created_at','DESC')->paginate( Complaint::$paginate );
            return DB::table('complaints')
            ->leftJoin('users', 'users.id', '=', 'complaints.user_id')
            ->select('complaints.*', 'users.name as username')
            ->paginate(Complaint::$paginate);
        }
    }

    //to set supervisor on this complaint
    public function doneBy(Request $request, Complaint $complaint)
    {
        if ($request->ajax())
        {
            $complaint->handledBy = auth()->user()->name;
            $complaint->save();
        }
    }
}
