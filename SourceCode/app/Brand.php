<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Brand extends Model
{
    protected $table = 'brands';

    protected $fillable = ['id', 'name', 'alias', 'image', 'description'];

    public function product ()
    {
    	return $this->hasMany('App\Product', 'brand_id');   //1 thương hiệu có nhiều sp
    }

}
