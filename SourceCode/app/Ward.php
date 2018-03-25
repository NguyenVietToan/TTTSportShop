<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Ward extends Model
{
	protected $table = 'ward';

	protected $fillable = ['wardid', 'name', 'type', 'location', 'districtid'];

	public $timestamps = false;
}
