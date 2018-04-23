<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CateRequest;
use App\Category;
use App\Product;
use App\ProductProperty;
use File;
use DB, Image, Config;

class CateController extends Controller
{
	public function getList ()
    {
        $cates = DB::table('categories')->orderBy('id', 'desc')->paginate(7);

        //phân trang
        $url = route('admin.cate.getList');
        $cates->setPath($url);

    	return view('admin.cate.list', compact('cates'));
    }

    public function getAdd ()
    {
    	return view('admin.cate.add');
    }

    public function postAdd (CateRequest $request)
    {
        $cate              = new Category;
        $cate->name        = $request->txtCateName;
        $cate->alias       = changeTitle($request->txtCateName);
        $cate->description = $request->txtDescription;
		$cate->save();
		return redirect()->route('admin.cate.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm thể loại thành công !']);
    }

    public function getEdit ($id)
    {
        $cate = Category::findOrFail($id);
        return view('admin.cate.edit', compact('cate'));
    }

    public function postEdit (Request $request)
    {
        $id = $request->id;
        $this->validate($request,
            ['txtCateName' => 'required'],
            ['txtCateName.required' => 'Vui lòng nhập tên thể loại']
        );  //dùng hàm validate() mặc định của Laravel để kiểm tra dữ liệu thì không cần tạo request mới
        $cate              = Category::findOrFail($id);
        $cate->description = $request->txtDescription;

        //nếu ko sửa tên thì cho phép sửa
        //nếu có sửa tên thì phải kiểm tra xem tên đó đã tồn tại chưa, nếu chưa thì cho phép sửa
        $check = DB::table('categories as ct')->where('ct.name', '=', $request->txtCateName)->count();
        if ( ($request->txtCateName == $cate->name) || (($request->txtCateName != $cate->name) && ($check < 1)) ) {
            $cate->name  = $request->txtCateName;
            $cate->alias = changeTitle($request->txtCateName);
            $cate->save();
            return redirect()->route('admin.cate.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa thể loại thành công !']);
        } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Thể loại sản phẩm này đã tồn tại !']);
        }
    }

    public function delete_by_id ($id)
    {
        $cate = Category::find($id);

        //Xóa sản phẩm tương ứng với thể loại được chọn
        $product = Product::where('cate_id', '=', $id)->get();

        if (isset($product)) {
            foreach ($product as $pro) {
                $pro_id = $pro->id;  //lấy id của sản phẩm

                //Xóa ảnh chi tiết của sản phẩm
                $main_dir = 'resources/upload/images/product';
                $lg_dir   = $main_dir . '/large/' . $pro_id;
                $sm_dir   = $main_dir . '/small/' . $pro_id;
                $thn_dir  = $main_dir . '/thumbnail/' . $pro_id;

                $lg_detail_dir  = $lg_dir . '/detail';
                $sm_detail_dir  = $sm_dir . '/detail';
                $thn_detail_dir = $thn_dir . '/detail';

                $product_images = DB::table('product_images')->where('pro_id', $pro_id)->get();
                foreach ($product_images as $images) {
                    $lg_detail_img  = $lg_detail_dir . '/' . $images->name;
                    $sm_detail_img  = $sm_detail_dir . '/' . $images->name;
                    $thn_detail_img = $thn_detail_dir . '/' . $images->name;
                    if (file_exists($lg_detail_img)) {
                        File::delete($lg_detail_img);
                    }
                    if (file_exists($sm_detail_img)) {
                        File::delete($sm_detail_img);
                    }
                    if (file_exists($thn_detail_img)) {
                        File::delete($thn_detail_img);
                    }
                }

                //Xóa thư mục detail
                if (file_exists($lg_detail_dir)) {
                    rmdir($lg_detail_dir);
                }
                if (file_exists($sm_detail_dir)) {
                    rmdir($sm_detail_dir);
                }
                if (file_exists($thn_detail_dir)) {
                    rmdir($thn_detail_dir);
                }

                //Xóa thuộc tính sản phẩm
                $product_properties = ProductProperty::where('pro_id', '=', $pro_id)->get();
                foreach ($product_properties as $properties) {
                    $properties->delete();
                }

                $products = Product::findOrFail($pro_id);
                //Xóa ảnh đại diện
                $lg_img  = $lg_dir . '/' . $products->image;
                $sm_img  = $sm_dir . '/' . $products->image;
                $thn_img = $thn_dir . '/' . $products->image;
                if (file_exists($lg_img)) {
                    File::delete($lg_img);
                }
                if (file_exists($sm_img)) {
                    File::delete($sm_img);
                }
                if (file_exists($thn_img)) {
                    File::delete($thn_img);
                }


                //Xóa thư mục id
                if (file_exists($lg_dir)) {
                    rmdir($lg_dir);
                }
                if (file_exists($sm_dir)) {
                    rmdir($sm_dir);
                }
                if (file_exists($thn_dir)) {
                    rmdir($thn_dir);
                }

                //Xóa dữ liệu còn lại
                $products->delete();
            }
        }

        //Xóa thông tin còn lại
        $cate->delete();
    }

    public function getDelete($id)
    {
        $this->delete_by_id($id);
        return redirect()->route('admin.cate.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thể loại thành công !']);
    }

    public function postDelete (Request $request)
    {
        //nếu có tích chọn xóa theo checkbox
        if($request->checks){
            foreach($request->checks as $item) {
                $this->delete_by_id($item);
            }
            return redirect()->route('admin.cate.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thể loại thành công !']);
        } else {
            return redirect()->route('admin.cate.getList')->with(['flash_level' => 'warning', 'flash_message' => 'Không có mục nào được chọn để xóa !']);
        }
    }

}
