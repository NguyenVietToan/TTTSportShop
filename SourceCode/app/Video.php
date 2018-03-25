<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Video extends Model
{
    protected $table = 'videos';

    protected $fillable = ['id', 'title', 'alias', 'image', 'link', 'vcate_id'];

    // public $timestamps = false;

    public function video_cate ()
    {
    	return $this->belongsTo('App\VideoCategory');
    }
}
