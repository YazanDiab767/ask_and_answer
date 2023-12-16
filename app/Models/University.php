<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;
    protected $fillable = ['name','add_by'];

    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }
}
