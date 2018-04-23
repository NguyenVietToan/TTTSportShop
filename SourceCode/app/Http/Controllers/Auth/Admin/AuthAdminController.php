<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Session, Hash, Config, Image, File;
use App\Member;

class AuthAdminController extends Controller
{
    public function getLogin () {
		return view('auth.login');
	}


	public function postLogin (Request $request) {
		$this->validate($request,
			[
				'email'    => 'required',
				'password' => 'required'
			],
			[
				'email.required'    => "Bạn cần nhập email để đăng nhập",
				'password.required' => "Bạn cần nhập mật khẩu để đăng nhập!"
			]
		);
		//hàm trim() loại bỏ khoảng trắng hoặc ký tự \0, \t, \n, \x0B, \r  ở đầu và cuối chuỗi
		$email    = trim($request->email);
		$password = md5($request->password);
		$auth = array(
			'email'    => $email,
			'password' => $password
		);
		$members = DB::table('members')->where('email', '=', $email)
			                           ->where('password', '=', $password)
			                           ->first();
		if ($members) {
			$this->createMember($members);   		  //lưu member vào session để kiểm tra trong middleware
			return $this->viewMember($members->level);
		} else {
			return redirect()->route('member.getLogin')->with(['flash_level' => 'error', 'flash_message' => 'Email hoặc mật khẩu chưa đúng!']);
		}
	}


	//điều hướng về trang tương ứng với vai trò của member
	public function viewMember ($level) {
		switch ($level) {
			case 0: return redirect('/admin/home');
			case 1: return redirect('/shipper/home');
		}
	}


	//khởi tạo 1 member lưu trong session, cái 'member' dùng để kiểm tra trong middleware
	public function createMember ($member) {
		Session::put('member',
			array(
				'id'            => $member->id,
				'email'         => $member->email,
				'password'      => $member->password,
				'name'          => $member->name,
				'birthday'      => $member->birthday,
				'gender'        => $member->gender,
				'identity_card' => $member->identity_card,
				'phone'         => $member->phone,
				'level'         => $member->level,
				'start_date'    => $member->start_date,
				'wardid'        => $member->wardid,
				'address'       => $member->address,
				'image'         => $member->image
			)
		);
	}


	//đăng xuất
	public function getLogout () {
		if (Session::has('member')) {
			Session::remove('member');
		}
		return view('auth.login');
	}


	//Hiển thị thông tin cá nhân của amdin
	public function getProfile () {
		$admin    = DB::table('members')->where('id', '=', Session::get('member')['id'])->first();
		$ward     = DB::table('ward')->where('wardid', '=', $admin->wardid)->first();
		$district = DB::table('district')->where('districtid', '=', $ward->districtid)->first();
		$province = DB::table('province')->where('provinceid', '=', $district->provinceid)->first();
        $admin->full_address = $admin->address . ' - ' . $ward->name . ' - ' . $district->name . ' - ' . $province->name;
		$data['admin'] = $admin;
		return view('admin.profile.profile', $data);
	}


	//Cập nhật thông tin cá nhân của Admin
	public function getEditInfo () {
		$member       = Member::find(Session::get('member')['id']);
		$birthday     = explode('-', $member->birthday);	//birthday[0] là năm, birthday[1] là tháng, birthday[2] là ngày
		$ward         = DB::table('ward')->where('wardid', '=', $member->wardid)->first();
		$wards        = DB::table('ward')->where('districtid', '=', $ward->districtid)->get();
		$district     = DB::table('district')->where('districtid', '=', $ward->districtid)->first();
		$districts    = DB::table('district')->where('provinceid', '=', $district->provinceid)->get();
		$province     = DB::table('province')->where('provinceid', '=', $district->provinceid)->first();
		$provinces    = DB::table('province')->get();
		$location     = array();  //tạo mảng location để chứa 3 giá trị đó là wardid, districtid và provinceid
		$location[]   = $member->wardid;  //$location[0]
		$location[]   = $ward->districtid;  //$location[1]
		$location[]   = $district->provinceid; //$location[2]
		$full_address = $member->address;

		$data['member']       = $member;
		$data['birthday']     = $birthday;
        $data['year_arr']     = Config::get('constants.years');
        $data['month_arr']    = Config::get('constants.months');
        $data['day_arr']      = Config::get('constants.days');
		$data['provinces']    = $provinces;
		$data['districts']    = $districts;
		$data['wards']        = $wards;
		$data['location']     = $location;
		$data['full_address'] = $full_address;

		return view('admin.profile.update_profile', $data);
    }

