<?php

namespace App\Http\Controllers\Admin;

use Request;
use App\Http\Controllers\Controller;
use App\ProductImage;
use File;


class DeleteImageProController extends Controller
{
    //Xóa ảnh chi tiết bằng ajax
    public function getDelImg ($id)
    {
    	if (Request::ajax()) {    //nếu dữ liệu là ajax, hoặc dùng $request->ajax()
			$idImage = (int)Request::get('idImage');    //để lấy id hình từ ajax (ép kiểu về int)
			$image_detail = ProductImage::find($idImage);
			if (!empty($image_detail)) {
				$lg_img  = 'resources/upload/images/product/large/' . $image_detail->pro_id . '/detail/' . $image_detail->name;
				$sm_img  = 'resources/upload/images/product/small/' . $image_detail->pro_id . '/detail/' . $image_detail->name;
				$thn_img = 'resources/upload/images/product/thumbnail/' . $image_detail->pro_id . '/detail/' . $image_detail->name;
				if (File::exists($lg_img)) {
					File::delete($lg_img);
				}
				if (File::exists($sm_img)) {
					File::delete($sm_img);
				}
				if (File::exists($thn_img)) {
					File::delete($thn_img);
				}
				$image_detail->delete();
				return "Ok";
			}
		}
	}

}
