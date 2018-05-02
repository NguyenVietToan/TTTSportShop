<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Config, Image, Hash, File;
use App\User;
use App\Order;
use App\OrderDetail;
use App\Customer;


class UserController extends Controller
{

	//Lấy danh sách thành viên
    public function getList () {
    	$users = DB::table('users')->orderBy('id', 'desc')->paginate(7);
        foreach ($users as $item) {
            $id_ward = $item->wardid;
            $ward = DB::table('ward')->where('wardid', '=', $id_ward)->first();
            $district = DB::table('district')->where('districtid', '=', $ward->districtid)->first();
            $province = DB::table('province')->where('provinceid', '=', $district->provinceid)->first();
            $item->full_address = $item->address . ' - ' . $ward->name . ' - ' . $district->name . ' - ' . $province->name;
            $item->order_exist = $this->checkExistOrder($item->id);
        }
        $data['users'] = $users;

    	return view('admin.user.list', $data);
    }


    //Thêm thành viên: mật khẩu mặc định, tài khoản đc kích hoạt luôn
    public function getAdd ()
    {
        $provinces         = DB::table('province')->get();
        $data['year_arr']  = Config::get('constants.years');
        $data['month_arr'] = Config::get('constants.months');
        $data['day_arr']   = Config::get('constants.days');
        $data['provinces'] = $provinces;

        return view('admin.user.add', $data);
    }


