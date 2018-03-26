<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MemberRequest;
use App\Member;
use DB, Image, Config, Hash, File;


class MemberController extends Controller
{

	public function getList () {
		$members = DB::table('members')->where('level', '=', 1)->orderBy('id', 'desc')->paginate(7);

		foreach ($members as $item) {
			$id_ward  = $item->wardid;
			$ward     = DB::table('ward')->where('wardid', '=', $id_ward)->first();
			if($ward){
				$district = DB::table('district')->where('districtid', '=', $ward->districtid)->first();
	            $province = DB::table('province')->where('provinceid', '=', $district->provinceid)->first();
	            $item->full_address = $item->address . ' - ' . $ward->name . ' - ' . $district->name . ' - ' . $province->name;
			}else{
				$item->full_address = '';
			}
		}

		//phân trang
		$url = route('admin.member.getList');
		$members->setPath($url);

		return view('admin.member.list')->with(['members'=>$members]);
    }

    public function getAdd () {
		$data['year_arr']  = Config::get('constants.years');
		$data['month_arr'] = Config::get('constants.months');
		$data['day_arr']   = Config::get('constants.days');
		$provinces         = DB::table('province')->get();
		$data['provinces'] = $provinces;
    	return view('admin.member.add', $data);
    }

    public function postAdd (MemberRequest $request) {
		$member                = new Member;
		$date_arr              = explode('/', $request->start_date);
		$str                   = $date_arr[2].'-'.$date_arr[1].'-'.$date_arr[0];
		$member->start_date    = $str;
		$member->email         = $request->email;
		$member->password      = md5($request->password);
		$member->re_password   = md5($request->re_password);
		$member->name          = $request->name;
		$member->birthday      = $request->year . '-' . $request->month . '-' . $request->day;
		$member->gender        = $request->gender;
		$member->identity_card = $request->identity_card;
		$member->wardid        = $request->ward;
		$member->address       = $request->address;
		$member->phone         = $request->phone;
		$member->level         = $request->level;
		$member->save();

		//Xử lý hình ảnh
        $img_name = $request->file('fImages')->getClientOriginalName();
        $id       = $member->id;
        $img_dir  = 'resources/upload/images/member/' . $id;
        if (!file_exists($img_dir)) {
            mkdir($img_dir);
        }
        $img = Image::make($request->file('fImages')->getRealPath());
        $img->resize(100, 100)->save($img_dir . '/' .  $img_name);
        $member->image = $img_name;
        $member->save();

		return redirect()->route('admin.member.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm nhân viên thành công !']);
	}

	public function getEdit ($id) {
		$member       = Member::find($id);
		$birthday     = explode('-', $member->birthday);
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

		return view('admin.member.edit', $data);
    }

    public function postEdit (Request $request) {
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
	    	return redirect()->route('admin.member.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa nhân viên thành công !']);
	    } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Email này đã tồn tại !']);
        }

    }


    public function getDelete ($id) {
        $member = Member::findOrFail($id);
		//Xóa hình ảnh
        $img_dir = 'resources/upload/images/member/' . $id;
        $img     = $img_dir. '/' . $member->image;
        if (file_exists($img)) {
            File::delete($img);
        }
        if (file_exists($img_dir)) {
            rmdir($img_dir);
        }

        //Xóa thông tin còn lại
		$member->delete();
		return redirect()->route('admin.member.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa nhân viên thành công !']);
    }
}
