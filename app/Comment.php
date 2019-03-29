<?php

namespace App;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Comment extends Eloquent
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function deleteWithReplies()
{
        if(count($this->replies) > 0) {
                    // Delete children recursive
            foreach ($this->replies as $reply) {
            $reply->deleteWithReplies();
}
}
$this->delete();
}
}
