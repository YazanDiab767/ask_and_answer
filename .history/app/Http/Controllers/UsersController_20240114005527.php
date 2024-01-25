<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Course;
use \App\Models\Comment;
use \App\Models\Operation;
use \App\Models\ChatWithSupervisor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Events\NotificationSent;
use DB;


class UsersController extends Controller
{

    public function test()
    {
        return view('test');
    }


    public function showOffers()
    {
        return view('offers');
    }

    public function getOffers()
    {
        // $jsonData = file_get_contents(asset('offers.txt'));

        // // Decode the JSON data into a PHP associative array
        // $phpArray = json_decode($jsonData, true);
        
        // // Check if decoding was successful
        // if ($phpArray === null && json_last_error() !== JSON_ERROR_NONE) {
        //     die('Error decoding JSON: ' . json_last_error_msg());
        // }        

        // return $jsonData;


       

        $client = new \GuzzleHttp\Client();
        
        $response = $client->request('GET', 'https://rapid-linkedin-jobs-api.p.rapidapi.com/search-jobs?keywords=nursing&locationId=92000000&datePosted=anyTime&sort=mostRelevant', [
            'headers' => [
                'X-RapidAPI-Host' => 'rapid-linkedin-jobs-api.p.rapidapi.com',
                'X-RapidAPI-Key' => 'd4698bfdacmsh1a3e8c389c3375cp125d3ajsn84d66524ddb2',
            ],
        ]);
        
        echo $response->getBody();

    }

    public function getActivities()
    {
        return array(
            "likes" => auth()->user()->likes,
            "comments" => Comment::where('user_id',auth()->user()->id)->get()->load('question.user')
        );
    }

    public function getInfo()
    {
        return response()->json(['data'=> auth()->user()->load('university')->load('major.college') ], 200);
    }
    
    public function profile(User $user)
    {

        return view(
            'profile',[
                'user' => $user
            ]
        );
    }

    public function calendar()
    {
        return view('calendar');
    }

    public function settings()
    {
        return view('settings');
    }

