<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WishList extends Model
{
    protected $table = 'wish_lists';

    protected $fillable = ['id', 'user_id', 'pro_id','is_liked', 'created_at', 'updated_at'];

    public function user ()
    {
    	return $this->belongsTo('App\User');
    }

    public function product ()
    {
    	return $this->belongsTo('App\Product');
    }
}
