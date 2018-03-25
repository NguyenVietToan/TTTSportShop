<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class NewsCategory extends Model
{
    protected $table = 'news_categories';

    protected $fillable = ['name', 'description'];

    // public $timestamps = false;

    public function news ()
    {
    	return $this->hasMany('App\News', 'ncate_id');
    }
}
