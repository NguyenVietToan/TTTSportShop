<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Export;
use App\Member;


class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['id', 'date_order', 'delivery_address', 'status_order', 'creator', 'ship_fee', 'customer_id', 'wardid', 'created_at', '  updated_at'];

    public function oder_detail ()
    {
        return $this->hasMany('App\OrderDetail', 'order_id');
    }


    //Lấy danh sách tất cả các đơn hàng: trả về tên KH, địa chỉ giao hàng, tổng giá trị, chi tiết (sp, size, qty...) của các đơn hàng
    public function getAll ()
    {
        $orders = $this->orderBy('created_at', 'DESC')->paginate(7);   //$this này chính là class Order

        foreach ($orders as $item) {
            //Lấy tên khách hàng
            $customer      = $this->getCustomer($item->customer_id);
            $customer_name = $customer->name;

            //Lấy địa chỉ giao hàng cụ thể
            $str_locate = $item->delivery_address . ' - ' . $this->getDeliveryAddress($item->wardid);

            //Lấy chi tiết đơn hàng
            $item->customer = $customer_name;
            $item->location = $str_locate;
            $sum_price = 0; //Tổng giá trị đơn hàng
            $order_details  = DB::table('order_details as od')
                            ->select('od.order_id','p.price','p.sale_price','od.qty')
                            ->join('products as p', 'p.id', '=', 'od.pro_id')
                            ->where('order_id', '=', $item->id)
                            ->get();
            foreach($order_details as $order_detail) {
                $price = $order_detail->price;
                if (!empty($order_detail->sale_price)) {  //nếu có giá KM
                    $price = $order_detail->sale_price;
                }
                $item->sum_price += $price*$order_detail->qty;
            }
        }
        return $orders;
    }


    //Lấy chi tiết 1 đơn hàng theo id: trả về tên sp, size, qty, đơn giá, tổng tiền, địa chỉ giao hàng
    public function getOrder ($id)
    {
        $order         = Order::find($id);
        $order_details = DB::table('order_details as od')
                        ->select('od.pro_id', 'pr.name', 'od.qty', 'od.status', 'pr.price','pr.sale_price','od.size_id')
                        ->join('products as pr', 'pr.id', '=', 'od.pro_id')
                        ->where('order_id', '=', $id)
                        ->get();
        $sum_price     = 0;
        foreach ($order_details as $item) {
            $price = $item->price;
            if (!empty($item->sale_price)) {  //nếu có giá KM
                $price = $item->sale_price;
            }
            $item->price = $price;

            if ($item->status == 1) {  //sp được giao thành công (detail_status_shipping)
                $sum_price  += $item->price * $item->qty;
            }

            $item->size  = '';  //sp ko có size
            if (!empty($item->size_id)) {  //nếu sp có size
                $size = Size::find($item->size_id);
                $item->size = $size->value;
            }
        }
        $order->data       = $order_details;
        $order->sum_price  = $sum_price;
        $order->str_locate = $order->delivery_address . ' - ' . $this->getDeliveryAddress($order->wardid);
        return $order;
    }


    //Lấy thông tin khách hàng theo id
    public function getCustomer ($id_customer)
    {
        $customer = DB::table('customers')->where('id', '=', $id_customer)->first();
        return $customer;
    }


    //Lấy địa chỉ dạng: xã - huyện - tỉnh theo wardid
    public function getDeliveryAddress ($wardid)
    {
        $ward = DB::table('ward')->where('wardid', '=', $wardid)->first();
        if (empty($ward)) {
            return '';
        }
        $district   = DB::table('district')->where('districtid', '=', $ward->districtid)->first();
        $province   = DB::table('province')->where('provinceid', '=', $district->provinceid)->first();
        $str_locate = $ward->name . ' - ' . $district->name . ' - ' . $province->name;
        return $str_locate;
    }


    //Shipper cập nhật lại trạng thái nhận của 1 sp là bị hủy (status = 0)
    public function returnProduct ($id)
    {
        DB::table('order_details')->where('pro_id','=',$id)
        ->update(['status' => 0]);
    }



    //Lấy ra tất cả đơn hàng đang ở trạng thái đang xử lý (status_order = 1) để phân công giao hàng
    public function getAllProccessing ()
    {
        $orders = $this->where('status_order', '=', 1)->orderBy('created_at', 'DESC')->get();

        foreach ($orders as $item) {
            $customer = $this->getCustomer($item->customer_id);

            $str_locate = $item->delivery_address . ' - ' . $this->getDeliveryAddress($item->wardid);

            $sum_price = 0;
            $order_details = DB::table('order_details as od')
                           ->join('products as p', 'p.id', '=', 'od.pro_id')
                           ->where('order_id', '=', $item->id)
                           ->get();
            foreach ($order_details as $sub_item) {
                $product      = Product::find($sub_item->pro_id);
                $actual_price = $product->sale_price ? $product->sale_price : $product->price;
                $sum_price    += $actual_price * $sub_item->qty;
            }

            $item->customer = $customer->name;
            $item->phone    = $customer->phone;
            $item->location = $str_locate;
        }

        return $orders;
    }


    //Lấy danh sách tất cả các đơn hàng cần giao đã được phân công
    public function getAllShippingOrder ()
    {
        $shippers    = Member::where('level', '=', 1)->get();

        $actual_ships = array();  //mảng lưu trữ tất cả các shipper đơn hàng
        foreach ($shippers as $item) {
            $id_customer = $item->id;
            //Lấy ra danh sách tất cả các đơn hàng (trạng thái đang chuyển hàng) được phân công tương ứng với shipper
            $orders = $this->join('exports', 'exports.order_id', '=', 'orders.id')
                           ->select('orders.id', 'orders.customer_id', 'orders.delivery_address', 'exports.status', 'orders.date_order', 'exports.order_id','orders.wardid')
                           ->where('exports.shipper_id', '=', $item->id)
                           ->where('orders.status_order', '=', 2)
                           ->get();
            foreach ($orders as $sub_item) {
                $customer           = $this->getCustomer($sub_item->customer_id);   //Lấy thông tin khách hàng theo id
                $sub_item->customer = $customer->name;

                $str_locate         = $sub_item->delivery_address . ' - ' . $this->getDeliveryAddress($sub_item->wardid);
                $sub_item->location = $str_locate;
            }
            $item->order = $orders;

            if(count($orders) > 0) {  //nếu có đơn hàng thì thêm shipper đó vào mảng
                $actual_ships[] = $item;
            }
        }
        return $actual_ships;
    }


    //Lấy ra đơn hàng đã được phân công cho một shipper xác định (đang chuyển hàng)
    public function getAssignedOrder ($shipper_id)
    {
        $assigned_orders = DB::table('orders')
                        ->join('exports', 'exports.order_id', '=', 'orders.id')
                        ->where('shipper_id', '=', $shipper_id)
                        ->where('orders.status_order', '=', 2)
                        ->where('exports.status', '=', 0)
                        ->get();

        foreach($assigned_orders as $item){
            $customer       = $this->getCustomer($item->customer_id);
            $str_locate     = $item->delivery_address . ' - ' . $this->getDeliveryAddress($item->wardid);
            $item->customer = $customer->name;
            $item->phone    = $customer->phone;
            $item->location = $str_locate;
        }
        return $assigned_orders;
    }


    //Hủy phân công của một đơn hàng đã đc phân công cho 1 shipper (status = 2 )
    public function deleteAssignedOrder ($order_id)
    {
        //Xóa phiếu xuất kho tương ứng với đơn hàng
        Export::where('order_id', '=', $order_id)->delete();
        $order = Order::find($order_id);
        $order->status_order = 1;  //trạng thái đơn hàng chuyển về đang xử lý
        $order->save();
    }
}