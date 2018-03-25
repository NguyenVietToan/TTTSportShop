<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{

	protected $table = 'comments';

    protected $fillable = ['id', 'user_id', 'news_id', 'content', 'created_at', 'updated_at'];

    public function news ()
    {
    	return $this->belongsTo('App\News');
    }
}
