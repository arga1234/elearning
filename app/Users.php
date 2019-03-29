<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use DB;
use Cmgmyr\Messenger\Traits\Messagable;


class Users extends Eloquent {
    use Messagable;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'sex',
        'fullName',
        'email',
        'password',
        'salt',
        'telp',
        'sekolah',
        'role',
        'asessor'
        
        ];
    public function schoolGsm(){
        return $this->belongsTo('App\SchoolGsm','schoolgsm_id');
    }
        

   

    }
