<?php namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Config;
use Paginator;
use App\WishList;
use Auth;
use App\Product;
class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()   //hàm khởi tạo
	{
		$this->middleware('guest');
		$this->setDefaultSessionLang(); //luôn luôn gọi đến hàm set ngôn ngữ mặc định
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
//----------------------------------------------------------------------------------------------------


//Thiết lập ngôn ngữ
	//Hàm thiết lập ngôn ngữ mặc định: nếu session('lang') không tồn tại thì thiết lập 1 session: 'lang' ở đây là tên session do mình tự đặt chứ không phải tên class 'lang' trong form select
	public function setDefaultSessionLang() {
		if (empty(session('lang'))) {
			session(['lang' => 'vi']); //lưu session
		}
	}


	//Hàm thiết lập ngôn ngữ khi click chọn (ajax) --> ajax trong mainjs
	public function setUserLang(Request $request) {
		$response = [];  //mảng lưu trạng thái và thông điệp hồi đáp
		if (!empty($request->lang)) {  //nếu click chọn
			$lang = $request->lang;
			if ($lang == 'vi') {
				session(['lang' => 'vi']);
			} else if ($lang == 'en') {
				session(['lang' => 'en']);
			}
			$response = [
				'state' => 1,
				'msg'	=> 'success'
			];
		} else {
			$response = [
				'state' => 0,
				'msg'	=> 'fail'
			];
		}
		$data = response()->json($response);  //đây chính là data trong ajax
		return $data;
	}

//Lấy danh sách giới tính
	public function getListGender () {
		$lang    = !empty(session('lang')) ? session('lang') : 'vi';
		$genders = Config::get('constants.genders')[$lang];
		return $genders;
	}

//Lấy danh sách sắp xếp
	public function getListSort () {
		$lang  = !empty(session('lang')) ? session('lang') : 'vi';
		$sorts = Config::get('constants.sorts')[$lang];
		return $sorts;
	}


//----------------------------------------------------------------------------------------------------
	//Giới thiệu về cửa hàng
	public function getIntroduce () {
		return view('introduce');
	}


//----------------------------------------------------------------------------------------------------
	//Tìm kiếm sp theo tên sp, giá, tên bộ môn, tên thương hiệu
	public function getSearch (Request $request)
	{
		$keyword = $request->keyword;

		$prods = DB::table('products as pr')
				->select('pr.*', 'pr.name as pr_name', 'sp.name', 'br.name')
				->join('sports as sp', 'pr.sport_id', 'sp.id')
				->join('brands as br', 'pr.sport_id', 'br.id')
	            ->where('pr.name', 'LIKE', '%'.$keyword.'%')
	            ->orWhere('price', $keyword)
	            ->orWhere('sale_price', $keyword)
	            ->orWhere('sp.name', 'LIKE', '%'.$keyword.'%')
	            ->orWhere('br.name', 'LIKE', '%'.$keyword.'%')
	            ->orderBy('pr.id', 'desc');

		$count_products = count($prods->get()); //đếm số lượng sp tìm thấy
		$products = $prods->paginate(12);

		foreach ($products as $newest_prod) {
			$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty','sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->id)
								->orderBy('value')
								->get();

			$where = [
				'pro_id' => $newest_prod->id,
				'is_liked' => 1
			];
			$newest_prod->like = WishList::where($where)->count();
			$newest_prod->is_liked = 0;
			if(Auth::check()){
				$user_id          = Auth::user()->id;
				$where['user_id'] = $user_id;
				$user_like        = WishList::where($where)->first();
				if(!empty($user_like) && $user_like->is_liked == 1){
					$newest_prod->is_liked = 1;
				}
			}
		}

		$data['products']       = $products;
		$data['count_products'] = $count_products;
		$data['keyword']        = $keyword;
		return view('user.pages.search', $data);
	}


