<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\User;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = ["user_id","type","text","question_id","handledBy"];
    public static $types = ["harassment" , "offense" , "scam" , "other"];
    public static $paginate = 20;
    protected $attributes = [
        'handledBy' => ''
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
