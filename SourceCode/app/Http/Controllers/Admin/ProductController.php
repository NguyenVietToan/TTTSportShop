<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Sport;
use App\Brand;
use App\Product;
use App\ProductImage;
use App\ProductProperty;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\Admin\ProductEditRequest;
use Image;
use File, DB, Config;
use Input;


class ProductController extends Controller
{
	public function getList (Request $request)
	{
		$data['keyword'] = $request->keyword;
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
		// $pro_paging = $products->appends(Request::capture()->except('page'))->render();  //phân trang

		$cate  = Category::all();
		$sport = Sport::all();
		$brand = Brand::all();

		$paginateUrl         = route('admin.product.getList');
		$data['paginateUrl'] = $paginateUrl;

		$data['products']   = $products;
		$data['cate']       = $cate;
		$data['sport']      = $sport;
		$data['brand']      = $brand;
		$data['cate_id']    = $cate_id;
		$data['sport_id']   = $sport_id;
		$data['brand_id']   = $brand_id;
		$data['gender']     = $gender;
		// $data['pro_paging'] = $pro_paging;

		return view('admin.product.list', $data);
	}

    public function getAdd ()
    {
		$cate  = Category::all();
		$sport = Sport::all();
		$brand = Brand::all();
    	return view('admin.product.add', compact('cate', 'sport', 'brand'));
    }