//----------------------------------------------------------------------------------------------------

	//Gọi trang giới thiệu mở đầu
	public function introIndex(){

		//Đổ banner lớn ra
		$large_banners = DB::table('large_banners')->where('display', '=', '1')->orderBy('id', 'asc')->take(4)->get();
		//Truyền dữ liệu sang view
		$data['large_banners']    = $large_banners;
		return view('user.index', $data);
	}

	//Đổ dữ liệu ra trang chủ
	public function index ()
	{
		//Đổ banner lớn ra
		$large_banners = DB::table('large_banners')->where('display', '=', '1')->orderBy('id', 'asc')->take(6)->get();

		//Đổ banner nhỏ ra
		$small_banners = DB::table('small_banners')->where('display', '=', '1')->orderBy('id', 'asc')->take(3)->get();

		//Tin thể thao
		$sport_news = DB::table('news')->select('news.*', 'news.id as n_id')->join('news_categories as ncate', 'news.ncate_id', '=', 'ncate.id')->where('ncate.id', '=', '1')->orderBy('n_id', 'desc')->take(5)->get();

		//Tin khuyến mãi
		$promotion_news = DB::table('news')->select('news.*', 'news.id as n_id')->join('news_categories as ncate', 'news.ncate_id', '=', 'ncate.id')->where('ncate.id', '=', '2')->orderBy('n_id', 'desc')->take(3)->get();

		//Tin tuyển dụng
		$recruitment_news = DB::table('news')->select('news.*', 'news.id as n_id')->join('news_categories as ncate', 'news.ncate_id', '=', 'ncate.id')->where('ncate.id', '=', '3')->orderBy('n_id', 'desc')->take(3)->get(); 

		//Tư vấn
		$advisory_news = DB::table('news')->select('news.*', 'news.id as n_id')->join('news_categories as ncate', 'news.ncate_id', '=', 'ncate.id')->where('ncate.id', '=', '4')->orderBy('n_id', 'desc')->take(5)->get();

		//Sản phẩm mới nhất (có id lớn nhất)
		$newest_products = DB::table('products')->orderBy('id', 'desc')->take(6)->get();

		foreach ($newest_products as $newest_prod) {
			$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty','sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->id)
								->orderBy('value')
								->get();


			$where = [
				'pro_id' => $newest_prod->id,
				'is_liked' => 1
			];
			$newest_prod->like = WishList::where($where)->count();
			$newest_prod->is_liked = 0;
			if(Auth::check()){
				$user_id = Auth::user()->id;
				$where['user_id'] = $user_id;
				$user_like = WishList::where($where)->first();
				if(!empty($user_like) && $user_like->is_liked == 1){
					$newest_prod->is_liked = 1;
				}
			}
		}

		//Đổ sản phẩm ra tab thể loại
		$cates = DB::table('categories')->orderBy('name', 'asc')->get();
		foreach ($cates as $cate) {
			$cate->newest_products = DB::table('products as pr')->select('pr.*')->join('categories as ct', 'pr.cate_id', '=', 'ct.id')->where('ct.id', '=', $cate->id)->orderBy('pr.id', 'desc')->take(3)->get();
			foreach ($cate->newest_products as $newest_prod) {
				$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty','sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->id)
								->orderBy('value')
								->get();
				$where = [
					'pro_id' => $newest_prod->id,
					'is_liked' => 1
				];
				$newest_prod->like = WishList::where($where)->count();
				$newest_prod->is_liked = 0;
				if(Auth::check()){
					$user_id = Auth::user()->id;
					$where['user_id'] = $user_id;
					$user_like = WishList::where($where)->first();
					if(!empty($user_like) && $user_like->is_liked == 1){
						$newest_prod->is_liked = 1;
					}
				}
			}
		}

		//Đổ sản phẩm ra tab bộ môn
		$sports = DB::table('sports')->orderBy('id', 'asc')->get();
		foreach ($sports as $sport) {
			$sport->newest_products = DB::table('products as pr')->select('pr.*')->join('sports as sp', 'pr.sport_id', '=', 'sp.id')->where('sp.id', '=' , $sport->id)->orderBy('pr.id', 'desc')->take(3)->get();
			foreach ($sport->newest_products as $newest_prod) {
				$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty','sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->id)
								->orderBy('value')
								->get();
				$where = [
					'pro_id' => $newest_prod->id,
					'is_liked' => 1
				];
				$newest_prod->like = WishList::where($where)->count();
				$newest_prod->is_liked = 0;
				if(Auth::check()){
					$user_id = Auth::user()->id;
					$where['user_id'] = $user_id;
					$user_like = WishList::where($where)->first();
					if(!empty($user_like) && $user_like->is_liked == 1){
						$newest_prod->is_liked = 1;
					}
				}
			}
		}

		//Đổ sản phẩm ra tab thương hiệu
		$brands = DB::table('brands')->orderBy('id', 'asc')->get();
		foreach ($brands as $brand) {
			$brand->newest_products = DB::table('products as pr')->select('pr.*')->join('brands as br', 'pr.brand_id', '=', 'br.id')->where('br.id', '=' , $brand->id)->orderBy('pr.id', 'desc')->take(3)->get();
			foreach ($brand->newest_products as $newest_prod) {
				$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty','sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->id)
								->orderBy('value')
								->get();
				$where = [
					'pro_id' => $newest_prod->id,
					'is_liked' => 1
				];
				$newest_prod->like = WishList::where($where)->count();
				$newest_prod->is_liked = 0;
				if(Auth::check()){
					$user_id = Auth::user()->id;
					$where['user_id'] = $user_id;
					$user_like = WishList::where($where)->first();
					if(!empty($user_like) && $user_like->is_liked == 1){
						$newest_prod->is_liked = 1;
					}
				}
			}
		}


		//Đổ sp ra phần sp đc yêu thích nhiều
		$products1 = DB::table('wish_lists as wl')
				    ->join('products as pr', 'pro_id', '=', 'pr.id')
				    ->select('price', 'sale_price', 'name', 'image', 'pro_id', DB::raw('count(*) as total'))
				    ->where('is_liked', '=', 1)
				    ->groupBy('pro_id', 'price', 'name',  'image', 'sale_price')
				    ->orderby('total','DESC')
				    ->skip(0)
				    ->take(3)
				    ->get();
		foreach ($products1 as $newest_prod) {
			$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty','sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->pro_id)
								->orderBy('value')
								->get();

			$where = [
				'pro_id' => $newest_prod->pro_id,
				'is_liked' => 1
			];
			$newest_prod->like = WishList::where($where)->count();
			$newest_prod->is_liked = 0;
			if(Auth::check()){
				$user_id = Auth::user()->id;
				$where['user_id'] = $user_id;
				$user_like = WishList::where($where)->first();
				if(!empty($user_like) && $user_like->is_liked == 1){
					$newest_prod->is_liked = 1;
				}
			}
		}

		$products2 = DB::table('wish_lists')
				    ->join('products as pr', 'pro_id', '=', 'pr.id')
				    ->select('price', 'sale_price', 'name', 'image', 'pro_id', DB::raw('count(*) as total'))
				    ->where('is_liked', '=', 1)
				    ->groupBy('pro_id', 'price', 'name', 'image', 'sale_price')
				    ->orderby('total','DESC')
				    ->skip(3)
				    ->take(3)
				    ->get();
		foreach ($products2 as $newest_prod) {
			$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty','sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->pro_id)
								->orderBy('value')
								->get();

			$where = [
				'pro_id' => $newest_prod->pro_id,
				'is_liked' => 1
			];
			$newest_prod->like = WishList::where($where)->count();
			$newest_prod->is_liked = 0;
			if(Auth::check()){
				$user_id = Auth::user()->id;
				$where['user_id'] = $user_id;
				$user_like = WishList::where($where)->first();
				if(!empty($user_like) && $user_like->is_liked == 1){
					$newest_prod->is_liked = 1;
				}
			}
		}


		//Truyền dữ liệu sang view
		$data['large_banners']    = $large_banners;
		$data['small_banners']    = $small_banners;
		$data['sport_news']       = $sport_news;
		$data['promotion_news']   = $promotion_news;
		$data['recruitment_news'] = $recruitment_news;
		$data['advisory_news']    = $advisory_news;
		$data['newest_products']  = $newest_products;
		$data['cates']            = $cates;
		$data['sports']           = $sports;
		$data['brands']           = $brands;
		$data['products1']        = $products1;
		$data['products2']        = $products2;

		return view('user.pages.home', $data);
	}


