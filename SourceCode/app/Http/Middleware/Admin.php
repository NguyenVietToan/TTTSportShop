<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('member')) {
            $member = Session::get('member');
            if ($member['level'] != 0) {
                return redirect('/member/login');
            }
        }else{
            return redirect('/member/login');  //nếu chưa đăng nhập thì dù có vào bất cứ cái gì thì nó cũng chuyển về trang login
        }
        return $next($request);
    }
}
