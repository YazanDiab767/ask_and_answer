<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country' => ['required','min:2'],
            'major' => ['required','min:1'],
            'university' => ['required','min:1']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // if ( \App\Models\Major::where('id', $data["major"])->count() < 1 )
        // {
        //     $new = \App\Models\Major::create([
        //         "name" => $data["major"],
        //         "college_id" => '1'
        //     ]);
        //     $data["major"] = $new->id;
        // }

        $university = \App\Models\University::where('name', $data["university"])->first();

        if (! $university )
        {
            $new = \App\Models\University::create([
                "name" => $data["university"],
                "add_by" => "student"
            ]);
            $data["university"] = $new->id;
        }
        else 
        {
            print($university["id"]);
            $data["university"] = $university->id;
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'student',
            'password' => Hash::make($data['password']),
            'country' => $data['country'],
            'image' => '/users/user.png',
            'savedQuestions' => '',
            'courses' => '',
            'permissions' => '{}',
            'major_id' => $data["major"],
            'university_id' => $data["university"]
        ]);
    }
}