    //update image
    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'required'
        ]);

        $user = User::find( auth()->user()->id );

        if ($user->image != "/users/user.png")
        {
            //delete old image
            if(Storage::disk('public')->exists( $user->image ))
                Storage::delete('public/' . $user->image );
        }
        
        //save new image
        $user->image = $request->image->store('users','public');
        $user->save();
    }
    
    public function update(Request $request , $type) //update data of user
    {
        if ($request->ajax())
        {
            if ( $type == 'name' )
                $validator = \Validator::make($request->all(),[
                    'name' => ['required', 'string', 'max:20'],
                    'password' => 'required'
                ]);
            else if ( $type == 'email' )
                $validator = \Validator::make($request->all(),[
                    'email' => ['required', 'email', 'unique:users'],
                    'password' => 'required'
                ]);
            else if ( $type == 'password' )
                $validator = \Validator::make($request->all(),[
                    'newPassword' => ['required', 'string', 'min:8'],
                    'password' => 'required'
                ]);
            
           
            $validator->after(function ($validator) use($request) {
                if (!Hash::check($request->password , auth()->user()->password) )
                    $validator->errors()->add('error', 'Your password is invalid !');
            });
            
           $validator->validate();

           if ( $type == 'password' )
                $request[$type] = Hash::make($request->newPassword);


           $user = User::find( auth()->user()->id  );
           $user[$type] = $request[$type];
           $user->save();
        }
    }

    public function chatWithSupervisor(Course $course) // as student
    {
        return view('chats.chat_with_supervisor' ,[
            'course' => $course
        ]);
    }

    public function chatWithUser(Course $course , User $user) // as supervisor
    {
        return view('chats.chat_with_supervisor' ,[
            'course' => $course,
            'student' => $user
        ]);
    }
    
    public function getChatWithSupervisor( Course $course , User $user )
    {
        return ChatWithSupervisor::where('course_id',$course->id)->where('user_id' , $user->id)->with('user')->with('course')->orderBy('created_at','DESC')->paginate(10);
    }

    public function sendMessageToChatWithSupervisor(Request $request, Course $course , User $user )
    {
        $supervisor_name = '';
        if ( $request->sender == 'supervisor' )
            $supervisor_name = auth()->user()->name;

        $chat = ChatWithSupervisor::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'supervisor_name' => $supervisor_name,
            'sender' => $request->sender,
            'text' => $request->text,
            'image' => ''
        ]);


        if ( $request->sender == 'supervisor' )
        {
            $link = '/chatWithSupervisor/' . $course->id;
            $id = $user->id;
            $text = "send message to you in ( ".  $course->name ." - Course )";
            $notif = \App\Http\Controllers\NotificationsController::setMessage( $id , $text , $link);
            broadcast(new \App\Events\NewNotification( $notif  ))->toOthers();
        }


        broadcast(new \App\Events\NewMessageWithSupervisor( $chat  ))->toOthers();

        return ChatWithSupervisor::where('chat_with_supervisor.id',$chat->id)->where('course_id',$course->id)->where('user_id' , $user->id)->with('user')->with('course')->get();
    }
    

    // D A S H - B O A R D

    public function getChatsCourse(Course $course)
    {
        // return DB::table('chat_with_supervisor')->groupBy('user_id')->having('course_id',$course->id)->get();
        $chats = ChatWithSupervisor::select('user_id')
                ->where('course_id', $course->id)
                ->groupBy('user_id')
                ->with('user')
                ->get();
        return $chats;
    }

    public function index()
    {
        return view('control_panel.users',[
            'users' => User::withTrashed()->orderBy('created_at','DESC')->paginate(User::$paginate),
            'courses' => Course::all()

        ]);
    }

    //get more users
    public function getMoreUsers(Request $request)
    {
        return User::withTrashed()->paginate(User::$paginate);
    }

    //change user role [ admin , supervisor , user ]
    public function changeRole(Request $request , User $user ,$type)
    {
        if ($request->ajax())
        {
            $permissions;
            if ( $user->role == "admin" || $user->role == "student")
            {
                if ( $request->colleges )
                    $permissions['colleges'] = 1;

                if ( $request->questions_complaints )
                    $permissions['questions_complaints'] = 1;

                if ( $request->course )
                    $permissions['course'] = $request->course_id;
                

                $user->permissions = $permissions;
            }

            $user->role = $type;
            $user->save();
            return view(
                'control_panel.layouts.users' ,
                [
                    'users' => [ $user ],
                ]
            );
        }
    }

    //stop user ( move user to trashed users )
    public function stop(Request $request, User $user)
    {
        if ($request->ajax())
        {
            $user->delete();
            return view(
                'control_panel.layouts.users' ,
                [
                    'users' => [ $user ],
                ]
            );
        }
    }

    //restore user
    public function restore(Request $request, $id)
    {
        if ($request->ajax())
        {
            $user = User::withTrashed()->find($id);
            $user->restore();
            return view(
                'control_panel.layouts.users' ,
                [
                    'users' => [ $user ],
                ]
            );
        }
    }

    //show all operations log
    public function operationsLog()
    {
        $operations = Operation::orderBy('id','DESC')->paginate(Operation::$paginate);
        return view(
            'control_panel.operations_log',
            [
                'operations' => $operations
            ]
        );
    }

    //get more operations 
    public function getMoreOperations(Request $request)
    {
        if ($request->ajax())
        {
            $operations = Operation::orderBy('created_at','DESC')->paginate(Operation::$paginate);
            return view(
                'control_panel.layouts.operation',
                [
                    'operations' => $operations
                ]
            );
        }
    }

    //delete operation
    public function deleteOperation(Request $request,Operation $operation)
    {
        if ($request->ajax())
        {
            $operation->delete();
        }
    }

    //filter operations log [ university id , name , type of operation ]
    public function filerLog(Request $request)
    {        
        if ($request->ajax())
        {
            $operations = Operation::join('users','users.id','=','operations.user_id')
                ->where('users.universityID','LIKE','%' . $_GET['search'] . '%')
                ->orWhere('users.name','LIKE','%' . $_GET['search'] . '%')
                ->orWhere('operations.type','LIKE','%' . $_GET['search'] . '%')
                ->paginate(Operation::$paginate * 2);

            return view(
                'control_panel.layouts.operation',
                [
                    'operations' => $operations
                ]
            );
        }
    }


    //delete user
    public function destroy(Request $request, $id)
    {
        if ($request->ajax())
        {
            $user = User::withTrashed()->find($id);
            $user->forceDelete();
        }
    }

    //filter users using [ name , university id , role ]
    public function filter()
    {

        $users = User::Where('name', 'like', '%' . $_GET['search'] . '%')
            ->orWhere('email', 'like', '%' . $_GET['search'] . '%')
            ->orWhere('country', 'like', '%' . $_GET['search'] . '%')
            ->orWhere('role', 'like', '%' . $_GET['search'] . '%')
            ->paginate(50);
        return view(
            'control_panel.layouts.users',
            [
                'users' => $users
            ]
        );
        
    }
}
