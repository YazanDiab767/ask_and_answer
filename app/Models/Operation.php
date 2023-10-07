<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;
    public static $paginate = 30;

    protected $fillable = ['user_id','type','details'];
    protected $table = "operations";

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
