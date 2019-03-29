<?php

namespace App;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Pendampingan extends Eloquent
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
