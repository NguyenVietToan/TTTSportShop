<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class VideoCategory extends Model
{
    protected $table = 'video_categories';

    protected $fillable = ['id', 'name', 'alias', 'description'];

    // public $timestamps = false;

    public function video ()
    {
    	return $this->hasMany('App\Video', 'vcate_id');
    }
}
