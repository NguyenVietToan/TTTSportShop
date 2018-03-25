<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Shipping extends Model
{
    protected $table = 'shippings';

    protected $fillable = ['id', 'order_id', 'shipper_id', 'status', 'created_at', 'updated_at'];
}
