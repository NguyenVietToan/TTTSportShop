<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class OrderDetail extends Model
{
    protected $table = 'order_details';

    protected $fillable = ['order_id', 'pro_id', 'size_id', 'qty', 'status', 'created_at', '  updated_at'];

    public function order ()
    {
    	return $this->belongsTo('App\Order');   //1 sp thuộc về 1 loại sp, 1 chi tiết đơn hàng chỉ thuộc về 1 đơn hàng
    }
}
