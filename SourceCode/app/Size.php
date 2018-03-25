<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Size extends Model
{
    protected $table = 'sizes';

    protected $fillable = ['id', 'cate_id', 'value'];

    public function category ()
    {
    	return $this->belongsTo('App\Category', 'cate_id'); // 1 loại sp có nhiều size
    }
}
