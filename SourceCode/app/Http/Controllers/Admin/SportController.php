<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SportRequest;
use App\Sport;
use App\Product;
use App\ProductProperty;
use DB, Image, File, Config;


class SportController extends Controller
{
	public function getList()
	{
		$sports = DB::table('sports')->orderBy('id', 'desc')->paginate(7);

        //phân trang
        $url = route('admin.sport.getList');
        $sports->setPath($url);

		return view('admin.sport.list', compact('sports'));
	}

    public function getAdd ()
    {
    	return view('admin.sport.add');
    }

    public function postAdd (SportRequest $request)
    {
        $file_name          = $request->file('fImages')->getClientOriginalName();
		$sport              = new Sport;
		$sport->name        = $request->txtSportName;
        $sport->alias       = changeTitle($request->txtSportName);
        $sport->description = $request->txtDescription;
        $sport->save();

        //Xử lý ảnh logo thương hiệu
        $img_name = $request->file('fImages')->getClientOriginalName();
        $id       = $sport->id;
        $img_dir  = 'resources/upload/images/sport/' . $id;
        if (!file_exists($img_dir)) {
            mkdir($img_dir);
        }
        $img = Image::make($request->file('fImages')->getRealPath());
        $img->resize(150, 100)->save($img_dir . '/' .  $img_name);
        $sport->image = $img_name;
        $sport->save();
    	return redirect()->route('admin.sport.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm bộ môn thành công !']);
    }

    public function getEdit ($id)
    {
        $sport = Sport::find($id);
        return view('admin.sport.edit', compact('sport'));
    }

    public function postEdit (Request $request)
    {
        $id = $request->id;
        $this->validate($request,
            ['txtSportName' => 'required', 'fImages' => 'image'],
            ['txtSportName.required' => 'Vui lòng nhập tên bộ môn', 'fImages.image' => 'File này không phải là một hình ảnh']
        );
        $sport              = Sport::find($id);
        $sport->description = $request->txtDescription;

        $check = DB::table('sports as sp')->where('sp.name', '=', $request->txtSportName)->count();
        if ( ($request->txtSportName == $sport->name) || (($request->txtSportName != $sport->name) && ($check < 1)) ) {
            $sport->name  = $request->txtSportName;
            $sport->alias = changeTitle($request->txtSportName);

            //Để cập nhật ảnh logo mới thì cần phải: tải ảnh mới lên (lưu theo tên ảnh) -> di chuyển nó vào thư mục chứa -> xóa ảnh cũ đi
            $img_dir  = 'resources/upload/images/sport/' . $id;
            if (!file_exists($img_dir)) {
                mkdir($img_dir);
            }
            $img_current = $img_dir . '/' . $request->img_current;  //đường dẫn tới hình ảnh hiện tại
            if ( ! empty($request->file('fImages')) ) { //nếu tồn tại file ảnh mới
                $img_ext = $request->file('fImages')->getClientOriginalExtension();  //lấy phần đuôi mở rộng của file
                if (in_array($img_ext, Config::get('constants.image_valid_extension'))) { //kiểm tra $img_ext có nằm trong tập các đuôi ko (xem trong folder config/constants)

                    //Xóa ảnh cũ
                    if ( File::exists($img_current) ) {
                        File::delete($img_current);
                    }
                    
                    $file_name    = $request->file('fImages')->getClientOriginalName();
                    $sport->image = $file_name;
                    $img = Image::make($request->file('fImages')->getRealPath());
                    $img->resize(150, 100)->save($img_dir . '/' .  $file_name);
                    
                } else {
                    return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'File bạn chọn không phải là một hình ảnh']);
                }
            }
            $sport->save();
            return redirect()->route('admin.sport.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa bộ môn thành công !']);
        } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Bộ môn này đã tồn tại !']);
        }
    }

    public function delete_by_id ($id)
    {
    	$sport = Sport::findOrFail($id);

        //Xóa sản phẩm tương ứng
        $product = Product::where('sport_id', '=', $id)->get();

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

        //Xóa hình ảnh đại diện cho bộ môn
        $sport_dir = 'resources/upload/images/sport/' . $id;
        $sport_img = $sport_dir. '/' . $sport->image;
        if (file_exists($sport_img)) {
            File::delete($sport_img);
        }
        if (file_exists($sport_dir)) {
            rmdir($sport_dir);
        }

        //Xóa thông tin còn lại
        $sport->delete();
    }

    public function getDelete ($id)
    {
        $this->delete_by_id($id);
        return redirect()->route('admin.sport.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa bộ môn thành công !']);
    }

    public function postDelete (Request $request)
    {
        if($request->checks){
            foreach($request->checks as $item) {
                $this->delete_by_id($item);
            }
            return redirect()->route('admin.sport.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa bộ môn thành công !']);
        } else {
            return redirect()->route('admin.sport.getList')->with(['flash_level' => 'warning', 'flash_message' => 'Không có mục nào được chọn để xóa !']);
        }
    }

}
