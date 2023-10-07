<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionsController extends Controller
{

    public function index()
    {
        return view('control_panel.questions');
    }


    public function create()
    {
    }


    public function store(Request $request)
    {
    }


    public function show(Question $question)
    {
    }


    public function edit(Question $question)
    {
    }


    public function update(Request $request, Question $question)
    {

    }

    public function destroy(Question $question)
    {
    }

    public function getQuestion(Request $request,$id)
    {
        if ($request->ajax())
        {
            // return Question::withTrashed(['users'])->find($id);
            

            return DB::table('questions')
            ->where('questions.id',$id)
            ->leftJoin('users', 'users.id', '=', 'questions.user_id')
            ->leftJoin('courses', 'courses.id', '=', 'questions.course_id')
            ->leftJoin('colleges', 'colleges.id', '=', 'courses.college_id')
            ->get(['questions.*','users.name as username','courses.name as course_name' ,'colleges.name as college_name']);
        }
    }

    //stop question - soft delete -
    public function stopQuestion(Request $request , Question $question)
    {
        if ($request->ajax())
        {
            $question_id = $question->id;
            
            $question->active = 0;

            $question->note = json_encode([
                "stopedBy" => auth()->user()->name,
                "note" => $request->note
            ]);

            Operation::create([
                'user_id' => auth()->user()->id,
                'type' => 'suspended',
                'details' => ' Stopped question : ' . $question_id
            ]);


            $question->save();
            $question->delete();

        }
    }

    //restore question
    public function retrunQuestion(Request $request , $question_id)
    {
        if ($request->ajax())
        {
            $question = Question::onlyTrashed()->find($question_id);
            $question->note = "";
            $question->active = 1;
            $question->save();
            $question->restore();

            
            Operation::create([
                'user_id' => auth()->user()->id,
                'type' => 'suspended',
                'details' => ' Returned question :  ' . $question_id
            ]);


            // NotificationsController::setReturnQuestion( $question_id );

            // return view(
            //     'formats.dashboard.question',
            //     [
            //         'question' => Question::withTrashed()->find( $question_id )
            //     ]
            // );
        } 
    }

}