    public function postEditInfo (Request $request) {
		$id = $request->id;
		$this->validate($request,
            [
	            'start_date'    =>'required',
	            'email'         =>'required|email',
	            'name'          => 'required',
	            'day'           => 'required',
	            'month'         => 'required',
	            'year'          => 'required',
	            'identity_card' => 'required',
	            'phone'         => 'required|min:10|numeric',
	            'address'       => 'required'
        	],
            [
	            'start_date.required'    => 'Bạn chưa nhập ngày bắt đầu',
	            'email.required'         => 'Vui lòng nhập email của bạn',
	            'email.email'            => 'Không đúng định dạng email',
	            'name.required'          => 'Bạn chưa nhập họ tên',
	            'day.required'           => 'Vui lòng chọn ngày sinh',
	            'month.required'         => 'Vui lòng chọn tháng sinh',
	            'year.required'          => 'Vui lòng chọn năm sinh',
	            'identity_card.required' => 'Bạn chưa nhập số chứng minh nhân dân',
	            'phone.min'              => 'Số điện thoại phải có ít nhất 10 chữ số',
	            'phone.numeric'          => 'Số điện thoại chỉ bao gồm chữ số',
	            'address.required'       => 'Bạn chưa nhập địa chỉ'
        	]
        );
		$member                = Member::find($id);
		$date_arr              = explode('/', $request->start_date);
		$str                   = $date_arr[2].'-'.$date_arr[1].'-'.$date_arr[0];
		$member->start_date    = $str;
		$member->name          = $request->name;
		$member->birthday      = $request->year . '-' . $request->month . '-' . $request->day;
		$member->gender        = $request->gender;
		$member->identity_card = $request->identity_card;
		$member->wardid        = $request->ward;
		$member->address       = $request->address;
		$member->phone         = $request->phone;

		//Xử lý ảnh đại diện
        $img_dir  = 'resources/upload/images/member/' . $id;
        if (!file_exists($img_dir)) {
            mkdir($img_dir);
        }
        $img_current = $img_dir . '/' . $request->img_current;  //đường dẫn tới hình ảnh hiện tại
        if (!empty($request->file('image'))) { //nếu tồn tại file ảnh mới
            $img_ext = $request->file('image')->getClientOriginalExtension();  //lấy phần đuôi mở rộng của file
            if (in_array($img_ext, Config::get('constants.image_valid_extension'))) { //kiểm tra $img_ext có nằm trong tập các đuôi ko (xem trong folder config/constants)
                $file_name    = $request->file('image')->getClientOriginalName();
                $member->image = $file_name;
                $img = Image::make($request->file('image')->getRealPath());
                $img->resize(100, 100)->save($img_dir . '/' .  $file_name);
                //xóa ảnh cũ
                if (File::exists($img_current)) {
                    File::delete($img_current);
                }
            }
        }

		$check = DB::table('members')->where('email', '=', $request->email)->count();
		if ( ($request->email == $member->email) || (($request->email != $member->email) && ($check < 1)) ) {
			$member->email   = $request->email;
	    	$member->save();
	    	return redirect()->route('admin.getProfile')->with(['flash_level' => 'success', 'flash_message' => 'Cập nhật thông tin cá nhân thành công !']);
	    } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Email này đã tồn tại !']);
        }

    }


    //Admin đổi mật khẩu của mình
    public function getPassword () {
        return view('admin.profile.update_password');
    }

    public function updatePassword (Request $request) {
        $oldPassword    = md5($request->oldPassword);
        $newPassword    = md5($request->newPassword);
        $re_newPassword = md5($request->re_newPassword);

        //nếu kiểm tra mật khẩu cũ vừa nhập không giống mật khẩu đang lưu trong DB
        if ($oldPassword != Session::get('member')['password']) {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Mật khẩu cũ bạn vừa nhập không phải mật khẩu hiện tại']);
        } elseif ($newPassword != $re_newPassword) {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Xác nhận mật khẩu mới chưa đúng']);
        } else {
        	DB::table('members')->where('id', '=', Session::get('member')['id'])
        	                    ->update(
        	                    	[
										'password'    => $newPassword
										
        	                    	]
        	                    );
            return redirect()->route('admin.getProfile')->with(['flash_level' => 'success', 'flash_message' => 'Mật khẩu của bạn đã được cập nhật']);
        }
    }
}
