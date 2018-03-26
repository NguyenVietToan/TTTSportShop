<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite, Hash, Auth;
use App\User;
use App\UserSocial;

class SocialController extends Controller
{
    // public function redirectToProvider($service)
    // {
    //     return Socialite::driver($service)->redirect();
    // }

    // public function handleProviderCallback($service)
    // {
    //     if ($service = 'google') {
    //     	$user = Socialite::driver($service)->stateless()->user();
    //     }
    //     else if ($service = 'facebook') {
    //     	$user = Socialite::driver($service)->user();
    //     }
    //     else {
    //         $user = Socialite::driver($service)->user();
    //     }


    //     $social = UserSocial::where('acc_social_user_id', $user->getId())->where('acc_social', $service)->first();
    //     if ($social) {  //nếu user đã có tài khoản mạng xã hội
    //     	$u = User::where('email', $user->getEmail())->first();
    //     	Auth::login($u);
    //     	return redirect()->route('getHome');
    //     } else {  //nếu chưa tồn tại TK MXH thì tạo mới 1 TK MXH

    //     	$u = User::where('email', $user->getEmail())->first();
    //     	if (!$u) {
    //     		$u = new User;
		  //       $u->email = $user->getEmail();
		  //       $u->name = $user->getName();
		  //       $u->save();
    //     	}
    //         $userSocial = new UserSocial;
    //         $userSocial->acc_social_user_id = $user->getId();
    //         $userSocial->acc_social = $service;

    //         $userSocial->user_id = $u->id;
    //         $userSocial->save();

    //     	Auth::login($u);
    //     	return redirect()->route('getHome');
    //     }
    // }



    //Đăng nhập với Facebook
    public function redirectToProviderFaceBook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderFaceBook()
    {
        $user = Socialite::driver('facebook')->user();

        $social = UserSocial::where('acc_social_user_id', $user->getId())->where('acc_social', 'facebook')->first();
        if ($social) {  //nếu user đã có tài khoản mạng xã hội
            $u = User::where('email', $user->getEmail())->first();
            Auth::login($u);
            return redirect()->route('getHome');
        } else {  //nếu chưa tồn tại TK MXH thì tạo mới 1 TK MXH

            $u = User::where('email', $user->getEmail())->first();
            if (!$u) {
                $u = new User;
                $u->email = $user->getEmail();
                $u->name = $user->getName();
                $u->save();
            }
            $userSocial = new UserSocial;
            $userSocial->acc_social_user_id = $user->getId();
            $userSocial->acc_social = 'facebook';

            $userSocial->user_id = $u->id;
            $userSocial->save();

            Auth::login($u);
            return redirect()->route('getHome');
        }
    }


    //------------------------------------------------------------------------------------------

    //Đăng nhập với Google
    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderGoogle()
    {
        $user = Socialite::driver('google')->stateless()->user();

        $social = UserSocial::where('acc_social_user_id', $user->getId())->where('acc_social', 'google')->first();
        if ($social) {  //nếu user đã có tài khoản mạng xã hội
            $u = User::where('email', $user->getEmail())->first();
            Auth::login($u);
            return redirect()->route('getHome');
        } else {  //nếu chưa tồn tại TK MXH thì tạo mới 1 TK MXH

            $u = User::where('email', $user->getEmail())->first();
            if (!$u) {
                $u = new User;
                $u->email = $user->getEmail();
                $u->name = $user->getName();
                $u->save();
            }
            $userSocial = new UserSocial;
            $userSocial->acc_social_user_id = $user->getId();
            $userSocial->acc_social = 'google';

            $userSocial->user_id = $u->id;
            $userSocial->save();

            Auth::login($u);
            return redirect()->route('getHome');
        }
    }


    //------------------------------------------------------------------------------------------

    //Đăng nhập với Twitter: không được do ở Twitter không có trường email
    // public function redirectToProviderTwitter()
    // {
    //     return Socialite::driver('twitter')->redirect();
    // }

    // public function handleProviderTwitter()
    // {
    //     $user = Socialite::driver('twitter')->user();
    //     dd($user);

    //     $social = UserSocial::where('acc_social_user_id', $user->getId())->where('acc_social', 'twitter')->first();
    //     if ($social) {  //nếu user đã có tài khoản mạng xã hội
    //         $u = User::where('email', $user->getEmail())->first();
    //         Auth::login($u);
    //         return redirect()->route('getHome');
    //     } else {  //nếu chưa tồn tại TK MXH thì tạo mới 1 TK MXH

    //         $u = User::where('email', $user->getEmail())->first();
    //         if (!$u) {
    //             $u = new User;
    //             $u->email = $user->getEmail();
    //             $u->name = $user->getName();
    //             $u->save();
    //         }
    //         $userSocial = new UserSocial;
    //         $userSocial->acc_social_user_id = $user->getId();
    //         $userSocial->acc_social = 'twitter';

    //         $userSocial->user_id = $u->id;
    //         $userSocial->save();

    //         Auth::login($u);
    //         return redirect()->route('getHome');
    //     }
    // }
}
