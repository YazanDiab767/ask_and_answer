<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\User;

class Notification extends Model
{
    use HasFactory;
    public static $paginate = 10;
    protected $fillable = ['user_id','data','read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //get number all notifications for current user
    public static function getNumberNotifications()
    {
        return Notification::where('user_id' ,auth()->user()->id)->count();
    }

    //get number all notifications for messagbe
    public static function getNumberNotificationsForMessages()
    {
        return Notification::where('user_id' ,auth()->user()->id)
        ->where('data' , 'LIKE' , '%' . '"type":"message"' . '%')
        ->where('read','0')
        ->count();
    }

    public static function getNumberNewNotifications()
    {
        return Notification::where('user_id',auth()->user()->id)
            ->where('data' , '! LIKE' , '%' . '"type":"message"' . '%')
            ->where('read','0')
            ->count();
    }

    public static function formats($data)
    {
        $data = json_decode( $data );

        switch ( $data->type )
        {
            case 'reply_on_question':
                return self::formatReply( json_encode($data) );
            break;
            case  'reply_on_user':
                return self::formatReply( json_encode($data) );
            break;
            case 'stop_question':
                return self::formatStopQuestion( json_encode($data) );
            break;
            case 'return_question':
                return self::formReturnQuestion( json_encode($data) );
            break;
        }
    }

    // *** F O R M A T - N O T I F I C A T I O N S ***

    //format reply on question or user
    public static function formatReply($data)
    {
        $data = json_decode($data);

        $route_question = route('question',$data->questionID) .'/#c-'.$data->commentID;
        
        $label = "";
        if ( $data->type == "reply_on_question" )
            $label = "قام بالرد على سؤالك ";
        else if ( $data->type == "reply_on_user" )
            $label = "قام بالرد عليك";

        return
        '
        <h5 class="text-right mr-1 mt-1">
            <img src="' . asset('storage/' . $data->image ) . '" class="mr-3 mt-3 rounded-circle text-right">
            <a class="text-black" style="font-size: 14px;">
                <b>'  . $data->username . ' : </b>
            </a>
            <label style="font-size: 14px;">
                ' . $label . '
                <a style="font-size: 14px;" href="'. $route_question .'" class="qus text-primary">
                    <i class="fas fa-arrow-alt-circle-left mr-1" style="font-size: 25px;"></i> 
                </a> 
            </label>
        </h5>
        ';
    }

    //format stop question
    public static function formatStopQuestion($data)
    {
        $data = json_decode( $data );
        $question = \App\Question::withTrashed()->find( $data->questionID );
        $note = $data->note;
        return self::formatWarning('
            لقد تم توقيف سؤالك من المشرفين <br/>
            ملاحظة : ' . $note . '
            <br> <br>
            ' . utf8_decode( $question->text ) . '
        ');
    }

    //format return question
    public static function formReturnQuestion($data)
    {
        $data = json_decode( $data );

        return self::formatSuccess('
            لقد تم تفعيل سؤالك من المشرفين
            <a href = "'.route('question',$data->questionID).'" class = "text text-success" >
                اضغط هنا للدخول الى السؤال
            </a> 
        ');
    }

    //format warning
    public static function formatWarning($data)
    {
        return
        '
            <div class="alert alert-warning text-right" role="alert">
                <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> تحذير  </h4>
                <hr>
                <div style = "max-height: 120px; overflow: hidden;"  style="font-size: 20px;">
                    ' . $data . '
                </div>
            </div>
        ';
    }

    //format success
    public static function formatSuccess($data)
    {
        return
        '
            <div class="alert alert-success text-right" role="alert">
                <i class="fas fa-check-circle"></i>
                ' . $data . '
            </div>
        ';
    }

}
