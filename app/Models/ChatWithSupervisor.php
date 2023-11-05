<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\User;
use \App\Models\Course;


class ChatWithSupervisor extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','course_id','supervisor_name', 'sender', 'text' ,'image'];

    protected $table = 'chat_with_supervisor';

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Course()
    {
        return $this->belongsTo(Course::class);
    }



}
