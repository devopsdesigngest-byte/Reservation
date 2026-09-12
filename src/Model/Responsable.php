<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    protected $table = 'responsable';

    protected $fillable = ['nom', 'email', 'password'];

    protected $hidden = ['password'];
}
