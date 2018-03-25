<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Review extends Model
{
	protected $table = 'reviews';

    protected $fillable = ['id', 'person_name', 'person_email', 'review_content', 'pro_id', 'created_at', 'updated_at'];

    public function product ()
    {
    	return $this->belongsTo('App\Product');
    }
}