//---------------------------------------------------------------------------------------------------


	//các hàm dùng chung
	//lấy danh sách các điều kiện: nếu có click vào item Filter (có ajax) thì lấy giá trị tương ứng, nếu không thì bằng null. $data là 1 mảng để lưu danh sách các điều kiện (đây cũng chính là những biến sẽ được truyền sang view dùng để làm các param trên url phân trang). $request->sort thì sort chính là 1 chuỗi json được truyền sang từ ajax
	public function getWhereData(Request $request) {
		$data['sort']   = $request->sort;
		$data['sport']  = $request->sport;
		$data['cate']   = $request->cate;
		$data['brand']  = $request->brand;
		$data['gender'] = $request->gender;
		$data['sprice'] = $request->sprice;
		$data['eprice'] = $request->eprice;
		// dd($data['sport']);  //hàm dd($var) để kiểm tra json
		return $data;
	}


	//Lấy danh sách sản phẩm theo các điều kiện lấy từ getWhereData()
	public function getAllProduct($data) {
		//các điều kiện lấy từ getWhereData(). $sort = ... thì ở đây nó chỉ là 1 cách đặt tên cho mảng lưu các điều kiện để viết cho ngắn gọn, tránh nhầm lẫn với sort truyền từ ajax
		$sort   = $data['sort'];
		$sport 	= $data['sport'];
		$cate   = $data['cate'];
		$brand  = $data['brand'];
		$gender = $data['gender'];
		$sprice = $data['sprice'];
		$eprice = $data['eprice'];

		//lấy dữ liệu
		$all_products = DB::table('products');
		switch($sort){
			case 'price_down':
				$all_products = $all_products->orderBy('price', 'desc');
				break;
			case 'price_up':
				$all_products = $all_products->orderBy('price');
				break;
			case 'alpha_down':
				$all_products = $all_products->orderBy('name', 'desc');
				break;
			case 'alpha_up':
				$all_products = $all_products->orderBy('name');
				break;
			default:
				$all_products = $all_products->orderBy('id', 'desc');
		}
		if (!empty($sport)) {
			$all_products = $all_products->whereIn('sport_id', $sport);
		}
		if (!empty($cate)) {
			$all_products = $all_products->whereIn('cate_id', $cate);
		}
		if (!empty($brand)) {
			$all_products = $all_products->whereIn('brand_id', $brand);
		}
		if (!empty($gender)) {
			$all_products = $all_products->whereIn('gender', $gender);
		}
		if(!empty($sprice) && !empty($eprice)){
			$all_products = $all_products->where('price', '>=', $sprice)->where('price', '<=', $eprice);
		}
		$all_products = $all_products->paginate(12);
		return $all_products;
	}


	//Hiển thị sản phẩm khi lọc dữ liệu với Ajax
	public function getProductAjax (Request $request)
	{
		if ($request->ajax()) {
			$data = $this->getWhereData($request);  //lấy danh sách các điều kiện và truyền sang view để phân trang

			$all_products = $this->getAllProduct($data); //lấy danh sách các sản phẩm theo điều kiện và truyền sang view để hiển thị
			$data['all_products'] = $all_products;

			foreach ($all_products as $newest_prod) {
				$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty','sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->id)
								->orderBy('value')
								->get();

				$where = [
					'pro_id' => $newest_prod->id,
					'is_liked' => 1
				];
				$newest_prod->like = WishList::where($where)->count();
				$newest_prod->is_liked = 0;
				if(Auth::check()){
					$user_id = Auth::user()->id;
					$where['user_id'] = $user_id;
					$user_like = WishList::where($where)->first();
					if(!empty($user_like) && $user_like->is_liked == 1){
						$newest_prod->is_liked = 1;
					}
				}
			}

			$all_products->setPath($request->paginateUrl); //hàm setPath() trong Laravel pagination cho phép tuỳ chọn URL phân trang, paginateUrl là chuỗi json truyền sang từ ajax

            return view('user.blocks.product_filter', $data);
		}
	}


