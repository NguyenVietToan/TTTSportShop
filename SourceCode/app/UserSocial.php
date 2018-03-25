<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UserSocial extends Model
{
    protected $table = 'user_socials';

    protected $fillable = ['id', 'user_id', 'acc_social_user_id', 'acc_social'];

    public function user ()
    {
    	return $this->belongsTo('App\User');  //1 tài khoản mạng XH thuộc 1 ng dùng
    }
}
