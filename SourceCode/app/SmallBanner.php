<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class SmallBanner extends Model
{
    protected $table    = "small_banners";

	protected $fillable = ['id', 'name', 'image', 'display', 'description', 'created_at', 'updated_at'];
}
