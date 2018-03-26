<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\News;
use App\Comment;
use Auth;

class FrontNewsController extends Controller
{
    //Lấy toàn bộ danh sách tin tức
    public function news (Request $request)
    {
    	//DL truyền sang view để phân trang
		$data['newscate'] = $request->newscate;
		$newscate = $data['newscate'];

		$paginateUrl = route('getNews');
		$data['paginateUrl'] = $paginateUrl;  //truyền sang view sau đó sẽ từ view truyền sang ajax

		//DL truyền sang view để hiển thị news
		$all_news = DB::table('news');
		if (!empty($newscate)) {
			$all_news = $all_news->whereIn('ncate_id', $newscate);
		}
		$all_news = $all_news->orderBy('id', 'desc')->paginate(5);
		$data['all_news'] = $all_news;

		$newscates = DB::table('news_categories')->orderBy('name', 'asc')->get();
    	$data['newscates'] = $newscates;

    	return view('user.pages.news', $data);
    }


    //Hiển thị tin tức khi lọc dữ liệu với Ajax
    public function getNewsAjax (Request $request)
	{
		if ($request->ajax()) {
			$data['newscate'] = $request->newscate;  //lấy danh sách các điều kiện và truyền sang view để phân trang
			$newscate = $data['newscate'];

			//lấy danh sách các news theo điều kiện và truyền sang view để hiển thị
			$all_news = DB::table('news');
			if (!empty($newscate)) {
				$all_news = $all_news->whereIn('ncate_id', $newscate);
			}
			$all_news = $all_news->orderBy('id', 'desc')->paginate(5);
			$data['all_news'] = $all_news;

			$all_news->setPath($request->paginateUrl); //hàm setPath() trong Laravel pagination cho phép tuỳ chọn URL phân trang, paginateUrl là chuỗi json truyền sang từ ajax

            return view('user.blocks.news_filter', $data);
		}
	}


	//Chi tiết tin
	public function newsDetails ($id) {
		$news = News::find($id);

		//Tin cùng loại
		$similar_news = DB::table('news')
						->select('news.*', 'news.id as news_id')
		                ->join('news_categories as nc', 'news.ncate_id', '=', 'nc.id')
		                ->where('nc.id', '=', $news->ncate_id)
		                ->where('news.id', '!=', $id)
		                ->orderBy('news.id', 'desc')
		                ->take(4)
		                ->get();

		//Hiển thị danh sách các bình luận
		$comments = DB::table('comments as cm')
					->select('cm.*', 'users.name as user_name', 'users.avatar as user_avatar')
					->join('users', 'users.id', '=', 'cm.user_id')
		            ->join('news', 'news.id', '=', 'cm.news_id')
		            ->where('cm.news_id', '=', $id)
		            ->get();

		$data['news']         = $news;
		$data['similar_news'] = $similar_news;
		$data['comments']     = $comments;

		return view('user.pages.news_detail', $data);
	}


	//Bình luận về tin tức
	public function postComment (Request $request) {
		$comment = new Comment;
		$comment->news_id = $request->id;
		$comment->user_id = Auth::id();
		$comment->content = $request->content;
		$comment->save();
		return back()->with(['flash_level' => 'success', 'flash_message' => 'Thêm bình luận thành công !']);
	}
}
