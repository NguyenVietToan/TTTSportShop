<?php

namespace App\Http\Controllers\Shipper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Member;
use App\Order;
use DB, Auth, Config, Image, File;


class ShipperController extends Controller
{
	//Trang chủ shipper
	public function index () {
		//đếm số đơn hàng đc phân công
		$deliveried_order = DB::table('orders as o')
							->select('o.*', 'ep.shipper_id')
							->join('exports as ep', 'o.id', '=', 'ep.order_id')
							->where('shipper_id', '=', Session::get('member')['id'])
							->where('o.status_order', '=', '2')
							->where('ep.status', '=', '0')
							->count();
		//đếm số đơn hàng chờ xác nhận
		$waitingAccepted_order = DB::table('orders as o')
							->select('o.*', 'ep.shipper_id')
							->join('exports as ep', 'o.id', '=', 'ep.order_id')
							->where('shipper_id', '=', Session::get('member')['id'])
							->where('o.status_order', '=', '2')
							->where('ep.status', '=', '1')
							->count();

		//đếm số đơn hàng đã hoàn thành
		$completed_order = DB::table('orders as o')
							->select('o.*', 'ep.shipper_id')
							->join('exports as ep', 'o.id', '=', 'ep.order_id')
							->where('shipper_id', '=', Session::get('member')['id'])
							->whereIn('o.status_order', [3,4])
							->where('ep.status', '=', '1')
							->count();

		$data['deliveried_order'] = $deliveried_order;
		$data['waitingAccepted_order'] = $waitingAccepted_order;
		$data['completed_order'] = $completed_order;
		return view('shipper.home', $data);
	}


//-------------------------------------------------------------------------------------------
	//Hiển thị danh sách đơn hàng được phân công
	public function getProcessing() {
		$shipper = Session::get('member');
		$shipper_id = $shipper['id'];

		//Lấy danh sách những đơn hàng tương ứng với người giao hàng này được phân công mà chưa giao
		$orders =$this->getDeliveriedOrder($shipper_id);

		$url = route('shipper.getProcessing');
		$orders->setPath($url);
		$data['orders'] = $orders;
		return view('shipper.pages.processing', $data);
	}


	//Hiển thị danh sách đơn hàng chờ xác nhận
	public function getWaitingAccepted () {
		$shipper = Session::get('member');
		$shipper_id = $shipper['id'];

		$orders =$this->getWaitingAcceptedOrder($shipper_id);
		$url = route('shipper.getWaitingAccepted');
		$orders->setPath($url);
		$data['orders'] = $orders;
		return view('shipper.pages.waiting-accepted', $data);
	}


	//Hiển thị danh sách đơn hàng đã hoàn thành
	public function getHistory () {
		$shipper = Session::get('member');
		$shipper_id = $shipper['id'];

		$orders =$this->getHistoryOrder($shipper_id);
		$url = route('shipper.getHistory');
		$orders->setPath($url);
		$data['orders'] = $orders;
		return view('shipper.pages.history', $data);
	}


	//Lấy danh sách những đơn hàng được phân công mà chưa giao theo từng shipper
	public function getDeliveriedOrder ($shipper_id) {
		$data = [
			'shipper_id'    => $shipper_id,
			'export_status' => 0
		];
		return $this->getShippingOrder($data);
	}


	//Lấy danh sách những đơn hàng đã được shipper giao và đang chờ admin xác nhận (khi đó status_order=2)
	public function getWaitingAcceptedOrder ($shipper_id) {
		$data = [
			'shipper_id'    => $shipper_id,
			'export_status' => 1,
			'order_status'  => [2]  //đang chuyển hàng
		];
		return $this->getShippingOrder($data);
	}


	//Lấy danh sách những đơn hàng đã được shipper giao thành công (admin đã xác nhận)
	public function getHistoryOrder ($shipper_id) {
		$data = [
			'shipper_id'   => $shipper_id,
			'order_status' => [3,4]  //đã thành công hoặc đã hủy
		];
		return $this->getShippingOrder($data);
	}


	//Lấy ra các đơn hàng theo điều kiện đầu vào $data
	private function getShippingOrder ($data = array()) {
		$shipper = Member::find($data['shipper_id']);
		if (!empty($shipper) && $shipper->level != 1) {
			return;
		}

		//Lấy ra tất cả đơn hàng chưa được chuyển hàng xong của shipper
		$orders = DB::table('orders')
		          ->join('exports','orders.id','=','exports.order_id')
		          ->select(['orders.customer_id', 'orders.wardid', 'orders.delivery_address', 'exports.status', 'orders.status_order', 'orders.date_order', 'exports.order_id'])
		          ->where('exports.shipper_id', '=', $data['shipper_id']);
		if (isset($data['export_status'])) {
			$orders = $orders->where('exports.status', '=', $data['export_status']);
		}
		if (isset($data['order_status'])) {
			$orders = $orders->whereIn('orders.status_order', $data['order_status']);
		}
		$orders = $orders->orderBy('date_order', 'desc')->paginate(7);

		//Lấy thông tin chi tiết từng đơn hàng
		 foreach ($orders as $item) {
			$order_inner   = new Order;
			$customer      = $order_inner->getCustomer($item->customer_id);
			$customer_name = $customer->name;
			$str_locate    = $item->delivery_address . ' - ' . $order_inner->getDeliveryAddress($item->wardid);
            //Dữ liệu chi tiết cho mỗi đơn hàng
            $data = array();
            $sum_price = 0;
            //Lấy ra một mảng các bản ghi tương ứng với mỗi đơn hàng
            $order_details = DB::table('order_details')->join('products','products.id','=','order_details.pro_id')->where('order_id','=',$item->order_id)->get();
            foreach($order_details as $sub_item){
				$price     = !empty($sub_item->sale_price) ? $sub_item->sale_price : $sub_item->price;
				$sum_price += $price*$sub_item->qty;
            }

			$item->customer  = $customer_name;
			$item->location  = $str_locate;
			$item->sum_price = $sum_price;
        }
        return $orders;
	}


