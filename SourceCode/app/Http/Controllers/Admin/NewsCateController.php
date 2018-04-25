<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsCateRequest;
use App\NewsCategory;
use App\News;
use DB, File;


class NewsCateController extends Controller
{
	public function getList ()
	{
		$newscates = DB::table('news_categories')->orderBy('id', 'desc')->paginate(3);

        //phân trang
        $url = route('admin.newscate.getList');
        $newscates->setPath($url);

		return view('admin.newscate.list', compact('newscates'));
	}
    public function getAdd ()
    {
    	return view('admin.newscate.add');
    }

    public function postAdd (NewsCateRequest $request)
    {
		$newscate              = new NewsCategory;
		$newscate->name        = $request->txtNewsCateName;
        $newscate->alias       = changeTitle($request->txtNewsCateName);
		$newscate->description = $request->txtDescription;
        $newscate->save();
		return redirect()->route('admin.newscate.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm loại tin thành công !']);
    }

    public function getEdit ($id)
    {
    	$newscate = NewsCategory::find($id);
    	return view('admin.newscate.edit', compact('newscate'));
    }

    public function postEdit (Request $request)
    {
        $id = $request->id;
    	$this->validate($request,
    	  	['txtNewsCateName' => 'required'],
            ['txtNewsCateName.required' => 'Vui lòng nhập tên thể loại']
    	);
		$newscate              = NewsCategory::find($id);
		$newscate->description = $request->txtDescription;

        $check = DB::table('news_categories')->where('name', '=', $request->txtNewsCateName)->count();
        if ( ($request->txtNewsCateName == $newscate->name) || (($request->txtNewsCateName != $newscate->name) && ($check < 1)) ) {
            $newscate->name        = $request->txtNewsCateName;
            $newscate->alias       = changeTitle($request->txtNewsCateName);
            $newscate->save();
            return redirect()->route('admin.newscate.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa loại tin thành công !']);
        } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Loại tin này đã tồn tại !']);
        }
    }

    public function delete_by_id ($id)
    {
    	$newscate = NewsCategory::find($id);

        //Xóa tin tức tương ứng
        $news = News::where('ncate_id', '=', $id)->get();

        if (isset($news)) {
            foreach ($news as $n) {
                $news_id = $n->id;  //lấy id của tin tức

                $main_dir = 'resources/upload/images/news';
                $lg_dir   = $main_dir . '/large/' . $news_id;
                $thn_dir  = $main_dir . '/thumbnail/' . $news_id;

                //Xóa hình ảnh
                $lg_img  = $lg_dir . '/' . $n->image;
                $thn_img = $thn_dir . '/' . $n->image;
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
                $n->delete();
            }
        }

        //Xóa dữ liệu loại tin còn lại
        $newscate->delete();

    }

    public function getDelete ($id)
    {
    	$this->delete_by_id($id);
    	return redirect()->route('admin.newscate.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa loại tin thành công !']);
    }

    public function postDelete (Request $request)
    {
    	if($request->checks) {
            foreach($request->checks as $item){
                $this->delete_by_id($item);
            }
            return redirect()->route('admin.newscate.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa loại tin thành công !']);
        } else {
        	return redirect()->route('admin.newscate.getList')->with(['flash_level' => 'warning', 'flash_message' => 'Không có mục nào được chọn để xóa !']);
        }
    }
}
