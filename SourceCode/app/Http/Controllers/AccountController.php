<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash, Auth, DB;
use Illuminate\Support\Str;
use Mail;
use App\Mail\verifyEmail;
use Image, File, Config;
class AccountController extends Controller
{
    //Đăng nhập
    function getLogin ()
    {
        if (Auth::check()) {
            return redirect()->route('getHome');
        }
    	return view('user.account.login');
    }

    function postLogin (Request $request)
    {
    	$this->validate($request,
            [
                'email'    => 'required|email',
                'password' => 'required|min:6|max:20'
            ],
            [
                'email.required'    => 'Vui lòng nhập email của bạn',
                'email.email'       => 'Không đúng định dạng email',
                'password.required' => 'Vui lòng nhập mật khẩu của bạn',
                'password.min'      => 'Mật khấu có tối thiểu 6 kí tự',
                'password.max'      => 'Mật khấu có tối đa 20 kí tự'
            ]
        );

        //Lấy thông tin và so sánh với data trong DB: khi vừa mới đăng ký, chưa active thì khi đó status = 0, như thế sẽ không đăng nhập được vào hệ thống, chỉ đăng nhập đc vào hệ thống khi status = 1
        $input_account = array('email' => $request->email, 'password' => $request->password, 'status' => '1');
        if (Auth::attempt($input_account, $request->has('remember_token'))) {  //nếu có tồn tại trong DB, ở đây $request->has('remember_token') tương ứng với remember_token = true, là có click vào checkbox ghi nhớ đăng nhập
            return redirect()->route('getHome');
        } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Đăng nhập không thành công! Tài khoản của bạn chưa kích hoạt, hoặc bạn đã nhập sai email hay password. Vui lòng kiểm tra lại!']);
        }
    }

    

    //Đăng ký
    function getRegister ()
    {
        //nếu đã đăng nhập rồi thì quay về trang chủ
        if (Auth::check()) {
            return redirect()->route('getHome');
        }

        $provinces         = DB::table('province')->get();
        $data['year_arr']  = Config::get('constants.years');
        $data['month_arr'] = Config::get('constants.months');
        $data['day_arr']   = Config::get('constants.days');
        $data['provinces'] = $provinces;
    	return view('user.account.register', $data);
    }

    function postRegister (Request $request)
    {
    	$this->validate($request,
    		[
                'email'       => 'required|email|unique:users,email',
                'password'    => 'required|min:6|max:20',
                're_password' => 'required|same:password',
                'name'        => 'required|max:120',
                'gender'      => 'required',
                'day'         => 'required',
                'month'       => 'required',
                'year'        => 'required',
                'ward'        => 'required',
                'address'     => 'required',
                'phone'       => 'required|min:10|numeric'
    		],
    		[
                'email.required'       => 'Vui lòng nhập email của bạn',
                'email.email'          => 'Không đúng định dạng email',
                'email.unique'         => 'Email này đã có người sử dụng',
                'password.required'    => 'Vui lòng nhập mật khẩu của bạn',
                'password.min'         => 'Mật khấu có tối thiểu 6 kí tự',
                'password.max'         => 'Mật khấu có tối đa 20 kí tự',
                're_password.required' => 'Vui lòng nhập lại mật khẩu của bạn',
                're_password.same'     => 'Mật khẩu không giống nhau',
                'name.required'        => 'Vui lòng nhập tên đầy đủ của bạn',
                'gender.required'      => 'Vui lòng chọn giới tính',
                'day.required'         => 'Vui lòng chọn ngày sinh',
                'month.required'       => 'Vui lòng chọn tháng sinh',
                'year.required'        => 'Vui lòng chọn năm sinh',
                'ward.required'        => 'Vui lòng chọn phường/xã',
                'address.required'     => 'Vui lòng nhập địa chỉ của bạn',
                'phone.required'       => 'Vui lòng nhập số điện thoại của bạn',
                'phone.min'            => 'Số điện thoại phải có ít nhất 10 chữ số',
                'phone.numeric'        => 'Số điện thoại chỉ bao gồm chữ số'
    		]
    	);

    	$user = new User;
        $user->email       = $request->email;
        $user->password    = Hash::make($request->password);  //trong laravel: Hash::make = bcrypt
        $user->re_password = Hash::make($request->re_password);
        $user->name        = $request->name;
        $user->gender      = $request->gender;
        $user->birthday    = $request->year . '-' . $request->month . '-' . $request->day;
        $user->wardid      = $request->ward;
        $user->address     = $request->address;
        $user->phone       = $request->phone;
        $user->verifyToken = Str::random(40);
    	$user->save();

        //Xử lý ảnh đại diện
        if (!empty($request->file('avatar'))) {
            $img_ext = $request->file('avatar')->getClientOriginalExtension();  //lấy phần đuôi mở rộng của file
            if (in_array($img_ext, Config::get('constants.image_valid_extension'))) {
                $img_name = $request->file('avatar')->getClientOriginalName();

                $img_dir  = 'resources/upload/images/user/' . $user->id;
                if (!file_exists($img_dir)) {
                    mkdir($img_dir);
                }
                $img = Image::make($request->file('avatar')->getRealPath());
                $img->resize(100, 100)->save($img_dir . '/' .  $img_name);
                $user->avatar = $img_name;
                $user->save();
            } else {
                return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'File bạn chọn không phải là một hình ảnh !']);
            }
        }

        //gửi mail kích hoạt tài khoản
        $thisUser = User::findOrFail($user->id);
        $this->sendEmail($thisUser);

    	return redirect()->route('getLogin')->with(['flash_level' => 'success', 'flash_message' => 'Đã đăng ký tài khoản nhưng bạn cần phải vào email đăng ký để kích hoạt tài khoản']);
    }


    //Gửi đến email đăng ký của ng dùng cái link kích hoạt tài khoản sau khi đăng ký. Cái verifyEmail chính là cái verifyEmail.php được tạo bằng php atisan make:mail... (lấy thông tin tài khoản)
    public function sendEmail ($thisUser) {
        Mail::to($thisUser['email'])->send(new verifyEmail($thisUser));
    }


    //sau khi đăng ký thì đã lưu trong DB rồi, nhưng khi đó status = 0
    //sau khi đến mail kích hoạt thì mới cập nhật lại status = 1, khi đó thì sẽ ko còn mã verifyToken nữa (=null)
    public function sendEmailDone ($email, $verifyToken) {
        $user = User::where(['email' => $email, 'verifyToken' => $verifyToken])->first();
        if ($user) {
         User::where(['email' => $email, 'verifyToken' => $verifyToken])->update(['status' => '1', 'verifyToken' => null]);
         return redirect()->route('getLogin');
        } else {
            echo 'Không tồn tại tài khoản!';
        }
    }


    //Đăng xuất
    public function postLogout ()
    {
        Auth::logout();
        return redirect()->route('getHome');
    }


    // public function resetDate(){
    //     $table = 'wish_lists';
    //     $select = ['id'];
    //     $list_records = DB::table($table)->select($select)->get();
    //     $time = time();
    //     $diff = 0;
    //     $c_than_u = 0;
    //     foreach($list_records as $record){
    //         $diff = mt_rand(1, 3600) + $diff;
    //         $current_created = $time + $diff;
    //         $c_than_u = mt_rand(7200, 745000);
    //         $current_updated = $current_created +  $c_than_u;
    //         $data_update = [
    //             'created_at' => Date('Y-m-d H:i:s',$current_created),
    //             'updated_at' => Date('Y-m-d H:i:s',$current_updated)
    //         ];
    //         DB::table($table)->where('id', $record->id)->update($data_update);
    //     }
    // }

}


