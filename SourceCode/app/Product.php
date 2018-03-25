<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $table = 'products';

    protected $fillable = ['id', 'name', 'alias', 'price','sale_price', 'image', 'gender', 'description', 'cate_id', 'brand_id', 'sport_id', 'created_at', '  updated_at'];

    public function cate ()
    {
    	return $this->belongsTo('App\Category');   //1 sp thuộc về 1 loại sp
    }

    public function brand ()
    {
    	return $this->belongsTo('App\Brand');     //1 sp thuộc về 1 thương hiệu
    }

    public function sport ()
    {
    	return $this->belongsTo('App\Sport');     //1 sp thuộc về 1 môn thể thao
    }

    public function pro_image ()
    {
    	return $this->hasMany('App\ProductImage', 'pro_id');  //1 sp có nhiều hình ảnh sp
    }

    public function pro_property ()
    {
        return $this->hasMany('App\ProductProperty', 'pro_id');  //1 sp có nhiều thuộc tính sp
    }

    public function wish_list () {
        return $this->hasMany('App\WishList', 'pro_id');  //1 sp được yêu thích bởi nhiều người, wish_lists là bảng trung gian
    }

    public function review ()
    {
        return $this->hasMany('App\Review', 'pro_id');  //1 sp có nhiều đánh giá
    }
}
