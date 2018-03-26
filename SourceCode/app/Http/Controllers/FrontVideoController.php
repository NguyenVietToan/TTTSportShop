<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Video;

class FrontVideoController extends Controller
{

	//Lấy toàn bộ danh sách video
    public function video (Request $request)
    {
    	//DL truyền sang view để phân trang
		$data['videocate']   	  = $request->videocate;
		$videocate = $data['videocate'];

		$paginateUrl         = route('getVideo');
		$data['paginateUrl'] = $paginateUrl;  //truyền sang view sau đó sẽ từ view truyền sang ajax

		//DL truyền sang view để hiển thị video
		$all_videos = DB::table('videos');
		if (!empty($videocate)) {
			$all_videos = $all_videos->whereIn('vcate_id', $videocate);
		}
		$all_videos = $all_videos->orderBy('id', 'desc')->paginate(8);
		$data['all_videos'] = $all_videos;

		$videocates = DB::table('video_categories')->orderBy('name', 'asc')->get();
    	$data['videocates'] = $videocates;

    	return view('user.pages.video', $data);
    }


    //Hiển thị video khi lọc dữ liệu với Ajax
    public function getVideoAjax (Request $request)
	{
		if ($request->ajax()) {
			$data['videocate'] = $request->videocate;  //lấy danh sách các điều kiện và truyền sang view để phân trang
			$videocate = $data['videocate'];

			//lấy danh sách các video theo điều kiện và truyền sang view để hiển thị
			$all_videos = DB::table('videos');
			if (!empty($videocate)) {
				$all_videos = $all_videos->whereIn('vcate_id', $videocate);
			}
			$all_videos = $all_videos->orderBy('id', 'desc')->paginate(8);

			$data['all_videos'] = $all_videos;

			$all_videos->setPath($request->paginateUrl); //hàm setPath() trong Laravel pagination cho phép tuỳ chọn URL phân trang, paginateUrl là chuỗi json truyền sang từ ajax

            return view('user.blocks.video_filter', $data);
		}
	}


	//Chi tiết video
	public function videoDetails ($id) {
		$video = Video::find($id);

		//Video cùng loại
		$similar_videos = DB::table('videos')
						->select('videos.*', 'videos.id as video_id')
		                ->join('video_categories as vc', 'videos.vcate_id', '=', 'vc.id')
		                ->where('vc.id', '=', $video->vcate_id)
		                ->where('videos.id', '!=', $id)
		                ->orderBy('vc.id', 'desc')
		                ->take(6)
		                ->get();

		$data['video'] = $video;
		$data['similar_videos'] = $similar_videos;

		return view('user.pages.video_detail', $data);
	}
}
