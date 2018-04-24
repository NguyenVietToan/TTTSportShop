<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Brand;
use App\Http\Requests\Admin\BrandRequest;
use File;
use App\Product;
use App\ProductProperty;
use DB, Image, Config;


class BrandController extends Controller
{
	public function getList ()
	{
		$brands = DB::table('brands')->orderBy('id', 'desc')->paginate(7);

        //phân trang
        $url = route('admin.brand.getList');
        $brands->setPath($url);

		return view('admin.brand.list', compact('brands'));
	}

    public function getAdd ()
    {
    	return view('admin.brand.add');
    }

    public function postAdd (BrandRequest $request)
    {
		$brand              = new Brand;
		$brand->name        = $request->txtBrandName;
        $brand->alias       = changeTitle($request->txtBrandName);
		$brand->description = $request->txtDescription;
        $brand->save();

        //Xử lý ảnh logo thương hiệu
        $img_name = $request->file('fImages')->getClientOriginalName();
        $id       = $brand->id;
        $img_dir  = 'resources/upload/images/brand/' . $id;
        if (!file_exists($img_dir)) {
            mkdir($img_dir);
        }
        $img = Image::make($request->file('fImages')->getRealPath());
        $img->resize(150, 100)->save($img_dir . '/' .  $img_name);
        $brand->image = $img_name;
        $brand->save();

		return redirect()->route('admin.brand.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm thương hiệu thành công !']);
    }

    public function getEdit ($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand.edit', compact('brand'));
    }

    public function postEdit (Request $request)
    {
        $id = $request->id;
        $this->validate($request,
            ['txtBrandName' => 'required', 'fImages' => 'image'],
            ['txtBrandName.required' => 'Vui lòng nhập tên thương hiệu', 'fImages.image' => 'File này không phải là một hình ảnh !']
        );
        $brand              = Brand::find($id);
        $brand->description = $request->txtDescription;

        $check = DB::table('brands as br')->where('br.name', '=', $request->txtBrandName)->count();
        if ( ($request->txtBrandName == $brand->name) || (($request->txtBrandName != $brand->name) && ($check < 1)) ) {
            $brand->name  = $request->txtBrandName;
            $brand->alias = changeTitle($request->txtBrandName);

            //để cập nhật ảnh logo mới thì cần phải: tải ảnh mới lên (lưu theo tên ảnh) -> di chuyển nó vào thư mục chứa -> xóa ảnh cũ đi
            $img_dir  = 'resources/upload/images/brand/' . $id;
            if (!file_exists($img_dir)) {
                mkdir($img_dir);
            }
            $img_current = $img_dir . '/' . $request->img_current;  //đường dẫn tới hình ảnh hiện tại
            if ( ! empty($request->file('fImages')) ) { //nếu tồn tại file ảnh mới
                $img_ext = $request->file('fImages')->getClientOriginalExtension();  //lấy phần đuôi mở rộng của file
                if (in_array($img_ext, Config::get('constants.image_valid_extension'))) { //kiểm tra $img_ext có nằm trong tập các đuôi ko (xem trong folder config/constants)
                    $file_name    = $request->file('fImages')->getClientOriginalName();
                    $brand->image = $file_name;
                    $img = Image::make($request->file('fImages')->getRealPath());
                    $img->resize(150, 100)->save($img_dir . '/' .  $file_name);
                        //xóa ảnh cũ
                    if ( File::exists($img_current) ) {
                        File::delete($img_current);
                    }
                } else {
                    return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'File bạn chọn không phải là một hình ảnh !']);
                }
            }
            $brand->save();
            return redirect()->route('admin.brand.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa thương hiệu thành công !']);
        } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Thương hiệu này đã tồn tại !']);
        }
    }

    public function delete_by_id ($id)
    {
        $brand = Brand::find($id);

        //Xóa sản phẩm tương ứng
        $product = Product::where('brand_id', '=', $id)->get();

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

        //Xóa logo thương hiệu
        $logo_dir = 'resources/upload/images/brand/' . $id;
        $logo     = $logo_dir. '/' . $brand->image;
        if (file_exists($logo)) {
            File::delete($logo);
        }
        if (file_exists($logo_dir)) {
            rmdir($logo_dir);
        }

        //Xóa thông tin còn lại
    	$brand->delete();
    }

    public function getDelete($id)
    {
        $this->delete_by_id($id);
        return redirect()->route('admin.brand.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thương hiệu thành công !']);
    }

    public function postDelete (Request $request)
    {
        if ($request->checks) {
            foreach($request->checks as $item) {
                $this->delete_by_id($item);
            }
            return redirect()->route('admin.brand.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thương hiệu thành công !']);
        } else {
            return redirect()->route('admin.brand.getList')->with(['flash_level' => 'warning', 'flash_message' => 'Không có mục nào được chọn để xóa !']);
        }
    }

}
