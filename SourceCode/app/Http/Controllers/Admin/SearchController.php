<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use URL;
use App\Size;

class SearchController extends Controller
{
	//Tìm kiếm sản phẩm
    public function getSearchProduct (Request $request)
    {
        if ($request->ajax()) {
            $data['keyword'] = $request->keyword;  //lấy danh sách các điều kiện và truyền sang view để phân trang
            $keyword = $data['keyword'];

            $cate_id  =  $request->cateId;
            $sport_id =  $request->sportId;
            $brand_id =  $request->brandId;
            $gender   =  $request->gender;

            $products = DB::table('products as pr')
                      ->select('pr.*', 'ct.name as ct_name', 'sp.name as sp_name', 'br.name as br_name')
                      ->join('categories as ct','ct.id','=','pr.cate_id')
                      ->join('sports as sp','sp.id','=','pr.sport_id')
                      ->join('brands as br','br.id','=','pr.brand_id')
                      ->where('pr.name', 'LIKE', '%'.$request->keyword.'%');
            if (!empty($cate_id)) {
                $products = $products->where('cate_id', $cate_id);
            }
            if (!empty($sport_id)) {
                $products = $products->where('sport_id', $sport_id);
            }
            if (!empty($brand_id)) {
                $products = $products->where('brand_id', $brand_id);
            }
            if (!empty($gender)) {
                $products = $products->where('gender', $gender);
            }
            $products = $products->orderBy('pr.id', 'DESC')->paginate(7);
            $data['cate_id']    = $cate_id;
            $data['sport_id']   = $sport_id;
            $data['brand_id']   = $brand_id;
            $data['gender']     = $gender;
            $data['products']   = $products;

            $products->setPath($request->paginateUrl); //hàm setPath() trong Laravel pagination cho phép tuỳ chọn URL phân trang, paginateUrl là chuỗi json truyền sang từ ajax

            return view('admin.product.list_search', $data);
        }
    }



    //Tìm kiếm thuộc tính sản phẩm theo tên sp
    public function getSearchProperty (Request $request)
    {
        if ($request->ajax()) {
            $data['keyword'] = $request->keyword;  //lấy danh sách các điều kiện và truyền sang view để phân trang
            $keyword = $data['keyword'];

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
            $data['properties'] = $properties;

            $properties->setPath($request->paginateUrl); //hàm setPath() trong Laravel pagination cho phép tuỳ chọn URL phân trang, paginateUrl là chuỗi json truyền sang từ ajax

            return view('admin.property.list_search', $data);
        }
    }
}
