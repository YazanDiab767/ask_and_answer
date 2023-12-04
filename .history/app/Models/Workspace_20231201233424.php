<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;
    protected $fillable = [ 'user_id' , 'name' , 'members' , 'files' , 'tasks' , 'events'];

    
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function chatWorkspace()
    {
        return $this->hasMany(\App\Models\ChatWorkspace::class);
    }


}