	//Xem chi tiết đơn hàng
    public function getDetail($id) {
		$order = new Order;
		$order = $order->getOrder($id);
		//Lấy danh sách các mặt hàng đã đặt
		$product_ordered = $order->data;

		$customer        = DB::table('customers')->where('id','=',$order->customer_id)->first();
		$order->customer = $customer->name;
		$order->phone    = $customer->phone;
		$order->email    = $customer->email;
		$order->gender   = $customer->gender;

        $str_locate = $order->delivery_address . ' - ' . $order->getDeliveryAddress($order->wardid);
        $order->address = $str_locate;

		return view('shipper.pages.detail')->with(['order'=>$order]);
	}


	public function getEdit ($id) {
		$order_details = $this->getShipperUpdateOrderDetail($id);
		//Lấy danh sách các mặt hàng đã đặt
		$data['order_details'] = $order_details;
		return view('shipper.pages.update', $data);
	}


	//Lấy chi tiết đơn hàng, sử dụng cho cập nhật của shipper
    public function getShipperUpdateOrderDetail ($id) {
        $order_details = DB::table('order_details as od')->join('products as p','p.id','=','od.pro_id')->leftJoin('sizes as s', 's.id','=','od.size_id')->select(['od.order_id','p.name','od.pro_id','od.qty','od.status','od.order_id','p.price', 'od.size_id', 's.value'])->where('order_id','=',$id)->get();
        return $order_details;
    }


    //Sửa trạng thái nhận hàng
	public function postEdit (Request $request) {
		if($request->get('received_status')){
			$status = $request->get('received_status');
			foreach($status as $item){
				$id_arr = explode('-',$item);
				$where = [
					'order_id'	=> $id_arr[0],
					'pro_id'	=> $id_arr[1]
				];

				if(!empty($id_arr[2])){
					$where['size_id']	= $id_arr[2];
				}
				$update_data = [
					'status'	=> $id_arr[3]
				];
				DB::table('order_details')->where($where)->update($update_data);
			}
		}
		return redirect(route('shipper.getProcessing'));
	}


	//Shipper chọn Xác nhận đã chuyển hàng
	public function postAccept(Request $request){
		$order_ids = $request->order_ids;
		if ($order_ids) {
			foreach ($order_ids as $item) {
				//cập nhật trạng thái của phiếu xuất kho từ chưa hoàn thanh lên đã hoàn thành (từ 0 lên 1)
				DB::table('exports')->where('order_id', '=', $item)
				->update(['status'=>1]);
			}
		}
		return redirect(route('shipper.getProcessing'));
	}


	//Hiển thị thông tin cá nhân
	public function getProfile () {
		$shipper  = DB::table('members')->where('id', '=', Session::get('member')['id'])->first();
		$ward     = DB::table('ward')->where('wardid', '=', $shipper->wardid)->first();
		$district = DB::table('district')->where('districtid', '=', $ward->districtid)->first();
		$province = DB::table('province')->where('provinceid', '=', $district->provinceid)->first();
        $shipper->full_address = $shipper->address . ' - ' . $ward->name . ' - ' . $district->name . ' - ' . $province->name;
		$data['shipper'] = $shipper;
		return view('shipper.pages.profile', $data);
	}


	//Cập nhật thông tin cá nhân
	public function getEditInfo()
	{
		$shipper      = DB::table('members')->where('id', '=', Session::get('member')['id'])->first();
		$birthday     = explode('-', $shipper->birthday);
		$ward         = DB::table('ward')->where('wardid', '=', $shipper->wardid)->first();
		$wards        = DB::table('ward')->where('districtid', '=', $ward->districtid)->get();
		$district     = DB::table('district')->where('districtid', '=', $ward->districtid)->first();
		$districts    = DB::table('district')->where('provinceid', '=', $district->provinceid)->get();
		$province     = DB::table('province')->where('provinceid', '=', $district->provinceid)->first();
		$provinces    = DB::table('province')->get();
		$location     = array();  //tạo mảng location để chứa 3 giá trị đó là wardid, districtid và provinceid
		$location[]   = $shipper->wardid;  //$location[0]
		$location[]   = $ward->districtid;  //$location[1]
		$location[]   = $district->provinceid; //$location[2]
		$full_address = $shipper->address;

		$data['shipper']      = $shipper;
		$data['birthday']     = $birthday;
        $data['year_arr']     = Config::get('constants.years');
        $data['month_arr']    = Config::get('constants.months');
        $data['day_arr']      = Config::get('constants.days');
		$data['provinces']    = $provinces;
		$data['districts']    = $districts;
		$data['wards']        = $wards;
		$data['location']     = $location;
		$data['full_address'] = $full_address;
		return view('shipper.pages.update_profile', $data);
	}


	public function postEditInfo (Request $request)
    {
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
	    	return redirect()->route('shipper.getProfile')->with(['flash_level' => 'success', 'flash_message' => 'Cập nhật thông tin cá nhân thành công !']);
	    } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Email này đã tồn tại !']);
        }
    }


    //Đổi mật khẩu
    public function getPassword () {
        return view('shipper.pages.update_password');
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
										'password'    => $newPassword,
										're_password' => $re_newPassword
        	                    	]
        	                    );
            return redirect()->route('shipper.getProfile')->with(['flash_level' => 'success', 'flash_message' => 'Mật khẩu của bạn đã được cập nhật']);
        }
    }
}
