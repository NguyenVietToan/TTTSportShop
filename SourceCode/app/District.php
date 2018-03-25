<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
class District extends Model
{
	protected $table = "district";

    protected $fillable = ['districtid', 'name', 'type', 'location', 'provinceid'];

    public $timestamps = false;
}