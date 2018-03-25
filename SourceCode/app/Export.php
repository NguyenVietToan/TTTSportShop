<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Export extends Model
{
    protected $table = 'exports';

    protected $fillable = ['id', 'shipper_id', 'order_id', 'status', 'created_at', 'updated_at'];
}
