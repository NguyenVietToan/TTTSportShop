<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;


class Province extends Model
{
	protected $table = "province";

	protected $fillable = ['provinceid', 'name', 'type'];

	public $timestamps = false;
}
