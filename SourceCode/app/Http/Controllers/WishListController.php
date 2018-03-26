<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Auth;
use App\WishList;


class WishListController extends Controller
{

	//Hiển thị wishlist
	public function getWishList ()
	{
		if (Auth::check()) {
			$where['wl.user_id']  = Auth::user()->id;
			$where['wl.is_liked'] = 1;
			$products = DB::table('wish_lists as wl')
			          ->join('products as pr', 'wl.pro_id', '=', 'pr.id')
			          ->where($where)
			          ->get();
			foreach ($products as $newest_prod) {
				//lấy danh sách size của sản phẩm
				$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty', 'sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->id)
								->orderBy('value')
								->get();
			}
		}
		$data['products'] = $products;
		return view('user.pages.wish_list', $data);
	}


	//Thêm sp vào wishlist
	public function addToWishList (Request $request)
	{
		if (Auth::check()) { //nếu đã đăng nhập
			$where = [
				'user_id' => Auth::user()->id,
				'pro_id'  => $request->pro_id
			];

			$wishlist = WishList::where($where)->first();
			$is_liked = 1;  //đã thích
			if (!empty($wishlist)) {  //nếu tồn tại trong danh sách thì tức là đã thích
				if ($wishlist->is_liked == 1) {
					$is_liked = 0;  //nếu đã thích thì bỏ thích
				} else {
					$is_liked = 1;  //nếu chưa thích thì thích
				}
				$wishlist->is_liked = $is_liked;
				$wishlist->save();
			} else {  //nếu chưa thích thì thêm vào danh sách
				$wishList = new WishList;
				$wishList->user_id = Auth::user()->id;
				$wishList->pro_id  = $request->pro_id;
				$wishList->is_liked = 1;
				$wishList->save();
			}
			$like_number = WishList::where(['pro_id' => $request->pro_id, 'is_liked' => 1])->count(); //đếm số lượt thích của sp
			$total_user_like_number = WishList::where(['user_id' => Auth::user()->id, 'is_liked' => 1])->count();  //số lượng sp mà 1 user yêu thích
			$response = [
				'state'                  => 1,
				'msg'                    => 'successful!',
				'like_number'            => $like_number,
				'is_liked'               => $is_liked,
				'total_user_like_number' => $total_user_like_number
			];
		} else {
			$response = [
				'state'	=> 0,
				'msg'	=> 'fail!'
			];
		}
		return response()->json($response);

	}


	//Xóa sp khỏi wishlist
    public function postDeleteWishList(Request $request){
    	if (Auth::check()) {
			$where = [
				'user_id' => Auth::user()->id,
				'pro_id'  => $request->pro_id
			];

			//khi xóa thì chuyển is_liked = 0 chứ ko xóa hoàn toàn khỏi DB
			$wishlist = WishList::where($where)->first();
			if (!empty($wishlist)) {
				$wishlist->is_liked = 0;
				$wishlist->save();
			}

			//số lượng hiển thị trên menu
			$total_user_like_number = WishList::where(['user_id' => Auth::user()->id, 'is_liked' => 1])->count();

			$response = [
				'state'                  => 1,  //xóa thành công
				'msg'                    => 'successful!',
				'total_user_like_number' => $total_user_like_number
			];
		} else {
			$response = [
				'state'	=> 0,
				'msg'	=> 'fail!'
			];
		}
		return response()->json($response);
    }
}
