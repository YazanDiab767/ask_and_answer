<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use \App\Models\User;
use \App\Models\Course;
use \App\Models\Comment;
use \App\Models\Like;

// use \App\Models\Comment;

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static $paginate = 10;
    protected $fillable = ['text','user_id','course_id', 'major_id', 'image', 'note','active'];

    protected $attributes = [
        'note' => ''
    ];

    // *** Relationships ***

    public function user()
    {
        return $this->belongsTo(User::class);    
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);    
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
