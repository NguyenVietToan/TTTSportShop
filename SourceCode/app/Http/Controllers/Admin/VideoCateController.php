<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VideoCategory;
use App\Video;
use DB, File;


class VideoCateController extends Controller
{
    public function getList ()
	{
		$videocates = DB::table('video_categories')->orderBy('id', 'desc')->paginate(3);

        //phân trang
        $url = route('admin.videocate.getList');
        $videocates->setPath($url);

		return view('admin.videocate.list', compact('videocates'));
	}


    public function getAdd ()
    {
    	return view('admin.videocate.add');
    }


    public function postAdd (Request $request)
    {
      	$this->validate($request,
      	  	['name' => 'required'],
            ['name.required' => 'Vui lòng nhập tên thể loại video']
      	);

        $videocate              = new VideoCategory;
        $videocate->name        = $request->name;
        $videocate->alias       = changeTitle($request->name);
        $videocate->description = $request->description;
        $videocate->save();

      	return redirect()->route('admin.videocate.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm thể loại video thành công !']);
    }

    public function getEdit ($id)
    {
      	$videocate = VideoCategory::find($id);
      	return view('admin.videocate.edit', compact('videocate'));
    }

    public function postEdit (Request $request)
    {
        $id = $request->id;
    	  $this->validate($request,
      	  	['name' => 'required'],
            ['name.required' => 'Vui lòng nhập tên thể loại video']
    	  );

        $videocate              = VideoCategory::find($id);
        $videocate->description = $request->description;

        $check = DB::table('video_categories')->where('name', '=', $request->name)->count();
        if ( ($request->name == $videocate->name) || (($request->name != $videocate->name) && ($check < 1)) ) {
            $videocate->name  = $request->name;
            $videocate->alias = changeTitle($request->name);
            $videocate->save();
            return redirect()->route('admin.videocate.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa thể loại video thành công !']);
        } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Thể loại video này đã tồn tại !']);
        }
    }

    public function delete_by_id ($id)
    {
    	  $videocate = VideoCategory::find($id);

        //Xóa video tương ứng
        $videos = Video::where('vcate_id', '=', $id)->get();

        if (isset($videos)) {
            foreach ($videos as $video) {
                $video_id = $video->id;  //lấy id của video
                $thn_dir  = 'resources/upload/images/video/' . $video_id;

                //Xóa hình ảnh
                $thn_img = $thn_dir . '/' . $video->image;
                if (file_exists($thn_img)) {
                    File::delete($thn_img);
                }

                //Xóa thư mục id
                if (file_exists($thn_dir)) {
                    rmdir($thn_dir);
                }

                //Xóa dữ liệu còn lại
                $video->delete();
            }
        }

        //Xóa dữ liệu loại tin còn lại
        $videocate->delete();
    }

    public function getDelete ($id)
    {
      	$this->delete_by_id($id);
      	return redirect()->route('admin.videocate.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thể loại video thành công !']);
    }

    public function postDelete (Request $request)
    {
    	  if($request->checks){
            foreach($request->checks as $item){
                $this->delete_by_id($item);
            }
            return redirect()->route('admin.videocate.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thể loại video thành công !']);
        } else {
        	return redirect()->route('admin.videocate.getList')->with(['flash_level' => 'warning', 'flash_message' => 'Không có mục nào được chọn để xóa !']);
        }
    }
}
