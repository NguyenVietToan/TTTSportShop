<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\UserResetPasswordNotification;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'gender', 're_password', 'wardid', 'verifyToken'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user_social ()
    {
        return $this->hasMany('App\UserSocial', 'user_id');  //1 ng dùng có nhiều tài khoản mạng XH
    }

    public function wish_list () {
        return $this->hasMany('App\WishList', 'user_id'); //1 ng yêu thích nhiều sản phẩm, wish_lists là bảng trung gian
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }
}
