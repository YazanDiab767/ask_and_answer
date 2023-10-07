<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Course;
use \App\Models\Operation;


class UsersController extends Controller
{

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


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
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
