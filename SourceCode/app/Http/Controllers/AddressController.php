<?php
namespace App\Http\Controllers;

use Request;
use App\Province;
use App\District;
use App\Ward;

class AddressController extends Controller
{
    public function getAddress ($type, $id) {
		if (Request::ajax()) {
			if ($type == "province") {
				//Lấy ra danh sách tất cả các huyện tương ứng với tỉnh được chọn
				$id_province = (int)Request::get('id');
				if ($id_province < 10) {
					$id_province = '0'.$id_province;
				}
				$districts = District::where('provinceid', '=', $id_province)->get();
				$str = '<option value="0">Quận/Huyện</option>';
				foreach ($districts as $item) {
					$str .= '<option value="' . $item->districtid . '">' . $item->name . '</option>';
				}
				return $str;
			} else if ($type == 'district') {
				//Lấy ra danh sách tất cả các xã tương ứng với huyện được chọn
				$id_district = (int)Request::get('id');
				if ($id_district < 10) {
					$id_district = '00'.$id_district;
				} else if ($id_district < 100) {
					$id_district = '0'.$id_district;
				}
				$wards = Ward::where('districtid','=',$id_district)->get();
				$str = '<option value="0">Phường/Xã</option>';
				foreach ($wards as $item) {
					$str .= '<option value="' . $item->wardid . '">' . $item->name . '</option>';
				}
				return $str;
			}
		}
	}
}
