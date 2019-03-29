<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use DB;
class SchoolGsm extends Eloquent {


    protected $connection = 'mongodb';
    protected $collection = 'schoolGsm';

    protected $fillable = [
        'propinsi',
        'kode_kab_kota',
        'kabupaten_kota',
        'kode_kec',
        'data_id',
        'kecamatan',
        'npsn',
        'sekolah',
        'bentuk',
        'status',
        'user_id',
        'alamat_jalan',
        'lintang',
        'bujur',
        
    	];

    protected $dates = [
        
        'deleted_at'
    ];


    public function user()
    {
        return $this->hasMany('App\User','schoolgsm_id');
    }

    }
