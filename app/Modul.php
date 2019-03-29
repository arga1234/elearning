<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use DB;
class Modul extends Eloquent {


    protected $connection = 'mongodb';
    protected $collection = 'moduls';

    protected $fillable = [
       'description',
       'objective',
       'rules',
       'video',
       'powerpoint',
       'pdf',
       'task',
       'categories',
       'title',
       'imageName',
       'imagePath',
       'imageDimension'

        
    	];
    protected $guarded = []; //tambahkan baris ini
    public static $rules = [
		
	];

    protected $dates = [
        
        'deleted_at'
    ];

    }
