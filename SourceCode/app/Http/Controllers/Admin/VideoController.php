<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VideoCategory;
use App\Video;
use App\Http\Requests\Admin\VideoRequest;
use Image, DB, Config, File;


class VideoController extends Controller
{

    public function getList ()
    {
    	$videos = DB::table('videos')->orderBy('id', 'desc')->paginate(3);
    	foreach ($videos as $item) {
            $item->videocate_name = DB::table('video_categories')->where('id', $item->vcate_id)->first()->name;
        }

        //phân trang
        $url = route('admin.video.getList');
        $videos->setPath($url);

    	return view('admin.video.list', compact('videos'));
    }

    public function getAdd ()
    {
    	$videocates = VideoCategory::all();
    	return view('admin.video.add', compact('videocates'));
    }

    public function postAdd (VideoRequest $request)
    {
		$video           = new Video;
		$video->title    = $request->title;
		$video->alias    = changeTitle($request->title);
		$video->link  	 = $request->link;
		$video->vcate_id = $request->vcate_id;
    	$video->save();

    	//Xử lý ảnh thumbnail youtube
		$img_name = $request->file('image')->getClientOriginalName();
        $id       = $video->id;
        $img_dir  = 'resources/upload/images/video/' . $id;
        if (!file_exists($img_dir)) {
            mkdir($img_dir);
        }
        $img = Image::make($request->file('image')->getRealPath());
        $img->resize(160, 160)->save($img_dir . '/' .  $img_name);
        $video->image = $img_name;
        $video->save();

		return redirect()->route('admin.video.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm video thành công']);
    }

    public function getEdit ($id)
    {
		$video      = Video::find($id);
		$videocates = VideoCategory::all();
    	return view('admin.video.edit', compact('video', 'videocates'));
    }

    public function postEdit (Request $request)
    {
    	$id = $request->id;
        $this->validate($request,
            [
	            'title'    => 'required',
	            'link'     => 'required'
        	],
            [
	            'title.required'    => 'Vui lòng nhập tiêu đề video',
	            'link.required'     => 'Vui lòng nhập ID video trên youtube'
        	]
        );

		$video = Video::find($id);
        $check = DB::table('videos')->where('link', '=', $request->link)->count();
        if ( ($request->link == $video->link) || (($request->link != $video->link) && ($check < 1)) ) {
            $video->title = $request->title;
            $video->alias = changeTitle($request->title);
            $video->link = $request->link;
            //để cập nhật ảnh logo mới thì cần phải: tải ảnh mới lên (lưu theo tên ảnh) -> di chuyển nó vào thư mục chứa -> xóa ảnh cũ đi
            $img_dir = 'resources/upload/images/video/' . $id;
            if (!file_exists($img_dir)) {
                mkdir($img_dir);
            }
            $img_current = $img_dir . '/' . $request->img_current;  //đường dẫn tới hình ảnh hiện tại
            if ( ! empty($request->file('image')) ) { //nếu tồn tại file ảnh mới
                $img_ext = $request->file('image')->getClientOriginalExtension();  //lấy phần đuôi mở rộng của file
                if (in_array($img_ext, Config::get('constants.image_valid_extension'))) { //kiểm tra $img_ext có nằm trong tập các đuôi ko (xem trong folder config/constants)

                        //xóa ảnh cũ
                    if ( File::exists($img_current) ) {
                        File::delete($img_current);
                    }
                    
                    $file_name    = $request->file('image')->getClientOriginalName();
                    $video->image = $file_name;
                    $img = Image::make($request->file('image')->getRealPath());
                    $img->resize(160, 160)->save($img_dir . '/' .  $file_name);
                    
                } else {
                    return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'File bạn chọn không phải là một hình ảnh !']);
                }
            }
            $video->save();
            return redirect()->route('admin.video.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa video thành công !']);
        } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Video này đã tồn tại !']);
        }
    }

    public function delete_by_id ($id)
    {
    	$video = Video::find($id);

		$thn_dir  = 'resources/upload/images/video/' . $id;
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

    public function getDelete ($id)
    {
    	$this->delete_by_id($id);
    	return redirect()->route('admin.video.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa video thành công']);
    }

    public function postDelete (Request $request)
    {
        if($request->checks){
            foreach($request->checks as $item) {
                $this->delete_by_id($item);
            }
            return redirect()->route('admin.video.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa video thành công']);
        } else {
            return redirect()->route('admin.video.getList')->with(['flash_level' => 'warning', 'flash_message' => 'Không có mục nào được chọn để xóa']);
        }
    }
}
