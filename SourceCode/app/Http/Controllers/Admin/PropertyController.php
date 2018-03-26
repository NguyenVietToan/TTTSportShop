<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductProperty;
use App\Product;
use App\Size;
use DB;


class PropertyController extends Controller
{
	public function getList(Request $request)
	{
        $data['keyword'] = $request->keyword;

        $properties = DB::table('product_properties as pp')
                      ->select('pp.*', 'pr.name as pr_name')
                      ->join('products as pr','pr.id','=','pp.pro_id')
                      ->where('pr.name', 'LIKE', '%'.$request->keyword.'%')
                      ->orderBy('pp.id', 'DESC')
                      ->paginate(7);
        foreach ($properties as $item) {
            $item->size = '';
            if(!empty($item->size_id)){
                $item->size = Size::find($item->size_id)->value;
            }
        }

        //phân trang
        $paginateUrl = route('admin.property.getList');

        $data['properties'] = $properties;
        $data['paginateUrl'] = $paginateUrl;

		return view('admin.property.list', $data);
	}

    public function getAdd ()
    {
        $products = DB::table('products')->orderBy('id', 'DESC')->get();   //hiển thị ra toàn bộ danh sách sản phẩm để chọn
        $data['products'] = $products;  //để khi muốn truyền nhiều biến sang view thì quản lý dễ dàng hơn
	    return view('admin.property.add')->with($data);
	}

    public function postAdd (Request $request)
    {
    	$this->validate($request,
            ["pro_id" => "required", "qty" => "required"],
            ["pro_id.required" => "Vui lòng chọn sản phẩm", "qty.required" => "Vui lòng nhập số lượng"]
        );
		$property          = new ProductProperty;
		$property->pro_id  = $request->pro_id;
		$property->size_id    = $request->size_id;
		$property->qty  = $request->qty;

        $check = DB::table('products as pr')
        ->join('product_properties as pp', 'pr.id', '=', 'pp.pro_id')
        ->where('pp.pro_id', '=', $property->pro_id)
        ->where('pp.size_id', '=', $property->size_id)
        ->count();
        if ($check >= 1) {
            return redirect()->route('admin.property.getAdd')->with(['flash_level' => 'danger', 'flash_message' => 'Bộ thuộc tính này đã tồn tại']);
        } else {
            $property->save();
            return redirect()->route('admin.property.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm thuộc tính cho sản phẩm thành công']);
        }
    }

    public function getEdit ($id)
    {
    	$property = ProductProperty::find($id);
        $product = Product::find($property->pro_id);
        $sizes = Size::where('cate_id', $product->cate_id)->get();
        $data['property'] = $property;
        $data['product'] = $product;
        $data['sizes'] = $sizes;
    	return view('admin.property.edit')->with($data);
    }

    public function postEdit (Request $request)
    {
        $id = $request->id;
    	$property = ProductProperty::find($id);
        // chỉ cập nhật trạng thái thì ok, các trường hợp khác phải check xem đã tồn tại bộ thuộc tính chưa
        if (($property->size_id != $request->size_id)) {

            $check = DB::table('products as pr')
            ->join('product_properties as pp', 'pr.id', '=', 'pp.pro_id')
            ->where('pp.pro_id', '=', $property->pro_id)
            ->where('pp.size_id', '=', $request->size_id)
            ->count();
            if ($check >= 1) {
                return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Bộ thuộc tính này đã tồn tại']);
            }
        }
        $input = $request->except(['_token']);
        $property->update($input);
        return redirect()->route('admin.property.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa thuộc tính cho sản phẩm thành công']);
    }

    public function delete_by_id ($id)
    {
    	$property = ProductProperty::find($id);
    	$property->delete();
    }

    public function getDelete ($id)
    {
        $this->delete_by_id($id);
        return redirect()->route('admin.property.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thuộc tính sản phẩm thành công !']);
    }

    public function postDelete (Request $request)
    {
        if($request->checks){
            foreach($request->checks as $item) {
                $this->delete_by_id($item);
            }
            return redirect()->route('admin.property.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thuộc tính sản phẩm thành công !']);
        } else {
            return redirect()->route('admin.property.getList')->with(['flash_level' => 'success', 'flash_message' => 'Không có mục nào được chọn để xóa !']);
        }
    }


    //Lấy size theo thể loại sản phẩm
    public function getSizeByCateId (Request $request)
    {
        $str = '<option value="" >Chọn kích cỡ</option>';
        $product = Product::find($request->pro_id);
        if (!empty($product)) {
            $cate_id = $product->cate_id;
            $sizes = Size::where('cate_id',$cate_id)->get();
            foreach($sizes as $size){
                $str .= '<option value="'.$size->id.'">'.$size->value.'</option>';
            }
            if (count($sizes) == 0) {
                $str = '';
            }
        }
        echo $str;
    }

    //lấy size cho việc tạo đơn hàng, chỉ lấy những size có số lượng khác 0
    public function getSizeByProIdExist (Request $request)
    {
        $str = '<option value="" >Chọn kích cỡ</option>';
        $product = Product::find($request->pro_id);
        $product_properties = ProductProperty::where('pro_id', '=', $request->pro_id)->where('qty', '>', 0)->get();
        $size_have_qtys = array();
        foreach($product_properties as $product_property){
            $size_have_qtys[] = $product_property->size_id;
        }
        if(!empty($product)){
            $sizes = Size::whereIn('id', $size_have_qtys)->get();
            foreach($sizes as $size){
                $str .= '<option value="'.$size->id.'">'.$size->value.'</option>';
            }
            if(count($sizes) == 0){
                $str = '';
            }
        }
        echo $str;  //return
    }

    //lấy số lượng tối đa còn lại
    public function getMaxQty(Request $request){
        $product_property = new ProductProperty;
        $data['pro_id'] = $request->pro_id;
        if(!empty($request->size_id)){
            $data['size_id'] = $request->size_id;
        }
        $maxQty = $product_property->getQty($data);
        $returnData = [
            'max_qty'   => $maxQty
        ];
        return response()->json($returnData);
    }

}
