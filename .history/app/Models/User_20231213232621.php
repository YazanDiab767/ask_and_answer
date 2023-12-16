<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,SoftDeletes,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role' , 'country' , 'savedQuestions' , 'image' ,'courses' , 'permissions'
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

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(\App\Models\Like::class);
    }

    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    public function ChatWithSupervisor()
    {
        return $this->hasMany(\App\Models\ChatWithSupervisor::class);
    }

    public function workspaces()
    {
        return $this->hasMany(\App\Models\Workspace::class);
    }

    public function chatWorkspace()
    {
        return $this->hasMany(\App\Models\ChatWorkspace::class);
    }

    public function major()
    {
        return $this->belongsTo( \App\Models\Major::class );
    }

    public function university()
    {
        return $this->belongsTo( \App\Models\Major::class );
    }
}