//-------------------------------------------------------------------------------------------------


	//Đổ dữ liệu ra trang sản phẩm
	public function product (Request $request)
	{
		$sorts   = $this->getListSort();
		$genders = $this->getListGender();
		$sports  = DB::table('sports')->orderBy('name', 'asc')->get();
		$cates   = DB::table('categories')->orderBy('name', 'asc')->get();
		$brands  = DB::table('brands')->orderBy('name', 'asc')->get();
		//DL truyền sang view để phân trang
		$data                = $this->getWhereData($request);
		$paginateUrl         = route('getProduct');
		$data['paginateUrl'] = $paginateUrl; //truyền sang view sau đó sẽ từ view truyền sang ajax

		//DL truyền sang view để hiển thị sp
		$all_products         = $this->getAllProduct($data);
		$data['all_products'] = $all_products;

		foreach ($all_products as $newest_prod) {
			$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty','sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->id)
								->orderBy('value')
								->get();

			$where = [
				'pro_id' => $newest_prod->id,
				'is_liked' => 1
			];
			$newest_prod->like = WishList::where($where)->count();
			$newest_prod->is_liked = 0;
			if(Auth::check()){
				$user_id = Auth::user()->id;
				$where['user_id'] = $user_id;
				$user_like = WishList::where($where)->first();
				if(!empty($user_like) && $user_like->is_liked == 1){
					$newest_prod->is_liked = 1;
				}
			}
		}

		//DL truyền sang view để hiển thị khung sidebar-left
		$data['sorts']   = $sorts;
		$data['sports']  = $sports;
		$data['cates']   = $cates;
		$data['brands']  = $brands;
		$data['genders'] = $genders;

		return view('user.pages.product', $data);
	}


