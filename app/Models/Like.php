<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\User;
use \App\Models\Question;

class Like extends Model
{
    use HasFactory;

    public function User()
    {
        return $this->belongsTo( User::class );
    }

    public function Question()
    {
        return $this->belongsTo( Question::class );
    }


}
