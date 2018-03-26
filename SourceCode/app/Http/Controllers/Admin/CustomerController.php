<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Config;
use App\Customer;
use App\User;
use App\Order;


class CustomerController extends Controller
{
    public function getList () {
    	$customers = DB::table('customers')->orderBy('id', 'desc')->paginate(7);
    	foreach ($customers as $item) {
    		$item->order_exist = $this->checkExistOrder($item->id);
    	}
        $data['customers'] = $customers;

    	return view('admin.customer.list', $data);
    }

    public function getAdd ()
    {
        //lấy danh sách thành viên
    	$users = User::all();
    	$data['users'] = $users;
        return view('admin.customer.add', $data);
    }


    //Lấy thông tin theo user_id
    public function getInfoByUserId (Request $request)
    {
        $user = User::find($request->user_id);
        if(!empty($user)){
        	$response = [
				'email'  => $user->email,
				'name'   => $user->name,
				'gender' => $user->gender,
				'phone'  => $user->phone
        	];
            return response()->json($response);  //trả về ajax
        }
    }


    public function postAdd (Request $request)
    {
        $this->validate($request,
            [
                'email'       => 'required|email|unique:customers,email',
                'name'        => 'required|max:120',
                'gender'      => 'required',
                'phone'       => 'required|min:10|numeric'
            ],
            [
                'email.required'       => 'Vui lòng nhập email của bạn',
                'email.email'          => 'Không đúng định dạng email',
                'email.unique'         => 'Email này đã có người sử dụng',
                'name.required'        => 'Vui lòng nhập tên đầy đủ của bạn',
                'gender.required'      => 'Vui lòng chọn giới tính',
                'phone.required'       => 'Vui lòng nhập số điện thoại của bạn',
                'phone.min'            => 'Số điện thoại phải có ít nhất 10 chữ số',
                'phone.numeric'        => 'Số điện thoại chỉ bao gồm chữ số'
            ]
        );

        $customer = new Customer;
        if($request->user_id) {
        	$customer->user_id = $request->user_id;
        }
        $customer->email       = $request->email;
        $customer->name        = $request->name;
        $customer->gender      = $request->gender;
        $customer->phone       = $request->phone;
        $customer->save();

        return redirect()->route('admin.customer.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm khách hàng thành công']);
    }


    //Sửa thành viên
    public function getEdit ($id)
    {
        $customer  = Customer::find($id);
        $data['customer'] = $customer;

        return view('admin.customer.edit', $data);
    }

    public function postEdit (Request $request)
    {
        $id = $request->id;
        $this->validate($request,
            [
                'email'       => 'required|email',
                'name'        => 'required|max:120',
                'gender'      => 'required',
                'phone'       => 'required|min:10|numeric'
            ],
            [
                'email.required'       => 'Vui lòng nhập email của bạn',
                'email.email'          => 'Không đúng định dạng email',
                'name.required'        => 'Vui lòng nhập tên đầy đủ của bạn',
                'gender.required'      => 'Vui lòng chọn giới tính',
                'phone.required'       => 'Vui lòng nhập số điện thoại của bạn',
                'phone.min'            => 'Số điện thoại phải có ít nhất 10 chữ số',
                'phone.numeric'        => 'Số điện thoại chỉ bao gồm chữ số'
            ]
        );
        $customer              = Customer::find($id);
        $customer->name        = $request->name;
        $customer->gender      = $request->gender;
        $customer->phone       = $request->phone;

        $check = DB::table('customers')->where('email', '=', $request->email)->count();
        if ( ($request->email == $customer->email) || (($request->email != $customer->email) && ($check < 1)) ) {
            $customer->email   = $request->email;
            $customer->save();
            return redirect()->route('admin.customer.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa khách hàng thành công !']);
        } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Email này đã tồn tại !']);
        }

    }

    //Xóa khách hàng
    //Kiểm tra xem khách hàng đó có đơn hàng đang được giao ko? Nếu có đơn hàng ở trạng thái đang xử lý (1) và đang chuyển hàng (2) thì ko cho phép xóa, còn lại thì cho phép xóa
    public function checkExistOrder ($id) {
    	$order_amount = DB::table('orders')
                        ->where('customer_id', '=', $id)
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
			return redirect()->route('admin.customer.getList');
		}
		$customer = Customer::find($id);
        if (!empty($customer)) {
            //Xóa đơn hàng trạng thái 0,3,4
            $orders = DB::table('orders as o')
                        ->join('customers as c', 'o.customer_id', '=', 'c.id')
                        ->whereIn('status_order', [0,3,4])
                        ->get();
            foreach ($orders as $order) {
                //xóa chi tiết đơn hàng
                DB::table('order_details as od')->join('orders as o', 'od.order_id', '=', 'o.id')->where('order_id', '=', $order->id)->delete();
                //xóa đơn hàng
                Order::destroy($order->id);
            }
            $customer->delete();
        }
    	return redirect()->route('admin.customer.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa khách hàng thành công !']);
    }
}
