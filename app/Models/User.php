<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'universityID', 'password', 'classNum', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ***  Relationships ***

    // public function operations()
    // {
    //     return $this->hasMany('App\Operation');
    // }

    // public function complaints()
    // {
    //     return $this->hasMany('App\Complaint');
    // }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }
    
    // public function comments()
    // {
    //     return $this->hasMany('App\Comment');
    // }

    // public function notifications()
    // {
    //     return $this->hasMany('App\Notification');
    // }

    public function resources()
    {
        return $this->hasMany('App\Resource');
    }

}