    public function postAdd (Request $request)
    {
        $this->validate($request,
            [
                'email'       => 'required|email|unique:users,email',
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
        $user->password    = Hash::make('123456');
        $user->re_password = Hash::make('123456');
        $user->name        = $request->name;
        $user->gender      = $request->gender;
        $user->birthday    = $request->year . '-' . $request->month . '-' . $request->day;
        $user->wardid      = $request->ward;
        $user->address     = $request->address;
        $user->phone       = $request->phone;
        $user->verifyToken = null;
        $user->status      = 1;
        $user->save();

        //Xử lý ảnh đại diện
        if (!empty($request->file('avatar'))) {
            $img_name = $request->file('avatar')->getClientOriginalName();
            $img_dir  = 'resources/upload/images/user/' . $user->id;
            if (!file_exists($img_dir)) {
                mkdir($img_dir);
            }
            $img = Image::make($request->file('avatar')->getRealPath());
            $img->resize(100, 100)->save($img_dir . '/' .  $img_name);
            $user->avatar = $img_name;
            $user->save();
        }

        return redirect()->route('admin.user.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm thành viên thành công']);
    }


    //Sửa thành viên
    public function getEdit ($id)
    {
        $user      = User::find($id);
        $ward      = DB::table('ward')->where('wardid', '=', $user->wardid)->first();
        $wards     = DB::table('ward')->where('districtid', '=', $ward->districtid)->get();
        $district  = DB::table('district')->where('districtid', '=', $ward->districtid)->first();
        $districts = DB::table('district')->where('provinceid', '=', $district->provinceid)->get();
        $province  = DB::table('province')->where('provinceid', '=', $district->provinceid)->first();
        $provinces = DB::table('province')->get();

        $location   = array();  //tạo mảng location để chứa 3 giá trị đó là wardid, districtid và provinceid
        $location[] = $user->wardid;  //$location[0]
        $location[] = $ward->districtid;  //$location[1]
        $location[] = $district->provinceid; //$location[2]

        $full_address = $user->address;
        $birthday  = explode('-', $user->birthday);

        $data['user']         = $user;
        $data['provinces']    = $provinces;
        $data['districts']    = $districts;
        $data['wards']        = $wards;
        $data['location']     = $location;
        $data['full_address'] = $full_address;
        $data['birthday']     = $birthday;
        $data['year_arr']     = Config::get('constants.years');
        $data['month_arr']    = Config::get('constants.months');
        $data['day_arr']      = Config::get('constants.days');

        return view('admin.user.edit', $data);
    }

    public function postEdit (Request $request)
    {
        $id = $request->id;
        $this->validate($request,
            [
                'email'       => 'required|email',
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
        $user              = User::find($id);
        $user->name        = $request->name;
        $user->gender      = $request->gender;
        $user->birthday    = $request->year . '-' . $request->month . '-' . $request->day;
        $user->wardid      = $request->ward;
        $user->address     = $request->address;
        $user->phone       = $request->phone;
        //Xử lý ảnh đại diện
        $img_dir  = 'resources/upload/images/user/' . $id;
        if (!file_exists($img_dir)) {
            mkdir($img_dir);
        }
        $img_current = $img_dir . '/' . $request->img_current;  //đường dẫn tới hình ảnh hiện tại
        if (!empty($request->file('avatar'))) { //nếu tồn tại file ảnh mới
            $img_ext = $request->file('avatar')->getClientOriginalExtension();  //lấy phần đuôi mở rộng của file
            if (in_array($img_ext, Config::get('constants.image_valid_extension'))) { //kiểm tra $img_ext có nằm trong tập các đuôi ko (xem trong folder config/constants)

                //xóa ảnh cũ
                if (File::exists($img_current)) {
                    File::delete($img_current);
                }
                
                $file_name    = $request->file('avatar')->getClientOriginalName();
                $user->avatar = $file_name;
                $img = Image::make($request->file('avatar')->getRealPath());
                $img->resize(100, 100)->save($img_dir . '/' .  $file_name);
                
            }
        }
        $check = DB::table('users')->where('email', '=', $request->email)->count();
        if ( ($request->email == $user->email) || (($request->email != $user->email) && ($check < 1)) ) {
            $user->email   = $request->email;
            $user->save();
            return redirect()->route('admin.user.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa thành viên thành công !']);
        } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Thành viên này đã tồn tại !']);
        }

    }

    //Xóa thành viên
    //Kiểm tra xem thành viên đó có đơn hàng đang được giao ko? Nếu có đơn hàng ở trạng thái đang xử lý (1) và đang chuyển hàng (2) thì ko cho phép xóa; còn lại thì cho phép xóa, khi xóa thành viên thì cũng xóa luôn đơn hàng và đon hàng chi tiết
    public function checkExistOrder ($id) {
    	$order_amount = DB::table('orders as o')
                        ->select('o.*', 'c.user_id')
                        ->join('customers as c', 'o.customer_id', '=', 'c.id')
                        ->where('c.user_id', '=', $id)
                        ->whereIn('status_order', [1,2])
                        ->count();
    	if ($order_amount != 0) {
    		return 1;  //có đơn hàng ở trạng thái 1 hoặc 2
    	} else {
    		return 0;  //ko có đơn hàng
    	}
    }

    public function getDelete ($id) {
    	if($this->checkExistOrder($id)){
			return redirect()->route('admin.user.getList');
		}
		$user = User::find($id);
        if (!empty($user)) {
            //Xóa đơn hàng trạng thái 0,3,4
            $orders = DB::table('orders as o')
                        ->select('o.*', 'c.user_id')
                        ->join('customers as c', 'o.customer_id', '=', 'c.id')
                        ->where('c.user_id', '=', $id)
                        ->whereIn('status_order', [0,3,4])
                        ->get();
            foreach ($orders as $order) {
                //xóa chi tiết đơn hàng
                DB::table('order_details as od')->join('orders as o', 'od.order_id', '=', 'o.id')->where('order_id', '=', $order->id)->delete();
                //xóa đơn hàng
                Order::destroy($order->id);
                //xóa khách hàng là thành viên
                Customer::destroy($order->id);
            }

            //Xóa hình ảnh
            $img_dir = 'resources/upload/images/user/' . $id;
            $img     = $img_dir. '/' . $user->avatar;
            if (file_exists($img)) {
                File::delete($img);
            }
            if (file_exists($img_dir)) {
                rmdir($img_dir);
            }

            //Xóa thông tin còn lại
            $user->delete();
        }
    	return redirect()->route('admin.user.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa khách hàng thành công !']);
    }

}