//------------------------------------------------------------------------------------------------


	//Lấy sản phẩm theo bộ môn (trang sản phẩm theo bộ môn)
	public function sport ($sp_alias, Request $request)
	{
		$sorts = $this->getListSort();
		$genders = $this->getListGender();
		$sports  = DB::table('sports')->where('alias', '=', $sp_alias)->first();
		$cates   = DB::table('categories')->orderBy('id', 'asc')->get();
		$brands  = DB::table('brands')->orderBy('id', 'asc')->get();

		//phân trang: do đang lấy sp theo bộ môn nên trên url phân trang phải có param sport
		$data                = $this->getWhereData($request);
		$data['sport']       = [$sports->id];  //kiểu mảng để thực hiện whereIn
		$paginateUrl         = route('getSport',['sport' => $sp_alias]);
		$data['paginateUrl'] = $paginateUrl;

		//dữ liệu
		$all_products         = $this->getAllProduct($data);
		$data['all_products'] = $all_products;

		foreach ($all_products as $newest_prod) {
			$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty','sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->id)
								->orderBy('value')
								->get();

			$where = [
				'pro_id' => $newest_prod->id,
				'is_liked' => 1
			];
			$newest_prod->like = WishList::where($where)->count();
			$newest_prod->is_liked = 0;
			if(Auth::check()){
				$user_id = Auth::user()->id;
				$where['user_id'] = $user_id;
				$user_like = WishList::where($where)->first();
				if(!empty($user_like) && $user_like->is_liked == 1){
					$newest_prod->is_liked = 1;
				}
			}
		}

		//sidebar-left
		$data['sorts']    = $sorts;
		$data['sports']   = $sports;
		$data['cates']    = $cates;
		$data['brands']   = $brands;
		$data['genders']  = $genders;

		return view('user.pages.product', $data);
	}


//-------------------------------------------------------------------------------------------------


	//Lấy sản phẩm theo bộ môn và thể loại
	public function sport_category ($sp_alias, $ct_alias, Request $request)
	{
		$sorts = $this->getListSort();
		$genders = $this->getListGender();
		$sports  = DB::table('sports')->where('alias', '=', $sp_alias)->first();
		$cates   = DB::table('categories')->where('alias', '=', $ct_alias)->first();
		$brands  = DB::table('brands')->orderBy('id', 'asc')->get();

		//phân trang: do đang lấy sp theo bộ môn và thể loại nên trên url phân trang phải có param sport và cate
		$data                = $this->getWhereData($request);
		$data['sport']       = [$sports->id];  //kiểu mảng để thực hiện whereIn
		$data['cate']        = [$cates->id];
		$paginateUrl         = route('getSportCate', ['sport' => $sp_alias, 'cate' => $ct_alias]);
		$data['paginateUrl'] = $paginateUrl;

		//dữ liệu
		$all_products         = $this->getAllProduct($data);
		$data['all_products'] = $all_products;

		foreach ($all_products as $newest_prod) {
			$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty','sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->id)
								->orderBy('value')
								->get();

			$where = [
				'pro_id' => $newest_prod->id,
				'is_liked' => 1
			];
			$newest_prod->like = WishList::where($where)->count();
			$newest_prod->is_liked = 0;
			if(Auth::check()){
				$user_id = Auth::user()->id;
				$where['user_id'] = $user_id;
				$user_like = WishList::where($where)->first();
				if(!empty($user_like) && $user_like->is_liked == 1){
					$newest_prod->is_liked = 1;
				}
			}
		}

		//sidebar-left
		$data['sorts']    = $sorts;
		$data['sports']   = $sports;
		$data['cates']    = $cates;
		$data['brands']   = $brands;
		$data['genders']  = $genders;

		return view('user.pages.product', $data);
	}


