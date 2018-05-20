<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salecode extends Model
{
    protected $table = 'salecodes';

    protected $fillable = ['id', 'salecode', 'salepercent','used', 'created_at', '  updated_at'];
}
