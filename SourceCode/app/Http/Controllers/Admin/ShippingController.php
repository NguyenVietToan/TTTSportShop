<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Member;
use App\Export;
use Input;

class ShippingController extends Controller
{

	//Hiển thị danh sách các đơn hàng được phân công cho từng shipper
	public function getList() {
		$orders = new Order;
		$order_ships = $orders->getAllShippingOrder();
		$data['order_ships'] = $order_ships;
		return view('admin.shipping.list', $data);
	}


	//Phân công giao hàng
	public function getAssign() {
		//Lấy danh sách shipper
		$shippers = Member::where('level', '=', 1)->get();

		//Lấy danh sách đơn hàng cần phân công
		$orders = new Order;
		$orders = $orders->getAllProccessing();
		$data['shippers'] = $shippers;
		$data['orders'] = $orders;
		return view('admin.shipping.assign', $data);
	}

	public function postAssign(Request $request) {
		$shipper_id = $request->shipper_id;
		$order_ids = $request->order_ids;
		if($order_ids) {  //nếu có click vào chọn để phân công
			foreach($order_ids as $item) {
				$order = Order::find($item);
				$order->status_order = 2;	//chuyển sang trạng thái đang chuyển hàng
				$order->save();

				$export = new Export;
				$export->order_id = $item;
				$export->shipper_id = $shipper_id;
				$export->status = 0;	//chưa hoàn thành
				$export->save();
			}
		}
		return redirect('admin/shipping/list');
	}


	//Cập nhật: giống phân công
	public function getUpdate($id) {
		$member = Member::find($id);
		$order = new Order;
		$assigned_orders = $order->getAssignedOrder($id);  //lấy đơn hàng đã đc phân công cho shipper
		$orders = $order->getAllProccessing(); //Lấy tất cả các đơn hàng cần giao

		$data['member'] = $member;
		$data['assigned_orders'] = $assigned_orders;
		$data['orders'] = $orders;
		return view('admin.shipping.update', $data);
	}


	public function postUpdate(Request $request) {
		$shipper_id = $request->shipper_id;
		$order_ids = $request->order_ids;
		if($order_ids){
			foreach ($order_ids as $item) {
				$order = Order::find($item);
				$order->status_order = 2;	//chuyển sang trạng thái đang chuyển hàng
				$order->save();

				$export = new Export;
				$export->order_id = $item;
				$export->shipper_id = $shipper_id;
				$export->status = 0;	//chưa hoàn thành
				$export->save();
			}

		}
		return redirect('admin/shipping/list');
	}


	//Hủy phân công một người giao hàng cho một đơn hàng
	public function postDelete (Request $request) {
		$order_id = $request->order_id;
		$order = new Order;
		//Xóa phân công giao hàng
		$order->deleteAssignedOrder($order_id);
		return "Ok";
	}
}
