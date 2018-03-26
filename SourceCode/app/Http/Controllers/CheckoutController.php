<?php

namespace App\Http\Controllers;

use App\Customer;
use App\District;
use App\Order;
use App\OrderDetail;
use App\Province;
use App\Ward;
use App\Size;
use App\ProductProperty;
use Auth;
use Cart;
use DB;
use Illuminate\Http\Request;


class CheckoutController extends Controller
{
    public function getDeliveryAddress()
    {
        $provinces         = Province::all();
        $data['provinces'] = $provinces;
        if (Auth::check()) {
            $ward_id             = Auth::user()->wardid;
            $district_id         = Ward::where('wardId', $ward_id)->first()->districtid;
            $province_id         = District::where('districtid', $district_id)->first()->provinceid;
            $districts           = District::where('provinceId', $province_id)->get();
            $wards               = Ward::where('districtId', $district_id)->get();
            $data['ward_id']     = $ward_id;
            $data['district_id'] = $district_id;
            $data['province_id'] = $province_id;
            $data['districts']   = $districts;
            $data['wards']       = $wards;
        }

        $cartItems = Cart::content();
        $total     = Cart::subtotal(0, '', '.');
        foreach($cartItems as $item){
            if($item->options->size){
                $size = Size::find($item->options->size);
                $item->size = $size->value;
            }
        }
        $data['cartItems'] = $cartItems;
        $data['total']     = $total;
        return view('user.checkout.delivery_address', $data);
    }


    public function checkout(Request $request)
    {

        $this->validate($request,
            [
                'name' => 'required',
                'ward' => 'required',
                'address' => 'required',
                'phone' => 'required|numeric',
                'email' => 'required|email'
            ],
            [
                'name.required' => 'Bạn phải nhập tên để thanh toán',
                'ward.required' => 'Bạn phải chọn xã',
                'address.required' => 'Bạn phải nhập địa chỉ thanh toán (số nhà, đường...)',
                'phone.required' => 'Bạn phải nhập số điện thoại',
                'phone.numeric' => 'Số điện thoại phải là số',
                'email.required' => 'Bạn phải nhập email',
                'email.email' => 'Email vừa nhập không đúng cú pháp',
            ]
        );

        $cartItems     = Cart::content();
        $customer      = new Customer;
        $customer_data = [
            'name'    => $request->name,
            'gender'  => $request->gender,
            'phone'   => $request->phone,
            'email'   => $request->email,
            'creator' => 1,
        ];
        $order = new Order;
        $order_data = [
            'date_order'       => Date('20y-m-d'),
            'delivery_address' => $request->address,
            'status_order'     => 0,
            'creator'          => 1,
            'ship_fee'         => 0,
            'wardid'           => $request->ward
        ];

        if(Auth::check()){
            $user_id = Auth::user()->id;
            $customer_data['user_id'] = $user_id;
        }


        $customer->create($customer_data);
        $customer_id =  DB::getPdo()->lastInsertId();
        $order_data['customer_id'] = $customer_id;
        $order->create($order_data);
        $order_id = DB::getPdo()->lastInsertId();
        $product_property = new ProductProperty;
        foreach($cartItems as $item){
            $size_id = $item->options->size;
            $size = Size::find($item->options->size);
            $order_detail = new OrderDetail;
            $order_detail_data = [
                'order_id'  => $order_id,
                'pro_id'    => $item->id,
                'qty'       => $item->qty,
                'status'    => 1,
                'size_id'      => $item->options->size
            ];
            $data['pro_id'] = $item->id;
            if(!empty($size)){
                $order_detail_data['size'] = $size_id;
                $data['size_id'] = $size_id;
            }

            $order_detail->create($order_detail_data);
            $product_property->updateQty($data, $item->qty);
        }
        Cart::destroy(); //thanh toán xong thì xóa hết sp trong giỏ
        return redirect()->route('getCartInfo')->with(['flash_level' => 'success', 'flash_message' => 'Cảm ơn bạn đã mua hàng của shop chúng tôi. Đơn hàng của bạn đã được gửi đi. Vui lòng kiểm tra thông tin đơn hàng để biết trạng thái đơn hàng!']);
    }
}
