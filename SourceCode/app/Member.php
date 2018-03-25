<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Member extends Model
{

    protected $table = 'members';

    protected $fillable = ['id', 'email', 'password', 're_password', 'name', 'birthday', 'gender', 'identity_card', 'phone', 'address', 'level', 'start_date', 'image', 'created_at', 'updated_at'];
}
