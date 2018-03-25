<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = ['id', 'user_id', 'name', 'gender', 'phone', 'email', 'creator', 'created_at', '  updated_at'];

    public function order()
	{
		return $this->hasMany('App\Order', 'customer_id');
	}
}
