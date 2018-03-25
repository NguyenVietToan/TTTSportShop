<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;


class ProductProperty extends Model
{
    protected $table = 'product_properties';

    protected $fillable = ['id', 'pro_id', 'size_id', 'qty'];

    public function product ()
    {
        return $this->belongsTo('App\Product');
    }


    //Lấy số lượng sp dựa vào điều kiện $where
    public function getQty ($where) {
        $product_property = DB::table('product_properties')->where($where)->first();
        if (empty($product_property)) {
            return 0;
        }
        return $product_property->qty;
    }


    //So sánh số lượng sp đặt hàng vs số lượng sp còn lại, nếu < thì hợp lệ, nếu > thì ko hợp lệ (ở đây $qty là số lượng đặt hàng)
    public function isValidQty ($where, $qty) {
        $available_qty = $this->getQty($where);
        if ($qty > $available_qty) {
            return false;
        }
        return true;
    }


    //Cập nhật số lượng sp
    //Ý tưởng: giả sử A có 7 sp ($before_qty), đầu tiên đặt 5 sp ($oldQty) --> lúc này $before_qty = 7-5=2, sau đó sửa thành 3 ($qty) -> số lượng sau cập nhật ($qty_after_update) = 2-3+5 = 4
    public function updateQty ($where, $qty, $oldQty = 0) {
        $before_qty = $this->getQty($where);
        $qty_after_update = $before_qty - $qty;
        if (!empty($oldQty)) {
            $qty_after_update += $oldQty;
        }
        DB::table('product_properties')
        ->where($where)
        ->update([
            'qty' => $qty_after_update
        ]);
    }

}
