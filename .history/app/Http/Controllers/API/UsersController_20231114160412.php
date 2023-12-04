<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\models\User;
use Pusher\Pusher;

class UsersController extends Controller
{

    function Login(Request $request){

        $user = User::where('email', $request->email)->first();

        if( $user!='[]' && Hash::check($request->password,$user->password) ){
            // $token = $user->createToken('Personal Access Token')->plainTextToken;
            $token = $user->createToken('MyApp')->plainTextToken;
            $response = ['status' => 200, 'token' => $token, 'user' => $user, 'message' => 'success'];
            return response()->json($response);
        }else if($user=='[]'){
            $response = ['status' => 500, 'message' => 'No account found with this email'];
            return response()->json($response);

        }else{
            $response = ['status' => 500, 'message' => 'Wrong email or password! please try again'];
            return response()->json($response); 
        }
    }

    public function getInfo()
    {
        return response()->json(['data'=> auth()->user() ], 200);
    }

    public function auth(Request $request)
    {
        $socketId = $request->input('socket_id');
        $channelName = $request->input('channel_name');

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );

        $auth = $pusher->socket_auth($channelName, $socketId);

        return response($auth);
    

}
