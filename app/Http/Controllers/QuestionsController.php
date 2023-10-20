<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Operation;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\NotificationSend;
use Illuminate\Support\Facades\App;


class QuestionsController extends Controller
{

    public function index()
    {
        return view('control_panel.questions');
    }

    //show questions for user courses
    public function showLastQuestions()
    {
        $userCourses = explode(',' , auth()->user()->courses);

        $questions = Question::whereIn('course_id' , explode(',' , auth()->user()->courses))
                    ->orderBy('id','DESC')
                    ->with('user')->with('comments')->with('likes')->with('course')
                    ->paginate(Question::$paginate);

        return $questions;
    }

    public function store(Request $request)
    {
        if ($request->ajax())
        {
            $image = "--";
            if ($request->hasFile('image'))
                $image = $request->image->store('questions','public');

            $question = Question::create([
                'user_id' => auth()->user()->id,
                'course_id' => $request->course,
                'text' => utf8_encode($request->text),
                'image' => $image,
                'active' => 1
            ]);
            return Question::where('id',$question->id)->with('user')->with('comments')->with('likes')->with('course')->first();
        }
    }

    public function user()
    {
        return Question::where('user_id',auth()->user()->id)->with('user')->with('comments')->with('likes')->with('course')->paginate( Question::$paginate );
    }

    public function course($course)
    {
        // ->orderBy('created_at','DESC')
        return Question::where('course_id',$course)->with('user')->with('comments')->with('likes')->paginate( Question::$paginate );
    } 

    public function comments(Question $question)
    {
        return Comment::where('question_id',$question->id)->where('replyTo',0)->with('user')->with('question')->orderBy('comments.id','DESC')->paginate( Comment::$paginate );
    }

    public function subComments(Comment $comment)
    {
        return Comment::where('replyTo', $comment->id)->with('user')->with('question')->get();
    }

    public function show(Question $question)
    {
        return view('question',[
            'course' => $question->course,
            'question' => $question
        ]);
    }

    public function get(Question $question)
    {
        return Question::where('id',$question->id)->with('user')->with('comments')->with('likes')->first();
    }

    
    public function addComment(Request $request,Question $question) 
    {

        if ($request->ajax())
        {
            if ($question->stop) // this question stoped
                return json::Response( "This question is stopped !" );

            $image = "--";

            if ($request->hasFile('image'))
                $image = $request->image->store('comments','public');


            $text = utf8_encode( $request->text );
            $text = htmlspecialchars( $text );
            $text = trim( $text );
            $text = nl2br($text); // to replace each \n => <br/>

            $comment;

            if ( isset($request->reply_user_id) && $request->reply_user_id != '0' ) 
            {
                // reply on user
                $comment = Comment::create([
                    'user_id' => auth()->user()->id,
                    'question_id' => $question->id,
                    'text' => $text ,
                    'image' => $image,
                    'replyTo' => $request->reply_comment_id,
                    'replyToUsername' => \App\Models\User::find( $request->reply_user_id )->name,
                    'best_answer' => 0
                ]);
                broadcast(new \App\Events\NewComment( $comment->load('user')  ))->toOthers();

                
                $nc = new \App\Http\Controllers\NotificationsController;
                if ( $question->user->id == auth()->user()->id  ) // if onwer question reply to a certain comment
                {
                    $notif = \App\Http\Controllers\NotificationsController::setReply( $question->id , $comment->id , $request->reply_user_id );
                    broadcast(new \App\Events\NewNotification( $notif  ))->toOthers();
                }
                else
                {
                    if ( $request->reply_user_id == $question->user->id ) // any user reply on a onwer of question
                    {
                        $notif = \App\Http\Controllers\NotificationsController::setReply( $question->id , $comment->id , $request->reply_user_id );
                        broadcast(new \App\Events\NewNotification( $notif ))->toOthers();
                    }
                    else
                    {
                        $notif = \App\Http\Controllers\NotificationsController::setReply( $question->id , $comment->id , $request->reply_user_id );
                        broadcast(new \App\Events\NewNotification( $notif  ))->toOthers();
                        $notif = \App\Http\Controllers\NotificationsController::setReply( $question->id , $comment->id , $question->user->id );
                        broadcast(new \App\Events\NewNotification( $notif  ))->toOthers();
                    }
                }

            }
            else
            {
                //reply on the post 
                $comment = Comment::create([
                    'user_id' => auth()->user()->id,
                    'question_id' => $question->id,
                    'text' => $text ,
                    'image' => $image,
                    'replyTo' => $request->reply_comment_id,
                    'replyToUsername' => $request->reply_user_id,
                    'best_answer' => 0
                ]);
                broadcast(new \App\Events\NewComment( $comment->load('user')  ))->toOthers();
                if (auth()->user()->id != $question->user->id ) // check if the user is not owner question
                {
                    //send notification for owner question
                    $notif = \App\Http\Controllers\NotificationsController::setReply($question->id,$comment->id);
                    broadcast(new \App\Events\NewNotification( $notif  ))->toOthers();                    
                }
            }
            
            return Comment::where('id',$comment->id)->with('user')->with('question')->first();

        }
    }

    // enable or disable comments
    public function enableDisableComments(Request $request , Question $question) 
    {
        if ($request->ajax())
        {
            if ( auth()->user()->id == $question->user->id )
            {
                //toggle
                $question->stop_comments = !$question->stop_comments;
                $question->save();
                return $question->stop_comments;
            }
        }
    }


    public function delete(Request $request,Question $question)
    {
        if ($request->ajax())
            if ( auth()->user()->id == $question->user->id )
                $question->forceDelete();
    }

    //save question
    public function saveQuestion(Request $request,Question $question)
    {
        if ($request->ajax())
        {
            $question_id = $question->id;

            $user = auth()->user();
            if ($user->savedQuestions)
            {
                $saveQuestions = explode(',', $user->savedQuestions);
                array_push($saveQuestions, $question_id );
                $user->savedQuestions = implode(',',$saveQuestions );
            }
            else
            {
                $user->savedQuestions = $question_id;
            }
            
            $user->save();
        }
    }

    //get saved questions
    public function getSavedQuestions()
    {
        $user = auth()->user();
        if ($user->savedQuestions)
        {
            $saveQuestions = explode(',', $user->savedQuestions);
            return Question::whereIn('id',$saveQuestions)->with('user')->with('comments')->with('likes')->with('course')->paginate( Question::$paginate );
        }
        return Question::whereIn('id',[0])->with('user')->with('comments')->with('likes')->with('course')->paginate( Question::$paginate );
    }

    //unsave question
    public function unsaveQuestion(Request $request,Question $question)
    {
        if ($request->ajax())
        {
            $question_id = $question->id;
            $user = auth()->user();

            $saveQuestions = explode(',', $user->savedQuestions);

            if (($key = array_search($question_id, $saveQuestions)) !== false)
                unset($saveQuestions[$key]);
            
            $saveQuestions = implode(',' , $saveQuestions);

            $user->savedQuestions = $saveQuestions;
            $user->save();
        }
    }

    // D A S H - B O A R D
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

            $notif = \App\Http\Controllers\NotificationsController::setStopQuestion( $question_id , $request->note );
            broadcast(new \App\Events\NewNotification( $notif  ))->toOthers();

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

            $notif = \App\Http\Controllers\NotificationsController::setReturnQuestion( $question_id , $request->note );
            broadcast(new \App\Events\NewNotification( $notif  ))->toOthers();

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
