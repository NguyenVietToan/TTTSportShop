<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Auth, Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;  //sử dụng hàm sendResetLinkEmail() trong SendsPasswordResetEmails.php để gửi mail reset mà mình nhập vào

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user');
    }

    protected function broker() {
        return Password::broker('users');
    }


    //Hiển thị form nhập email (sẽ gửi mã reset password đến cái email này)
    public function showLinkRequestForm() {
        return view('user.account.email');
    }
}
