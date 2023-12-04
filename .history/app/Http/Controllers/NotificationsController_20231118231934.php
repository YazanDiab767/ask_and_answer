<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Question;
use App\Models\Comment;
use App\Models\Workspace;
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
    
    public function getCountUnreadNotifications()
    {
        return Notification::getNumberNewNotifications();
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
        
        $n = Notification::create([
            'user_id' => $question->user->id,
            'data' => json_encode( $data ),
            'read' => false
        ]);
        return $n->load('user');
    }

    //set return question
    public static function setReturnQuestion($question_id)
    {
        $data = [
            "type" => "return_question",
            "questionID" => $question_id
        ];
        $question = Question::find($question_id);
        
        $n = Notification::create([
            'user_id' => $question->user->id,
            'data' => json_encode( $data ),
            'read' => false
        ]);
        return $n->load('user');
    }

    //set  invite workspace
    public static function setInviteWorkspace($workspace_id , $user_id )
    {
        $workspace = Workspace::find($workspace_id);

        $data = [
            "type" => "invite_workspace",
            "workspace_id" => $workspace_id,
            "workspace_name" => $workspace->name,
            "sender" => auth()->user()->name,
            "sender_image" => auth()->user()->image
        ];

    
        $n = Notification::create([
            'user_id' => $user_id,
            'data' => json_encode( $data ),
            'read' => false
        ]);
        return $n->load('user');
    }

    //set message
    public static function setMessage($receiver_id , $text , $goTo)
    {
        $data = [
            "type" => "message",
            "sender" => auth()->user()->name,
            "sender_image" => auth()->user()->image,
            "text" => $text,
            "goTo" => "$goTo"
        ];

    
        $n = Notification::create([
            'user_id' => $receiver_id,
            'data' => json_encode( $data ),
            'read' => false
        ]);
        return $n->load('user');
    }

    //set all notifications as read to current user
    public static function setAllRead()
    {
        Notification::where('user_id',auth()->user()->id)->update(array('read' => 1));
    }
}
