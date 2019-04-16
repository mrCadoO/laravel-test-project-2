<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['name', 'email', 'site', 'text', 'parent_id', 'article_id', 'user_id'];

    public function article(){
        return $this->belongsTo('Corp\Article');
    }

    public function user(){
        return $this->belongsTo('Corp\User');
    }
}