//---------------------------------------------------------------------------------------------------


	//Lấy sản phẩm theo thương hiệu
	public function brand ($br_alias, Request $request)
	{
		$sorts = $this->getListSort();
		$genders = $this->getListGender();
		$sports  = DB::table('sports')->orderBy('id', 'asc')->get();
		$cates   = DB::table('categories')->orderBy('id', 'asc')->get();
		$brands  = DB::table('brands')->where('alias', '=', $br_alias)->first();

		//phân trang: do đang lấy sp theo thương hiệu nên trên url phân trang phải có param brand
		$data                = $this->getWhereData($request);
		$data['brand']       = [$brands->id];  //kiểu mảng để thực hiện whereIn
		$paginateUrl         = route('getBrand',['brand' => $br_alias]);
		$data['paginateUrl'] = $paginateUrl;

		//dữ liệu
		$all_products         = $this->getAllProduct($data);
		$data['all_products'] = $all_products;

		foreach ($all_products as $newest_prod) {
			$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty','sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->id)
								->orderBy('value')
								->get();

			$where = [
				'pro_id' => $newest_prod->id,
				'is_liked' => 1
			];
			$newest_prod->like = WishList::where($where)->count();
			$newest_prod->is_liked = 0;
			if(Auth::check()){
				$user_id = Auth::user()->id;
				$where['user_id'] = $user_id;
				$user_like = WishList::where($where)->first();
				if(!empty($user_like) && $user_like->is_liked == 1){
					$newest_prod->is_liked = 1;
				}
			}
		}

		//sidebar-left
		$data['sorts']    = $sorts;
		$data['sports']   = $sports;
		$data['cates']    = $cates;
		$data['brands']   = $brands;
		$data['genders']  = $genders;

		return view('user.pages.product', $data);
	}

//----------------------------------------------------------------------------------------------------


	//Lấy sản phẩm theo thương hiệu và thể loại
	public function brand_category ($br_alias, $ct_alias, Request $request)
	{
		$sorts = $this->getListSort();
		$genders = $this->getListGender();
		$sports  = DB::table('sports')->orderBy('id', 'asc')->get();
		$cates   = DB::table('categories')->where('alias', '=', $ct_alias)->first();
		$brands  = DB::table('brands')->where('alias', '=', $br_alias)->first();

		//phân trang: do đang lấy sp theo thương hiệu và thể loại nên trên url phân trang phải có param brand và cate
		$data                = $this->getWhereData($request);
		$data['brand']       = [$brands->id];  //kiểu mảng để thực hiện whereIn
		$data['cate']        = [$cates->id];
		$paginateUrl         = route('getBrandCate', ['brand' => $br_alias, 'cate' => $ct_alias]);
		$data['paginateUrl'] = $paginateUrl;

		foreach ($all_products as $newest_prod) {
			$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty','sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->id)
								->orderBy('value')
								->get();

			$where = [
				'pro_id' => $newest_prod->id,
				'is_liked' => 1
			];
			$newest_prod->like = WishList::where($where)->count();
			$newest_prod->is_liked = 0;
			if(Auth::check()){
				$user_id = Auth::user()->id;
				$where['user_id'] = $user_id;
				$user_like = WishList::where($where)->first();
				if(!empty($user_like) && $user_like->is_liked == 1){
					$newest_prod->is_liked = 1;
				}
			}
		}

		//dữ liệu
		$all_products         = $this->getAllProduct($data);
		$data['all_products'] = $all_products;

		//sidebar-left
		$data['sorts']    = $sorts;
		$data['sports']   = $sports;
		$data['cates']    = $cates;
		$data['brands']   = $brands;
		$data['genders']  = $genders;

		return view('user.pages.product', $data);
	}


