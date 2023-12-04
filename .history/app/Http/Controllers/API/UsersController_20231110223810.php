<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\models\User;

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

}
