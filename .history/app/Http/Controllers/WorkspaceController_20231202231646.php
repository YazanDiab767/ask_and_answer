<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Models\ChatWorkspace;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWorkspaceRequest;
use App\Http\Requests\UpdateWorkspaceRequest;

class WorkspaceController extends Controller
{

    public function index()
    {
        return view(
            'workspace.index'
        );
    }

    public function getMyWorkspaces()
    {
        
    }

    public function workspace(workspace $workspace)
    {
        return view(
            'workspace.workspace' ,[
                'workspace' => $workspace
            ]
        );
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255|unique:workspaces',
        ]);

        $workspace = Workspace::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'members' => '{}',
            'files' => '{}',
            'tasks' => '{}',
            'events' => '{}'
        ]);

        return Workspace::where('id', $workspace->id)->with('user')->get();
    }

    public function uploadWork(Request $request, workspace $workspace)
    {
        $files = json_decode( $workspace->files , JSON_FORCE_OBJECT );
        array_push( $files , array(
            "name" => auth()->user()->name,
            "file" => $request->file->store('workspace','public'),
            "comment" => $request->comment,
            "date" => date("Y-m-d H:i:s")
        ) );
        $workspace->files = json_encode( $files ,  JSON_FORCE_OBJECT );
        $workspace->save();
    }

    public function invite(Request $request, workspace $workspace)
    {
        $emails = explode(',', $request->emails);
        $invites = json_decode($workspace->members , JSON_FORCE_OBJECT);
        
        for ( $i = 0; $i < count($emails); $i++ )
        {
            $user = User::where('email', $emails[$i])->first();
            if (  $user )
            {
                array_push( $invites ,array(
                    "email" => $emails[$i], 
                    "accept" => "no",                        
                ));
                $notif = \App\Http\Controllers\NotificationsController::setInviteWorkspace( $workspace->id , $user->id );
                broadcast(new \App\Events\NewNotification( $notif  ))->toOthers();
            }
        }

        $workspace->members = json_encode($invites , JSON_FORCE_OBJECT);
        $workspace->save();

    }

    public function leave(Request $request, workspace $workspace, User $user)
    {
        $members = json_decode($workspace->members , JSON_FORCE_OBJECT);
        print_r($members);
        foreach ($members as $key => $value) 
        {
            if ( $value["email"] == $user->email )
                unset( $members[$key] );
        }

        $workspace->members = json_encode($members , JSON_FORCE_OBJECT);
        $workspace->save();
    }

    public function accept(Request $request , workspace $workspace)
    {
        $result = "reject";
        if ( $request->submit == "accept" )
            $result = "accept";

        $members = json_decode( $workspace->members , JSON_FORCE_OBJECT );
        foreach ($members as $key => $value) 
        {
            $email = $value["email"];
            if ( auth()->user()->email == $email )
            {                
                $members[$key]["accept"] = $result;
                $workspace->members = $members;
                $workspace->save();
            }
        }

        if ( $result == "accept" )
            return redirect('/workspace/' . $workspace->id);
        else
            return redirect('/workspace/');
    }

    public function delete(Request $request, workspace $workspace)
    {
        $workspace->delete();
    }

    public function get( $id )
    {
        $email = '"email":"'.auth()->user()->email.'","accept":"accept"';
        return Workspace::where('user_id' , auth()->user()->id )
                ->orWhere('members' , 'LIKE' , '%' . $email . '%')
                ->with('user')
                ->get();
    }

    public function getWorks( Request $request , workspace $workspace )
    {
        return json_decode( $workspace->files , JSON_FORCE_OBJECT );
    }

    public function addTask( Request $request , workspace $workspace )
    {
        $tasks = json_decode($workspace->tasks , JSON_FORCE_OBJECT);
        $user_tasks;



        if ( isset( $tasks[$request->username] ) ) // the user has already tasks, so add new task to all  property_exists($tasks, $request->username) 
        {
            $user_tasks = $tasks[ $request->username ];
        }

        $user_tasks[(string) date("Y-m-d H:i:s") ] = array(
            "title" => $request->title,
            "date" => $request->date,
            "isDone" => false,
            "addBy" => ""
        );

        $tasks[ $request->username ] = $user_tasks;
        $workspace->tasks = $tasks;
        $workspace->save();

    }

    public function getTasks( Request $request , workspace $workspace )
    {
        $tasks = json_decode($workspace->tasks , JSON_FORCE_OBJECT);
        return $tasks;
    }

    public toggleTaskCompletion(Request $request, workspace $workspace)
    {

    }

    // *** CHAT ***

    public function getMessagesToAll(Request $request , workspace $workspace)
    {
        return ChatWorkspace::where('reciver_id','0')->where('workspace_id', $workspace->id)->with('user')->orderBy('created_at','DESC')->paginate(10);
    }

    public function getMessagesPrivate(Request $request , workspace $workspace ,User $user)
    {
        return ChatWorkspace::where(function($query) use ($user) {
            $query->where('user_id',  $user->id);
            $query->where('reciver_id', auth()->user()->id);
        })
        ->orWhere(function($query) use ($user) {
            $query->where('user_id', auth()->user()->id );
            $query->where('reciver_id', $user->id);
        })
        ->where('workspace_id', $workspace->id)
        ->with('user')
        ->orderBy('created_at','DESC')->paginate(10);
    }

    public function sendMessageToAll(Request $request , workspace $workspace)
    {
        $m = ChatWorkspace::create([
            'user_id' => auth()->user()->id,
            'reciver_id' => 0, // to all
            'workspace_id' => $workspace->id,
            'text' => $request->text
        ]);
        
        broadcast(new \App\Events\NewMessageWorkspace( $m->load('user')  ))->toOthers();

        return ChatWorkspace::where('chat_workspaces.id', $m->id)->with('user')->first();
    }

    public function sendMessageToUser(Request $request , workspace $workspace , User $user)
    {
        $m = ChatWorkspace::create([
            'user_id' => auth()->user()->id,
            'reciver_id' => $user->id,
            'workspace_id' => $workspace->id,
            'text' => $request->text
        ]);
        
        $text = "send message to you in ( ".  $workspace->name ." - Workspace )";

        $notif = \App\Http\Controllers\NotificationsController::setMessage( $user->id , $text , "/workspace/" . $workspace->id);
        broadcast(new \App\Events\NewNotification( $notif  ))->toOthers();
        broadcast(new \App\Events\NewMessageWorkspace( $m->load('user')  ))->toOthers();

        return ChatWorkspace::where('chat_workspaces.id', $m->id)->with('user')->first();
    }
}