//-----------------------------------------------------------------------------------------------------
//CHI TIẾT SẢN PHẨM

	//Lấy chi tiết sản phẩm
	public function productDetail ($id)
	{
		$product_detail = DB::table('products')->where('id', $id)->first();
		$prod_images = DB::table('product_images')->select('id', 'name')->where('pro_id', $product_detail->id)->get();
		$prod_properties = DB::table('product_properties as pp')->select('pp.id', 'value', 'qty', 'sizes.id')->join('sizes', 'sizes.id', '=', 'pp.size_id')->where('pro_id', $product_detail->id)->get();
		$sizes = DB::table('product_properties as pp')
			->select('value', 'qty','sizes.id')
			->join('sizes', 'sizes.id', '=', 'pp.size_id')
			->where('pro_id', $id)
			->orderBy('value')
			->get();

		$count = DB::table('wish_lists')->where('pro_id', '=', $id)->count(); //đếm sản phẩm này trong wishlist

		//review
		$reviews      = DB::table('reviews')->where('pro_id', '=', $id)->get();
		$count_review = DB::table('reviews')->where('pro_id', '=', $id)->count();

		//sp tương tự
		$similar_products = DB::table('products')
		                  ->where('cate_id', '=', $product_detail->cate_id)
		                  ->where('sport_id', '=', $product_detail->sport_id)
		                  ->where('id', '!=', $id)
		                  ->orderBy('id', 'desc')
		                  ->paginate(4);

		foreach ($similar_products as $newest_prod) {
			$newest_prod->sizes = DB::table('product_properties as pp')
								->select('value', 'qty','sizes.id')
								->join('sizes', 'sizes.id', '=', 'pp.size_id')
								->where('pro_id', $newest_prod->id)
								->orderBy('value')
								->get();

			$where = [
				'pro_id' => $newest_prod->id,
				'is_liked' => 1
			];
			$newest_prod->like = WishList::where($where)->count();
			$newest_prod->is_liked = 0;
			if(Auth::check()){
				$user_id = Auth::user()->id;
				$where['user_id'] = $user_id;
				$user_like = WishList::where($where)->first();
				if(!empty($user_like) && $user_like->is_liked == 1){
					$newest_prod->is_liked = 1;
				}
			}
		}

		//yêu thích sp
		$where = [
			'pro_id' => $id,
			'is_liked' => 1
		];
		$product_detail->like = WishList::where($where)->count();
		$product_detail->is_liked = 0;
		if(Auth::check()){
			$user_id = Auth::user()->id;
			$where['user_id'] = $user_id;
			$user_like = WishList::where($where)->first();
			if(!empty($user_like) && $user_like->is_liked == 1){
				$product_detail->is_liked = 1;
			}
		}

		$data['product_detail']   = $product_detail;
		$data['prod_images']      = $prod_images;
		$data['prod_properties']  = $prod_properties;
		$data['sizes']            = $sizes;
		$data['count']            = $count;
		$data['id']               = $id;
		$data['reviews']          = $reviews;
		$data['count_review']     = $count_review;
		$data['similar_products'] = $similar_products;

		return view('user.pages.product_detail', $data);
	}


	//Review sản phẩm
	public function addReview (Request $request) {
		DB::table('reviews')->insert(
			[
				'pro_id'         => $request->pro_id,
				'person_name'    => $request->person_name,
				'person_email'   => $request->person_email,
				'review_content' => $request->review_content,
				'created_at'     => date("Y-m-d H:i:s"),
				'updated_at'     => date("Y-m-d H:i:s")
			]
		);
      return back();
    }


//-----------------------------------------------------------------------------------------------------
//LẤY DANH SÁCH SP KHUYẾN MÃI

public function getSaleProduct() {
	$sale_products = Product::where('sale_price', '!=', null)->orderBy('id', 'desc')->paginate(8);
	$count_sale    = DB::table('products')->where('sale_price', '!=', null)->count();

	foreach ($sale_products as $newest_prod) {
		$newest_prod->sizes = DB::table('product_properties as pp')
							->select('value', 'qty','sizes.id')
							->join('sizes', 'sizes.id', '=', 'pp.size_id')
							->where('pro_id', $newest_prod->id)
							->orderBy('value')
							->get();

		$where = [
			'pro_id' => $newest_prod->id,
			'is_liked' => 1
		];
		$newest_prod->like = WishList::where($where)->count();
		$newest_prod->is_liked = 0;
		if(Auth::check()){
			$user_id = Auth::user()->id;
			$where['user_id'] = $user_id;
			$user_like = WishList::where($where)->first();
			if(!empty($user_like) && $user_like->is_liked == 1){
				$newest_prod->is_liked = 1;
			}
		}
	}

	$data['sale_products'] = $sale_products;
	$data['count_sale']    = $count_sale;
	return view('user.pages.sale_product', $data);
}


}


