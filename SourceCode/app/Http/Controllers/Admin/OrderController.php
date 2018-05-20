<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\District;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use App\SaleCode;
use App\Product;
use App\ProductProperty;
use App\Province;
use App\Size;
use App\Ward;
use DB;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    //Danh sách đơn hàng
    public function getList()
    {
        $orders = new Order;
        $orders = $orders->getAll(); //phương thức getAll() viết trong Order.php
        $orders->setPath(route('admin.order.getList'));
        $data['orders'] = $orders;
        return view('admin.order.list', $data);
    }


    //Thêm đơn hàng
    public function getAdd()
    {
        $data['products']  = Product::orderBy('name')->get();
        $data['customers'] = Customer::orderBy('id', 'desc')->get();
        $data['provinces'] = DB::table('province')->get();
        return view('admin.order.add', $data);
    }

    public function postAdd(Request $request)
    {
        $pro_ids  = $request->pro_ids;
        $sizes    = $request->sizes;
        $qtys     = $request->qtys;

        $order      = new Order;
        $order_data = [
            'date_order'       => Date('20y-m-d'),
            'delivery_address' => $request->address,
            'status_order'     => 1, //đơn hàng do admin tạo thì trạng thái đầu tiên là đang xử lý
            'creator'          => 2,
            'ship_fee'         => 0,
            'wardid'           => $request->ward,
            'customer_id'      => $request->customer_id,
        ];
        $order->create($order_data);  //tạo đơn hàng
        $order_id = DB::getPdo()->lastInsertId();  //lấy id của order đc thêm mới nhất (thằng cuối cùng)

        $product_property = new ProductProperty;

        foreach ($pro_ids as $key => $item) {
            if ($item == 0) {  //khi ko chọn sp nào để thêm vào thì thoát ngay ko cho thêm
                continue;
            }

            $data = [
                'pro_id' => $item,
            ];
            $qty = $qtys[$key];
            if ($sizes[$key] != -1) {  //ko có size thì đặt cho nó giá trị = -1, nếu để = 0 thì ko đc, ko hiểu sao nó ko nhận
                $data['size_id'] = $sizes[$key];
            }

            //thêm chi tiết đơn hàng
            $order_detail      = new OrderDetail;
            $order_detail_data = [
                'order_id' => $order_id,
                'pro_id'   => $item,
                'qty'      => $qty,
                'status'   => 1,
            ];
            if ($sizes[$key] != -1) {
                $order_detail_data['size_id'] = $sizes[$key];
            }
            $order_detail->create($order_detail_data);

            //cập nhật lại số lượng mặt hàng còn lại
            $product_property->updateQty($data, $qty);

        }
        return redirect(route('admin.order.getList'));
    }


    //Khi ở mức đang chuyển hàng trở lên:
    //Nếu đang ở trạng thái đang chuyển hàng, có thể sửa thành trạng thái đã hoàn thành hoặc đã hủy
    //Nếu đã ở trạng thái đã hoàn thành hoặc đã hủy thì không thể sửa;
    //Khi đơn hàng đang ở trạng thái đang xử lý:
    //Nếu đơn hàng là do người quản lý tạo thì người đó có thể được phép thay đổi cả trạng thái lẫn thông tin của đơn hàng
    //Nếu đơn hàng do khách hàng tạo, thì người quản lý chỉ có thể thay đổi trạng thái
    //Khi đơn hàng ở trạng thái chờ xử lý, người quản lý có thể thay đổi nó thành các trạng thái là: đơn hàng ảo hoặc là chuyển sang trạng thái đang xử lý
    public function getEdit($id)
    {
        $order = new Order;
        $order = $order->getOrder($id);
        if ($order->status_order == 4 || $order->status_order == 3) {
            return redirect(route('admin.order.getList'));
        }
        $ward     = DB::table('ward')->where('wardid', '=', $order->wardid)->first();
        $district = DB::table('district')->where('districtid', '=', $ward->districtid)->first();
        $province = DB::table('province')->where('provinceid', '=', $district->provinceid)->first();

        $order_details = $order->data;
        $product_property = new ProductProperty;
        foreach ($order->data as $order_detail) {
            $product            = Product::find($order_detail->pro_id);
            $product_properties = ProductProperty::where('pro_id', '=', $order_detail->pro_id)->where('qty', '>', 0)->get();
            $size_have_qtys = array();  //Mảng dùng để lưu những size còn hàng của sản phẩm
            foreach ($product_properties as $product_property) {
                $size_have_qtys[] = $product_property->size_id;
            }

            if ($order_detail->size_id) {  //có size
                $size_have_qtys[] = $order_detail->size_id;
            }
            $sizes = Size::whereIn('id', $size_have_qtys)->get();   //Lấy ra size hợp lệ (còn hàng) của sản phẩm được đặt hàng hiện tại
            $order_detail->options = $sizes;
            $data = [
                'pro_id' => $order_detail->pro_id
            ];

            //tìm số lượng lớn nhất còn lại = số lượng còn lại hiện tại + số lượng đặt hàng trước khi sửa
            if ($order_detail->size_id) {
                $data['size_id'] = $order_detail->size_id;
            }
            $order_detail->maxQty = $product_property->getQty($data) + $order_detail->qty;
        }
        $data['order']    = $order;
        $data['ward']     = $ward;
        $data['district'] = $district;
        $data['province'] = $province;
        $data['customer'] = Customer::find($order->customer_id);
        if ($order->creator == 2) {
            $data['customers'] = Customer::orderBy('name')->get();
            $data['products']  = Product::orderBy('name')->get();
            $data['provinces'] = Province::all();
            $data['districts'] = District::all();
            $data['wards']     = Ward::all();
        }
        return view('admin.order.edit', $data);
    }

    public function postEdit(Request $request)
    {
        $order = Order::find($request->id);
        //Kiểm tra xem dơn hàng là do người bán hàng tạo hay khách tạo
        if ($order->creator == 1) {
            $order->status_order = $request->status_order;

            //Trả lại mặt hàng đã đặt của khách hàng vào kho nếu đơn hàng là đơn hàng ảo hoặc đã bị hủy
            if ($order->status_order == 4) {
                //Trả lại sản phẩm
                $this->returnProduct($order->id);
                //Cập nhật lại chi tiết đơn hàng
                OrderDetail::where('order_id','=', $order->id)->update([
                    'status'=> 0
                ]);
            }else if($order->status_order == 3){
                $this->returnSuccessProduct($order->id);
            }
            $order->save();
            return redirect(route('admin.order.getList'));
        } else {


            if ($order->status_order == 1) {
                $product_property = new ProductProperty;


                $order_update_data = [
                    'customer_id'      => $request->customer_id,
                    'wardid'           => $request->ward,
                    'delivery_address' => $request->delivery_address,
                    'status_order'     => $request->status_order
                ];
                $order->update($order_update_data);
                $order_detail_old_sizes = $request->order_detail_old_sizes;
                $order_detail_sizes     = $request->order_detail_sizes;
                $order_detail_qtys      = $request->order_detail_qtys;

                //chi tiết sửa
                foreach ($request->order_detail_products as $key => $item) {
                    $pro_id      = $item;
                    $old_size_id = $order_detail_old_sizes[$key];   //số lượng mặt hàng này được đặt trước đó
                    $size_id     = $order_detail_sizes[$key];
                    $qty         = $order_detail_qtys[$key];
                    $where       = [
                        'order_id' => $order->id,
                        'pro_id'   => $pro_id,
                    ];
                    $update_data = [
                        'qty' => $qty,
                    ];
                    if ($old_size_id != -1) {
                        $where['size_id']       = $old_size_id;
                        $update_data['size_id'] = $size_id;
                    }
                    $order_detail = OrderDetail::where($where)->first();
                    $oldQty = $order_detail->qty;   //Số lượng mà mặt hàng này được đặt trước đó

                    OrderDetail::where($where)->update($update_data);

                    $data = [
                        'pro_id'    => $pro_id
                    ];
                    if ($old_size_id != -1) { //Trường hợp có size
                        $data['size_id'] = $old_size_id;
                        //Trường hơp size trước và sau cập nhật là như nhau
                        if ($old_size_id == $size_id) {
                            $product_property->updateQty($data, $qty, $oldQty); //Cập nhật số lượng mặt hàng
                        }else{
                            //cập nhật lại số lượng sản phẩm với size cũ
                            $product_property->updateQty($data, 0, $oldQty);
                            //cập nhật lại số lượng sản phẩm với size mới
                            $data['size_id'] = $size_id;
                            $product_property->updateQty($data, $qty, 0);
                        }
                        //Trường hợp size trước và sau cập nhật khác nhau

                    } else {  //Trường hợp không có size
                        //Cập nhật lại số lượng mặt hàng
                        $product_property->updateQty($data, $qty, $oldQty);
                    }
                }

                //chi tiết thêm mới
                if ($request->check_has_new_detail == 1) {
                    $pro_ids = $request->pro_ids;
                    $sizes   = $request->sizes;
                    $qtys    = $request->qtys;
                    foreach ($pro_ids as $key => $item) {
                        $qty = $qtys[$key];
                        $order_detail      = new OrderDetail;
                        $order_detail_data = [
                            'order_id' => $order->id,
                            'pro_id'   => $item,
                            'qty'      => $qty,
                            'status'   => 1,
                        ];
                        $data['pro_id'] = $qty;
                        if ($sizes[$key] != -1) {
                            $order_detail_data['size_id'] = $sizes[$key];
                            $data['size_id'] = $sizes[$key];
                        }
                        $order_detail->create($order_detail_data);

                        //Cập nhật lại số lượng mặt hàng còn lại
                        $product_property->updateQty($data, $qty);
                    }
                }

            }else if($order->status_order == 2){
                $order_update_data = [
                    'status_order'     => $request->status_order
                ];
                $order->update($order_update_data);
            }
            if($request->status_order == 3){
                $this->returnSuccessProduct($order->id);
            }else if($request->status_order == 4){
                //Trả lại sản phẩm
                $this->returnProduct($order->id);
                //Cập nhật lại chi tiết đơn hàng
                OrderDetail::where('order_id','=', $order->id)->update([
                    'status'=> 0]);
            }

            return redirect(route('admin.order.getList'));
        }

    }

    public function delete($id)
    {
        $order = Order::find($id);
        if (!empty($order)) {
            //Trả lại số lượng sản phẩm đã đặt, chính là cập nhật lại số lượng với số lượng đặt mới bằng 0 và số lượng đặt cũ là chính bằng số lượng đã đặt

            $this->returnProduct($id);
            OrderDetail::where('order_id', $id)->delete();
        }
        $order->delete();

    }

    //Cập nhật lại sp khi amin click xác nhận đơn hàng thành công nhưng có 1 phần sp trong đơn hàng bị hủy
    public function returnSuccessProduct($order_id) {
        $product_property = new ProductProperty;
        $order_details = OrderDetail::where('order_id', $order_id)->where('status', '=', 0)->get();
        foreach ($order_details as $order_detail) {
            $data = [
                'pro_id'    => $order_detail->pro_id
            ];
            if (!empty($order_detail->size_id)) {
                $data['size_id'] = $order_detail->size_id;
            }
            $qty = $order_detail->qty;
            $product_property->updateQty($data, 0, $qty);
        }

    }

    //Cập nhật lại số lượng sp khi admin click xác nhận hủy toàn bộ đơn hàng (hủy ngay từ đầu hoặc khi shipper giao hàng xong mà cả đơn hàng bị giao không thành công)
    public function returnProduct($order_id) {
        $product_property = new ProductProperty;
        $order_details = OrderDetail::where('order_id', $order_id)->get();
        foreach ($order_details as $order_detail) {
            $data = [
                'pro_id'    => $order_detail->pro_id
            ];
            if (!empty($order_detail->size_id)) {
                $data['size_id'] =$order_detail->size_id;
            }
            $qty = $order_detail->qty;
            $product_property->updateQty($data, 0, $qty);
        }
    }


    public function getDelete($id)
    {
        $this->delete($id);
        return redirect(route('admin.order.getList'));
    }

    public function postDelete(Request $request)
    {
        if ($request->get("checks")) {
            foreach ($request->get("checks") as $item) {
                $this->delete($item);
            }
        return redirect(route('admin.order.getList'))->with(['flash_level' => 'success', 'flash_message' => 'Xóa đơn hàng thành công']);
        
        } else {
            return redirect()->route('admin.order.getList')->with(['flash_level' => 'warning', 'flash_message' => 'Không có mục nào được chọn để xóa']);
        }
    }

    //Sử dụng cho việc xem chi tiết đơn hàng
    public function getDetail($id){
        $order = new Order;
        $order = $order->getOrder($id);
        //Lấy danh sách các mặt hàng đã đặt
        $product_ordered = $order->data;

        //Lấy tên khách hàng
        $customer = DB::table('customers')->where('id','=',$order->customer_id)->first();
        $order->customer = $customer->name;
        $order->phone = $customer->phone;
        $order->email = $customer->email;
        $order->gender = $customer->gender;

        //Lấy địa chỉ giao hàng
        $str_locate = $order->delivery_address . ' - ' . $order->getDeliveryAddress($order->wardid);
        $order->address = $str_locate;
        return view('admin.order.detail')->with(['order' => $order]);
    }
}