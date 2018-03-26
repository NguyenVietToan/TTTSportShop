<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;


class HomeController extends Controller
{
    public function index () {
		$pro_qty       = DB::table('products')->count();
		$news_qty      = DB::table('news')->count();
		$video_qty     = DB::table('videos')->count();
		$new_order_qty = DB::table('orders')->where('status_order', '=', '0')->count();
		$user_qty      = DB::table('users')->count();
		$customer_qty  = DB::table('customers')->count();
		$member_qty    = DB::table('members')->count();

		$data['pro_qty']       = $pro_qty;
		$data['news_qty']      = $news_qty;
		$data['video_qty']     = $video_qty;
		$data['new_order_qty'] = $new_order_qty;
		$data['user_qty']      = $user_qty;
		$data['customer_qty']  = $customer_qty;
		$data['member_qty']    = $member_qty;
    	return view('admin.home', $data);
    }
}
