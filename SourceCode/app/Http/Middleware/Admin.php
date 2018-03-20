<?php

namespace App\Http\Middleware;

use Closure;

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
        if(Session::has('member')){
            $member = Session::get('member');
            if($member['level']!=0){
                return redirect('/member/login');
            } 
        }else{
            return redirect('/member/login');  //nếu chưa đăng nhập thì khi nhập mọi url request đều được chuyển về trang login
        }
        return $next($request);
    }
}
