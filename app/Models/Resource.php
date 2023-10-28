<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Course;
use \App\Models\User;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id' , 'course_id' , 'title' , 'file' , 'sharedFrom' ];

    public function course()
    {
        return $this->belongsTo( Course::class );
    }

    public function user()
    {
        return $this->belongsTo( User::class );
    }

}
