<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PasswordReset extends Eloquent
{
    //
    protected $fillable = [
      'email', 'token'
    ];
}
