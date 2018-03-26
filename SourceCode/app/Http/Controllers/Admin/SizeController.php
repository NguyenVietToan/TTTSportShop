<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Size;
use DB;
use App\Product;


class SizeController extends Controller
{
	public function getList () {
		$sizes = DB::table('sizes')
		         ->select('sizes.*', 'ct.name as cate_name')
		         ->join('categories as ct', 'sizes.cate_id', '=', 'ct.id')
		         ->orderBy('id', 'desc')
		         ->paginate(7);
		$data['sizes'] = $sizes;
		return view('admin.size.list', $data);
	}

	public function getEdit ($id) {
        $size          = Size::findOrFail($id);
        $cates         = DB::table('categories')->orderBy('id', 'asc')->get();
        $data['size']  = $size;
        $data['cates'] = $cates;
	    return view('admin.size.edit', $data);
	}

	public function postEdit (Request $request) {
        $id   = $request->id;
        $size = Size::findOrFail($id);

        $check = DB::table('sizes')
		        ->where('cate_id', '=', $size->cate_id)
		        ->where('value', '=', $request->value)
		        ->count();
        if ($check >= 1) {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Bộ thuộc tính này đã tồn tại']);
        }

        $input = $request->except(['_token']);
        $size->update($input);
        return redirect()->route('admin.size.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa size thành công']);
	}


    public function getAdd ()
    {
        $cates         = DB::table('categories')->orderBy('id', 'asc')->get();
        $data['cates'] = $cates;
        return view('admin.size.add', $data);
    }

    public function postAdd (Request $request)
    {
        if ($request->exists('value')) {
            foreach ($request->value as $val) {
                if (isset($val)) {
                    $check = DB::table('sizes')
                       ->where('cate_id', '=', $request->cate_id)
                       ->where('value', '=', $val)
                       ->count();
                    if ($check >= 1) {
                        return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Size này đã tồn tại !']);
                    } else {
                        $size          = new Size;
                        $size->cate_id = $request->cate_id;
                        $size->value   = $val;
                        $size->save();
                    }
                }
            }
        }
        return redirect()->route('admin.size.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm size thành công !']);
    }


    public function delete_by_id ($id)
    {
    	$size = Size::find($id);
    	$size->delete();
    }

    public function getDelete ($id)
    {
        $this->delete_by_id($id);
        return redirect()->route('admin.size.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa size thành công !']);
    }

    public function postDelete (Request $request)
    {
        if($request->checks){
            foreach($request->checks as $item) {
                $this->delete_by_id($item);
            }
            return redirect()->route('admin.size.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa size thành công !']);
        } else {
            return redirect()->route('admin.size.getList')->with(['flash_level' => 'success', 'flash_message' => 'Không có mục nào được chọn để xóa !']);
        }
    }

}
