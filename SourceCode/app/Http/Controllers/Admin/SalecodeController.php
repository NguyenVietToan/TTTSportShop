<?php

namespace App\Http\Controllers\Admin;

use App\Salecode;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SaleCodeRequest;


class SalecodeController extends Controller
{

    //Hiển thị list các mã giảm giá
    public function getList()
    {
        $salecodes = DB::table('salecodes')->orderBy('id', 'desc')->paginate(7);
        //phân trang
        $url = route('admin.salecode.getList');
        $salecodes->setPath($url);
        return view('admin.salecode.list', compact('salecodes'));
    }

    public function getAdd ()
    {
        return view('admin.salecode.add');
    }

    public function postAdd (SaleCodeRequest $request)
    {
        
        $saleCode              = new Salecode;
        $saleCode->salecode    = $request->salecode;
        $saleCode->salepercent    = $request->salepercent;
        $saleCode->used    = 0;
        $saleCode->save();
      
        return redirect()->route('admin.salecode.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm mã thành công !']);
    }

    public function delete_by_id ($id)
    {
        $saleCode = Salecode::find($id);
        $saleCode->delete();
    }

    public function getDelete($id)
    {
        $this->delete_by_id($id);
        return redirect()->route('admin.salecode.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa mã thành công !']);
    }

    public function postDelete (Request $request)
    {
        if ($request->checks) {
            foreach($request->checks as $item) {
                $this->delete_by_id($item);
            }
            return redirect()->route('admin.salecode.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa mã thành công !']);
        } else {
            return redirect()->route('admin.salecode.getList')->with(['flash_level' => 'warning', 'flash_message' => 'Không có mục nào được chọn để xóa !']);
        }
    }



}
