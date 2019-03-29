<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use DB;
class Article extends Eloquent {


    protected $connection = 'mongodb';
    protected $collection = 'articles';

    protected $fillable = [
        'title',
        'content',
        'author',
        'status',
        'type',
        'categories',
        'tags',
        'guid',
        'page',
        'sticky',
        'format',
        'comment_status',
        'featured_media'
        
    	];

    protected $dates = [
        
        'deleted_at'
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    }
