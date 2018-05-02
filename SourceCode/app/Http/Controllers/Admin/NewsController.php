<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NewsCategory;
use App\News;
use App\Http\Requests\Admin\NewsRequest;
use Image, DB, Config, File;


class NewsController extends Controller
{
    public function getList ()
    {
    	$news = DB::table('news')->orderBy('id', 'desc')->paginate(7);
    	foreach ($news as $item) {
            $item->newscate_name = DB::table('news_categories')->where('id', $item->ncate_id)->first()->name;
        }

        //phân trang
        $url = route('admin.news.getList');
        $news->setPath($url);

        $data['news'] = $news;

    	return view('admin.news.list', $data);
    }

    public function getAdd ()
    {
    	$newscate = NewsCategory::all();
    	return view('admin.news.add', compact('newscate'));
    }

    public function postAdd (NewsRequest $request)
    {
		$news           = new News;
		$news->title    = $request->txtTitle;
		$news->alias    = changeTitle($request->txtTitle);
		$news->summary  = $request->txtSummary;
		$news->content  = $request->txtContent;
		$news->ncate_id = $request->newsCate;
		$news->source   = $request->txtSource;
		$news->author   = $request->txtAuthor;
    	$news->save();

    	//Xử lý ảnh
    	if ($request->file('fImages')) {
    		$img_name = $request->file('fImages')->getClientOriginalName();
			$main_dir = 'resources/upload/images/news';
			$id       = $news->id;   //chú ý: phải $news->save() ở trên thì mới có id để lấy
			$lg_dir   = $main_dir . '/large/' . $id;
			$thn_dir  = $main_dir . '/thumbnail/' . $id;
			if (!file_exists($lg_dir)) {
				mkdir($lg_dir);
			}
			if (!file_exists($thn_dir)) {
				mkdir($thn_dir);
			}
			$img = Image::make($request->file('fImages')->getRealPath());
			$img->resize(500, 400)->save($lg_dir . '/' .  $img_name);
			$img->resize(100, 100)->save($thn_dir . '/' .  $img_name);
			$news->image = $img_name;
			$news->save();
    	}

		return redirect()->route('admin.news.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm tin tức thành công']);
    }

    public function getEdit ($id)
    {
		$news     = News::find($id);
		$newscate = NewsCategory::all();
    	return view('admin.news.edit', compact('news', 'newscate'));
    }

    public function postEdit (Request $request)
    {
    	$id = $request->id;
		$news           = News::find($id);
		$news->summary  = $request->txtSummary;
		$news->content  = $request->txtContent;
		$news->source   = $request->txtSource;
		$news->author   = $request->txtAuthor;

		//Cấm sửa loại tin
		//Nếu giữ nguyên tiêu đề và sửa những trường khác thì cho phép sửa
		//Hoặc nếu sửa tiêu đề thì kiểm tra xem tiêu đề đó đã có trong CSDL chưa, nếu chưa thì cho phép sửa, nếu rồi thì báo lỗi
		$check = DB::table('news')->where('news.title', '=', $request->txtTitle)->count();
		if ( ($request->txtTitle == $news->title) || (($request->txtTitle != $news->title) && ($check < 1)) ) {
			$news->title = $request->txtTitle;
			$news->alias = changeTitle($request->txtTitle);

			//Cập nhật hình ảnh
			$main_dir = 'resources/upload/images/news';
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
				//thêm ảnh mới (resize)
				$img_ext = $request->file('fImages')->getClientOriginalExtension();  //lấy phần đuôi mở rộng của file
	            if (in_array($img_ext, Config::get('constants.image_valid_extension'))) { //kiểm tra $img_ext có nằm trong tập các đuôi ko (xem trong folder config/constants)

	            		//xóa ảnh cũ
					if (File::exists($lg_cur_dir)) {
						File::delete($lg_cur_dir);
					}
					if (File::exists($thn_cur_dir)) {
						File::delete($thn_cur_dir);
					}
					
					$file_name   = $request->file('fImages')->getClientOriginalName();
					$news->image = $file_name;
					$img = Image::make($request->file('fImages')->getRealPath());
					$img->resize(500, 500)->save($lg_dir . '/' .  $file_name);
					$img->resize(100, 100)->save($thn_dir . '/' .  $file_name);
					
	         	} else {
	         		return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'File bạn chọn không phải là một hình ảnh']);
	         	}
			} else {
				echo "1";
			}
			$news->save();

			return redirect()->route('admin.news.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa tin tức thành công']);

		} else {
			return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Tiêu đề tin này đã tồn tại !']);
		}
    }

    public function delete_by_id ($id)
    {
    	$news = News::find($id);

    	$main_dir = 'resources/upload/images/news';
		$lg_dir   = $main_dir . '/large/' . $id;
		$thn_dir  = $main_dir . '/thumbnail/' . $id;

		//Xóa hình ảnh
		$lg_img  = $lg_dir . '/' . $news->image;
		$thn_img = $thn_dir . '/' . $news->image;
		if (file_exists($lg_img)) {
			File::delete($lg_img);
		}
		if (file_exists($thn_img)) {
			File::delete($thn_img);
		}

		//Xóa thư mục id
		if (file_exists($lg_dir)) {
			rmdir($lg_dir);
		}
		if (file_exists($thn_dir)) {
			rmdir($thn_dir);
		}

		//Xóa dữ liệu còn lại
    	$news->delete();
    }

    public function getDelete ($id)
    {
    	$this->delete_by_id($id);
    	return redirect()->route('admin.news.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa tin tức thành công']);
    }

    public function postDelete (Request $request)
    {
        if($request->checks){
            foreach($request->checks as $item) {
                $this->delete_by_id($item);
            }
            return redirect()->route('admin.news.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa tin tức thành công']);
        } else {
            return redirect()->route('admin.news.getList')->with(['flash_level' => 'warning', 'flash_message' => 'Không có mục nào được chọn để xóa']);
        }
    }
}
