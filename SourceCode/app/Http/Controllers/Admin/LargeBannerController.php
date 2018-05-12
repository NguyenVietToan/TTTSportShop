<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\LargeBanner;
use Image, File, Config, DB;


class LargeBannerController extends Controller
{
    public function getList ()
    {
    	$large_banners = DB::table('large_banners')->orderBy('id', 'desc')->paginate(3);

        //phân trang
        $url = route('admin.largebanner.getList');
        $large_banners->setPath($url);

    	return view('admin.banner.large.list', compact('large_banners'));
    }

    public function getAdd ()
    {
    	return view('admin.banner.large.add');
    }

    public function postAdd (BannerRequest $request)
    {
    	$file_name = $request->file('fImages')->getClientOriginalName();
		$large_banner              = new LargeBanner;
		$large_banner->name        = $request->txtBannerName;
		$large_banner->display     = $request->has('display');
		$large_banner->description = $request->txtDescription;
		$large_banner->save();

		//Xử lý ảnh
		$img_name = $request->file('fImages')->getClientOriginalName();
		$main_dir = 'resources/upload/images/banner/largebanner';
		$id       = $large_banner->id;
		$lg_dir   = $main_dir . '/large/' . $id;
		$thn_dir  = $main_dir . '/thumbnail/' . $id;
		if (!file_exists($lg_dir)) {
			mkdir($lg_dir);
		}
		if (!file_exists($thn_dir)) {
			mkdir($thn_dir);
		}
		$img = Image::make($request->file('fImages')->getRealPath());
		$img->resize(1680, 750)->save($lg_dir . '/' .  $img_name);
		$img->resize(250, 100)->save($thn_dir . '/' .  $img_name);
		$large_banner->image = $img_name;
		$large_banner->save();

		return redirect()->route('admin.largebanner.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm banner lớn thành công !']);
    }

    public function getEdit ($id)
    {
    	$large_banner = LargeBanner::find($id);
    	return view('admin.banner.large.edit', compact('large_banner'));
    }

    public function postEdit (Request $request)
    {
    	$id = $request->id;
    	$this->validate($request,
            ['fImages' => 'image'],
            ['fImages.image' => 'File này không phải là một hình ảnh !']
        );
		$large_banner              = LargeBanner::find($id);
		$large_banner->name        = $request->txtBannerName;
		$large_banner->display     = $request->has('display');
		$large_banner->description = $request->txtDescription;

		//Cập nhật hình ảnh
		$main_dir = 'resources/upload/images/banner/largebanner';
		$lg_dir   = $main_dir . '/large/' . $id;
		$thn_dir  = $main_dir . '/thumbnail/' . $id;
		if (!file_exists($lg_dir)) {
			mkdir($lg_dir);
		}
		if (!file_exists($thn_dir)) {
			mkdir($thn_dir);
		}

			//lấy ảnh hiện tại
		$img_cur_name = $request->img_current;
		$lg_cur_dir   = $lg_dir . '/' . $img_cur_name;
		$thn_cur_dir  = $thn_dir . '/' . $img_cur_name;

			//nếu tồn tại ảnh đại diện mới: tải ảnh mới lên, lưu vào CSDL và xóa ảnh cũ
		if (!empty($request->file('fImages'))) {
			$img_ext = $request->file('fImages')->getClientOriginalExtension();
            if (in_array($img_ext, Config::get('constants.image_valid_extension'))) {

            		//xóa ảnh cũ
				if (File::exists($lg_cur_dir)) {
					File::delete($lg_cur_dir);
				}
				if (File::exists($thn_cur_dir)) {
					File::delete($thn_cur_dir);
				}

				$file_name   = $request->file('fImages')->getClientOriginalName();
				$large_banner->image = $file_name;
				$img = Image::make($request->file('fImages')->getRealPath());
				$img->resize(1000, 400)->save($lg_dir . '/' .  $file_name);
				$img->resize(250, 100)->save($thn_dir . '/' .  $file_name);
				
         	} else {
         		return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'File bạn chọn không phải là một hình ảnh']);
         	}
		}
        $large_banner->save();
        return redirect()->route('admin.largebanner.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa banner lớn thành công !']);

    }


    public function delete_by_id ($id)
    {
        $large_banner   = LargeBanner::find($id);

        //Xóa hình ảnh
        $main_dir = 'resources/upload/images/banner/largebanner';
		$lg_dir   = $main_dir . '/large/' . $id;
		$thn_dir  = $main_dir . '/thumbnail/' . $id;

		$lg_img = $lg_dir . '/' . $large_banner->image;
		$thn_img = $thn_dir . '/' . $large_banner->image;
		if (file_exists($lg_img)) {
			File::delete($lg_img);
		}
		if (file_exists($thn_img)) {
			File::delete($thn_img);
		}

		//Xóa thư mục ảnh id
		if (file_exists($lg_dir)) {
			rmdir($lg_dir);
		}
		if (file_exists($thn_dir)) {
			rmdir($thn_dir);
		}

    	$large_banner->delete();
    }

    public function getDelete($id)
    {
        $this->delete_by_id($id);
        return redirect()->route('admin.largebanner.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa banner lớn thành công !']);
    }

    public function postDelete (Request $request)
    {
        if($request->checks){
            foreach($request->checks as $item) {
                $this->delete_by_id($item);
            }
            return redirect()->route('admin.largebanner.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa banner lớn thành công !']);
        } else {
            return redirect()->route('admin.largebanner.getList')->with(['flash_level' => 'warning', 'flash_message' => 'Không có mục nào được chọn để xóa !']);
        }
    }
}
