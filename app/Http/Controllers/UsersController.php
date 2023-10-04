<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;

class UsersController extends Controller
{

    public function index()
    {
        return view('control_panel.users',[
            'users' => User::withTrashed()->orderBy('created_at','DESC')->paginate(User::$paginate)

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
            ->orWhere('universityID', 'like', '%' . $_GET['search'] . '%')
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
