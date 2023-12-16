<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Course;

class College extends Model
{
    use HasFactory;
    protected $fillable = ['name','image'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function majors()
    {
        return $this->hasMany(\App\Models\Major::class);
    }
}
