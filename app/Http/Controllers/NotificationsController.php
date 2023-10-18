<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Question;
use App\Models\Comment;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    //show all notificationss
    public function showNotifications()
    {
        $notifications = Notification::where('user_id',auth()->user()->id)
            ->orderBy('created_at','DESC')
            ->paginate( Notification::$paginate );

        foreach ( $notifications as $notification ) // set notifications as readed
        {
            $notification->read = '1';
            $notification->save();
        }
    
        return view(
            'notifications' ,
            [
                'notifications' => $notifications
            ]
        );
    }

    public function get(Request $request)
    {
        $notifications = Notification::where('user_id',auth()->user()->id)
                ->orderBy('created_at','DESC')
                ->paginate( Notification::$paginate );
        foreach ( $notifications as $notification ) // set notifications as readed
        {
            $notification->read = '1';
            $notification->save();
        }
        return $notifications;
    }
    
    public static function setReply($question_id,$comment_id = '',$user = 0)
    {
        $question = Question::find($question_id);

        // if user != 0 => reply on user /\ else reply on question
        $id = ( $user ) ? $user : $question->user->id;
        $type = ( $user ) ? "reply_on_user" : "reply_on_question";
        $shor_text = Comment::find($comment_id)->text;
        if (strlen($shor_text) > 20)
            $shor_text = substr($shor_text, 0 , 20);

        $data = [
            "type" => $type,
            "username" => auth()->user()->name,
            "image" => auth()->user()->image,
            "questionID" => $question_id,
            "commentID" => $comment_id,
            "short_text" => $shor_text . " ...",
            "course" => Question::find($question_id)->course->name
        ];

        $n =  Notification::create([
            'user_id' => $id,
            'data' => json_encode($data),
            'read' => false
        ]);
        return $n->load('user');
    }

    //set stop question
    public static function setStopQuestion($question_id , $note = 'There is no !')
    {
        $question = Question::find($question_id);

        $data = [
            "type" => "stop_question",
            "questionID" => $question_id,
            "note" => $note
        ];
        
        Notification::create([
            'user_id' => $question->user->id,
            'data' => json_encode( $data ),
            'read' => false
        ]);
    }

    //set return question
    public static function setReturnQuestion($question_id)
    {
        $data = [
            "type" => "return_question",
            "questionID" => $question_id
        ];
        $question = Question::find($question_id);
        
        Notification::create([
            'user_id' => $question->user->id,
            'data' => json_encode( $data ),
            'read' => false
        ]);
    }

    //set all notifications as read to current user
    public static function setAllRead()
    {
        Notification::where('user_id',auth()->user()->id)->update(array('read' => 1));
    }
}
