<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;
    protected $fillable = ['name','college_id'];

    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }

    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }

    
    public function college()
    {
        return $this->belongsTo(\App\Models\College::class);
    }
}
