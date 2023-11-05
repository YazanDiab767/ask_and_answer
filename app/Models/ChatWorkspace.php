<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\User;
use \App\Models\Workspace;

class ChatWorkspace extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','reciver_id','workspace_id', 'text'];

    protected $table = 'chat_workspaces';

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
