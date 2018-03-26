<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Auth, Hash, File, Config, Image;
use App\User;
use App\Size;

class ProfileController extends Controller
{
    //Hiển thị thông tin tài khoản ở phần trang chính
    public function getAccount () {
        $ward         = DB::table('ward')->where('wardid', '=', Auth::user()->wardid)->first();
        $district     = DB::table('district')->where('districtid', '=', $ward->districtid)->first();
        $province     = DB::table('province')->where('provinceid', '=', $district->provinceid)->first();
        $full_address = Auth::user()->address . ' - ' . $ward->name . ' - ' . $district->name . ' - ' . $province->name;

        $data['full_address'] = $full_address;

        return view('user.profile.profile', $data);
    }


    //Hiển thị thông tin để cập nhật
    public function getProfile () {
        $user      = DB::table('users')->where('id', '=', Auth::id())->first();
        $ward      = DB::table('ward')->where('wardid', '=', $user->wardid)->first();
        $district  = DB::table('district')->where('districtid', '=', $ward->districtid)->first();
        $province  = DB::table('province')->where('provinceid', '=', $district->provinceid)->first();
        $provinces = DB::table('province')->get();
        $birthday  = explode('-',$user->birthday);

        $data['user']      = $user;
        $data['birthday']  = $birthday;
        $data['ward']      = $ward;
        $data['district']  = $district;
        $data['province']  = $province;
        $data['provinces'] = $provinces;
        $data['year_arr']     = Config::get('constants.years');
        $data['month_arr']    = Config::get('constants.months');
        $data['day_arr']      = Config::get('constants.days');

        return view('user.profile.update_profile', $data);
    }


    //Cập nhật thông tin
    public function updateProfile (Request $request) {
        $id             = Auth::id();
        $this->validate($request,
            [
                'name'    => 'required'
            ],
            [
                'name.required'    => 'Vui lòng nhập tên của bạn'
            ]
        );
        $user           = User::find($id);
        $user->name     = $request->name;
        $user->gender   = $request->gender;
        $user->phone    = $request->phone;
        $user->birthday = $request->year . '-' . $request->month . '-' . $request->day;
        $user->wardid   = $request->ward;
        $user->address  = $request->address;

        //Xử lý ảnh đại diện
        $img_dir  = 'resources/upload/images/user/' . $id;
        if (!file_exists($img_dir)) {
            mkdir($img_dir);
        }
        $img_current = $img_dir . '/' . $request->img_current;  //đường dẫn tới hình ảnh hiện tại
        if (!empty($request->file('avatar'))) { //nếu tồn tại file ảnh mới
            $img_ext = $request->file('avatar')->getClientOriginalExtension();  //lấy phần đuôi mở rộng của file
            if (in_array($img_ext, Config::get('constants.image_valid_extension'))) { //kiểm tra $img_ext có nằm trong tập các đuôi ko (xem trong folder config/constants)
                $file_name    = $request->file('avatar')->getClientOriginalName();
                $user->avatar = $file_name;
                $img = Image::make($request->file('avatar')->getRealPath());
                $img->resize(100, 100)->save($img_dir . '/' .  $file_name);
                //xóa ảnh cũ
                if (File::exists($img_current)) {
                    File::delete($img_current);
                }
            } else {
                return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'File bạn chọn không phải là một hình ảnh !']);
            }
        }

        $check = DB::table('users')->where('email', '=', $request->email)->count();
        if ( ($request->email == $user->email) || (($request->email != $user->email) && ($check < 1)) ) {
            $user->email   = $request->email;
            $user->save();
            return redirect()->route('getAccount')->with(['flash_level' => 'success', 'flash_message' => 'Cập nhật tài khoản thành công !']);
        } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Email này đã tồn tại !']);
        }
    }


    //Lấy danh sách các đơn hàng
    public function getOrder () {
        $user_id      = Auth::user()->id;
        $customers    = DB::table('customers')->select('id')->where('user_id', '=', $user_id)->get();
        $customer_ids = array(); //1 user khi mua hàng có thể trở thành nhiều customer khác nhau, cho nên ở đây có thể có nhiều customer_id --> dạng mảng
        foreach ($customers as $customer) {
            $customer_ids[] = $customer->id;
        }
        $orders  = DB::table('orders')->whereIn('orders.customer_id', $customer_ids)->get();
        foreach ($orders as $order) {
            //Lấy địa chỉ chi tiết
            $id_ward  = $order->wardid;
            $ward     = DB::table('ward')->where('wardid', '=', $id_ward)->first();
            $district = DB::table('district')->where('districtid', '=', $ward->districtid)->first();
            $province = DB::table('province')->where('provinceid', '=', $district->provinceid)->first();
            $order->full_address = $order->delivery_address . ' - ' . $ward->name . ' - ' . $district->name . ' - ' . $province->name;

            //Tính tổng giá trị đơn hàng
            $total = 0;
            $order_details = DB::table('order_details as od')
                             ->select('od.qty', 'pr.price', 'pr.sale_price')
                             ->join('products as pr', 'od.pro_id', '=', 'pr.id')
                             ->where('od.order_id', '=', $order->id)
                             ->get();
            foreach ($order_details as $od) {
                if (!empty($od->sale_price)) {
                    $total += $od->qty*$od->sale_price;
                } else {
                    $total += $od->qty*$od->price;
                }
            }
            $order->total = $total;
        }

        $data['orders'] = $orders;

        return view('user.profile.order_history', $data);
    }


    //Xem chi tiết đơn hàng
    public function getOrderDetail ($id) {
        $order_details = DB::table('order_details as od')
                         ->select('od.*', 'pr.price', 'pr.sale_price', 'pr.name', 'o.status_order')
                         ->join('products as pr', 'od.pro_id', '=', 'pr.id')
                         ->join('orders as o', 'od.order_id', '=', 'o.id')
                         ->where('o.id', '=', $id)
                         ->get();
        foreach ($order_details as $od) {
            $od->size = '';
            if ($od->size_id != null) {
                $size = Size::find($od->size_id);
                $od->size = $size->value;
            }
            $od->real_price = $od->price;
            if ($od->sale_price != null) {
                $od->real_price = $od->sale_price;
            }
        }
        // dd($order_details);
        $data['order_details'] = $order_details;
        return view('user.profile.order_detail_history', $data);
    }


    //Đổi mật khẩu
    public function getPassword () {
        return view('user.profile.update_password');
    }

    public function updatePassword (Request $request) {
        $oldPassword    = $request->oldPassword;
        $newPassword    = $request->newPassword;
        $re_newPassword = $request->re_newPassword;

        //nếu kiểm tra mật khẩu cũ vừa nhập không giống mật khẩu đang lưu trong DB
        if (!Hash::check($oldPassword, Auth::user()->password)) {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Mật khẩu cũ bạn vừa nhập không phải mật khẩu hiện tại']);
        } elseif (!Hash::check($newPassword, $re_newPassword)) {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Xác nhận mật khẩu mới chưa đúng']);
        } else {
            $request->user()
                    ->fill(
                        [
                            'password'    => Hash::make($newPassword),
                            're_password' => Hash::make($re_newPassword),
                        ]
                    )->save(); //cập nhật mật khẩu mới vào DB
            return redirect()->back()->with(['flash_level' => 'success', 'flash_message' => 'Mật khẩu của bạn đã được cập nhật']);
        }
    }
}
