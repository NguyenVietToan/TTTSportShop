<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class LargeBanner extends Model
{
	protected $table    = "large_banners";

	protected $fillable = ['id', 'name', 'image', 'display', 'description', 'created_at', 'updated_at'];
}
