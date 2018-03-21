<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;  //sử dụng hàm resetPassword()... trong ResetsPasswords.php để cập nhật lại password vào DB cho mình

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user');
    }

    protected function guard() {
        return Auth::guard('user');
    }

    protected function broker() {
        return Password::broker('users');
    }

    //Hiển thị form để đặt lại password
    public function showResetForm(Request $request, $token = null)
    {
        return view('user.account.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
