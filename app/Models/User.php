<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role' , 'country'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','universityID'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $paginate = 3;

    // ***  Relationships ***

    public function operations()
    {
        return $this->hasMany(\App\Models\Operation::class);
    }

    public function complaints()
    {
        return $this->hasMany(\App\Models\Complaint::class);
    }

    public function questions()
    {
        return $this->hasMany(\App\Models\Question::class);
    }
    
    public function resources()
    {
        return $this->hasMany(\App\Models\Resource::class);
    }

    // public function comments()
    // {
    //     return $this->hasMany('App\Comment');
    // }

    // public function notifications()
    // {
    //     return $this->hasMany('App\Notification');
    // }
}