    public function postAdd (ProductRequest $request)
    {
		$product               = new Product;
		$product->name         = $request->txtProName;  //chuyển về dạng viết hoa đầu mỗi từ
		$product->alias        = changeTitle($request->txtProName);
		$product->import_price = $request->txtImportPrice;
		$product->price        = $request->txtPrice;
		$product->gender       = $request->chooseGender;
		$product->info         = $request->txtInfo;
		$product->description  = $request->txtDescription;
		$product->cate_id      = $request->cateParent;
		$product->sport_id     = $request->sportParent;
		$product->brand_id     = $request->brandParent;
		$product->save();

		//Xử lý ảnh chính
		$main_dir = 'resources/upload/images/product';
		$img_name = $request->file('fImages')->getClientOriginalName();
		$id       = $product->id;   //chú ý: phải $product->save() ở trên thì mới có id để lấy
		$lg_dir   = $main_dir . '/large/' . $id;
		$sm_dir   = $main_dir . '/small/' . $id;
		$thn_dir  = $main_dir . '/thumbnail/' . $id;
		if (!file_exists($lg_dir)) {
			mkdir($lg_dir);  //nếu chưa tồn tại folder thì tạo folder mới có tên chính là id, nằm trong resources/upload/images/product/large
		}
		if (!file_exists($sm_dir)) {
			mkdir($sm_dir);
		}
		if (!file_exists($thn_dir)) {
			mkdir($thn_dir);
		}

		$img = Image::make($request->file('fImages')->getRealPath());  //sử dụng thư viện Intervention Image: ở dây, ::make() dùng để tạo 1 hình ảnh mới dựa vào url của file upload
		$img->resize(500, 500)->save($lg_dir . '/' .  $img_name);   //resize ảnh về chiều rộng 500px, cao 500px
		$img->resize(300, 300)->save($sm_dir . '/' .  $img_name);
		$img->resize(100, 100)->save($thn_dir . '/' .  $img_name);
		$product->image = $img_name;
		$product->save();

		//Xử lý ảnh chi tiết
		if ($request->exists('fProductDetailImage')) {
			$lg_detail_dir  = $lg_dir . '/detail';
			$sm_detail_dir  = $sm_dir . '/detail';
			$thn_detail_dir = $thn_dir . '/detail';
			if (!file_exists($lg_detail_dir)) {
				mkdir($lg_detail_dir);
			}
			if (!file_exists($sm_detail_dir)) {
				mkdir($sm_detail_dir);
			}
			if (!file_exists($thn_detail_dir)) {
				mkdir($thn_detail_dir);
			}

			foreach ($request->file('fProductDetailImage') as $file) {
				if (isset($file)) {
					$product_image         = new ProductImage;
					$product_image->name   = $file->getClientOriginalName();
					$product_image->pro_id = $id;
					$img_details           = Image::make($file->getRealPath());
					$img_details->resize(500, 500)->save($lg_detail_dir . '/' .  $product_image->name);
					$img_details->resize(300, 300)->save($sm_detail_dir . '/' .  $product_image->name);
					$img_details->resize(100, 100)->save($thn_detail_dir . '/' .  $product_image->name);
					$product_image->save();
				}
			}
		}

		return redirect()->route('admin.product.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm sản phẩm thành công']);
    }

    public function getEdit ($id)
    {
		$product = Product::findOrFail($id);
		$cate    = Category::all();
		$sport   = Sport::all();
		$brand   = Brand::all();
		$product_images = DB::table('product_images')->where('pro_id', '=', $id )->get();
    	return view('admin.product.edit', compact('product', 'cate', 'sport', 'brand', 'id', 'product_images'));
    }

    public function postEdit (ProductEditRequest $request)
    {
    	$id = $request->id;
    	$product = Product::find($id);
		$product->import_price = $request->txtImportPrice;
		$product->price        = $request->txtPrice;
		$product->gender       = $request->chooseGender;
		$product->info         = $request->txtInfo;
		$product->description  = $request->txtDescription;

		//Cấm sửa thể loại, bộ môn, thương hiệu
		//Nếu giữ nguyên tên và sửa những trường khác thì cho phép sửa
		//Hoặc nếu sửa tên thì kiểm tra xem tên đó đã có trong CSDL chưa, nếu chưa thì cho phép sửa, nếu rồi thì báo lỗi
		$check = DB::table('products as pr')->where('pr.name', '=', $request->txtProName)->count();
		if ( ($request->txtProName == $product->name) || (($request->txtProName != $product->name) && ($check < 1)) ) {
			$product->name  = $request->txtProName;
			$product->alias = changeTitle($request->txtProName);

			//Cập nhật ảnh đại diện
			$main_dir = 'resources/upload/images/product';
			$lg_dir   = $main_dir . '/large/' . $id;
			$sm_dir   = $main_dir . '/small/' . $id;
			$thn_dir  = $main_dir . '/thumbnail/' . $id;
			if (!file_exists($lg_dir)) {
				mkdir($lg_dir);
			}
			if (!file_exists($sm_dir)) {
				mkdir($sm_dir);
			}
			if (!file_exists($thn_dir)) {
				mkdir($thn_dir);
			}

				//lấy ảnh hiện tại
			$img_cur_name = $request->img_current;
			$lg_cur_dir   = $lg_dir . '/' . $img_cur_name;
			$sm_cur_dir   = $sm_dir . '/' . $img_cur_name;
			$thn_cur_dir  = $thn_dir . '/' . $img_cur_name;

				//nếu tồn tại ảnh đại diện mới: tải ảnh mới lên, lưu vào CSDL và xóa ảnh cũ
			if (!empty($request->file('fImages'))) {
				//thêm ảnh mới (resize)
				$img_ext = $request->file('fImages')->getClientOriginalExtension();  //lấy phần đuôi mở rộng của file
	            if (in_array($img_ext, Config::get('constants.image_valid_extension'))) { //kiểm tra $img_ext có nằm trong tập các đuôi ko (xem trong folder config/constants)
	            	$file_name      = $request->file('fImages')->getClientOriginalName();
					$product->image = $file_name;
					$img = Image::make($request->file('fImages')->getRealPath());
					$img->resize(500, 500)->save($lg_dir . '/' .  $file_name);
					$img->resize(300, 300)->save($sm_dir . '/' .  $file_name);
					$img->resize(100, 100)->save($thn_dir . '/' .  $file_name);
						//xóa ảnh cũ
					if (File::exists($lg_cur_dir)) {
						File::delete($lg_cur_dir);
					}
					if (File::exists($sm_cur_dir)) {
						File::delete($sm_cur_dir);
					}
					if (File::exists($thn_cur_dir)) {
						File::delete($thn_cur_dir);
					}
	         	} else {
	         		return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'File bạn chọn không phải là một hình ảnh']);
	         	}
			} else {
				echo 'Không có file ảnh mới';
			}
			$product->save();

			//Cập nhật ảnh chi tiết: nếu tồn tại ảnh chi tiết mới thì thêm vào bảng product_images
			if(!empty($request->file('fProductDetailImage'))) {
				foreach ($request->file('fProductDetailImage') as $file) {
					if (!empty($file)) {
						$img_detail_ext = $file->getClientOriginalExtension();
			            if (in_array($img_detail_ext, Config::get('constants.image_valid_extension'))) {
			            	$lg_detail_dir  = $lg_dir . '/detail';
							$sm_detail_dir  = $sm_dir . '/detail';
							$thn_detail_dir = $thn_dir . '/detail';
							if(!file_exists($lg_detail_dir)){
								mkdir($lg_detail_dir);
							}
							if(!file_exists($sm_detail_dir)){
								mkdir($sm_detail_dir);
							}
							if(!file_exists($thn_detail_dir)){
								mkdir($thn_detail_dir);
							}

							$product_images = new ProductImage;
							$product_images->name   = $file->getClientOriginalName();
							$product_images->pro_id = $id;
							$img = Image::make($file->getRealPath());
							$img->resize(500, 500)->save($lg_detail_dir . '/' .  $product_images->name);
							$img->resize(300, 300)->save($sm_detail_dir . '/' .  $product_images->name);
							$img->resize(100, 100)->save($thn_detail_dir . '/' .  $product_images->name);
							$product_images->save();

		            	} else {
		            		return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'File bạn chọn không phải là một hình ảnh']);
		            	}
					} else {
						echo 'Không có file ảnh mới';
					}
				}
			}

			return redirect()->route('admin.product.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa sản phẩm thành công']);
		} else {
			return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Tên sản phẩm này đã tồn tại !']);
		}
    }


    //Đây là 1 hàm xóa sản phẩm theo id, hàm này không có trong route
    public function delete_by_id ($id)
    {
    	//Xóa sản phẩm thì phải xóa ảnh chi tiết (bảng product_images) và thuộc tính (bảng product_properties) trước sau đó mới xóa dữ liệu trong bảng products vì nếu xóa ở bảng products trước thì sẽ không biết là cần xóa ảnh nào, thuộc tính nào nữa

    	//Xóa ảnh chi tiết
    	$main_dir = 'resources/upload/images/product';
		$lg_dir   = $main_dir . '/large/' . $id;
		$sm_dir   = $main_dir . '/small/' . $id;
		$thn_dir  = $main_dir . '/thumbnail/' . $id;

		$lg_detail_dir  = $lg_dir . '/detail';
		$sm_detail_dir  = $sm_dir . '/detail';
		$thn_detail_dir = $thn_dir . '/detail';

		$product_images = DB::table('product_images')->where('pro_id', $id)->get();
		foreach ($product_images as $images) {
			$lg_detail_img  = $lg_detail_dir . '/' . $images->name;
			$sm_detail_img  = $sm_detail_dir . '/' . $images->name;
			$thn_detail_img = $thn_detail_dir . '/' . $images->name;
			//Xóa ảnh
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

		//Xóa thuộc tính
		$product_properties = ProductProperty::where('pro_id', '=', $id)->get();
		foreach ($product_properties as $properties) {
			$properties->delete();
		}

		//Xóa sản phẩm
		$products = Product::findOrFail($id);
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


    //Khi nhấn xóa bình thường thì nó sẽ gọi đến route delete/{id} dẫn đến hàm getDelete, trong hàm này thì ta gọi đến hàm delete() để xóa
    public function getDelete ($id)
    {
    	$this->delete_by_id($id);
		return redirect()->route('admin.product.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa sản phẩm thành công']);
    }


    //Xóa sản phẩm theo checkbox
    public function postDelete (Request $request)
    {
    	if($request->checks){
			foreach($request->checks as $item){
				$this->delete_by_id($item);
			}
			return redirect()->route('admin.product.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa sản phẩm thành công']);
		} else {
            return redirect()->route('admin.product.getList')->with(['flash_level' => 'danger', 'flash_message' => 'Không có mục nào được chọn để xóa !']);
        }
    }


    //Thêm giá giảm cho sp
    public function addSale (Request $request) {
		$pro_id     = $request->pro_id;
		$sale_price = $request->sale_price;
		$old_price  = DB::table('products')->where('id', $pro_id)->first()->price;
		if ($sale_price <= $old_price) {
			DB::table('products')->where('id', $pro_id)->update(['sale_price' => $sale_price]);
      		return redirect()->route('admin.product.getList')->with('status', 'Thêm giá giảm thành công!');
		} else {
			return redirect()->route('admin.product.getList')->with('error', 'Thêm giá giảm không thành công! Giá giảm phải thấp hơn giá ban đầu!');
		}
    }

}
