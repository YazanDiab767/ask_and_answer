<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Course;
use \App\Models\Operation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Events\NotificationSent;

class UsersController extends Controller
{

    public function profile(User $user)
    {

        return view('profile');
    }

    public function settings()
    {
        return view('settings');
    }

    //update image
    public function updateImage(Request $request)
    {
        if ($request->ajax())
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

    // D A S H - B O A R D

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
