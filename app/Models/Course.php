<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\College;
use \App\Models\Question;
use \App\Models\Resource;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['college_id','name'];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function ChatWithSupervisor()
    {
        return $this->hasMany(\App\Models\ChatWithSupervisor::class);
    }
}
