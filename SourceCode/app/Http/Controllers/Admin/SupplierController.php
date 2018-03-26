<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SupplierRequest;
use App\Supplier;
use Input;
use DB;


class SupplierController extends Controller
{
	public function getList()
	{
		$suppliers = DB::table('suppliers')->orderBy('id', 'desc')->paginate(7);
		foreach ($suppliers as $item) {
            $id_ward = $item->wardid;
            $ward = DB::table('ward')->where('wardid', '=', $id_ward)->first();
            $district = DB::table('district')->where('districtid', '=', $ward->districtid)->first();
            $province = DB::table('province')->where('provinceid', '=', $district->provinceid)->first();
            $item->full_address = $item->address . ' - ' . $ward->name . ' - ' . $district->name . ' - ' . $province->name;
		}

		//phân trang
		$url = route('admin.supplier.getList');
		$suppliers->setPath($url);

		return view('admin.supplier.list')->with(['suppliers'=>$suppliers]);
	}

    public function getAdd ()
    {
    	$provinces = DB::table('province')->get();
    	return view('admin.supplier.add', compact('provinces'));
    }

    public function postAdd (SupplierRequest $request)
    {
		$supplier          = new Supplier;
		$supplier->name    = $request->name;
		$supplier->address = $request->address;
		$supplier->phone   = $request->phone;
		$supplier->email   = $request->email;
		$supplier->wardid  = $request->ward;
		$supplier->save();
  		return redirect()->route('admin.supplier.getList')->with(['flash_level' => 'success', 'flash_message' => 'Thêm nhà cung cấp thành công !']);
    }

    public function getEdit ($id)
    {
		$supplier  = Supplier::find($id);
		$ward      = DB::table('ward')->where('wardid', '=', $supplier->wardid)->first();
		$wards     = DB::table('ward')->where('districtid', '=', $ward->districtid)->get();
		$district  = DB::table('district')->where('districtid', '=', $ward->districtid)->first();
		$districts = DB::table('district')->where('provinceid', '=', $district->provinceid)->get();
		$province  = DB::table('province')->where('provinceid', '=', $district->provinceid)->first();
		$provinces = DB::table('province')->get();

		$location   = array();  //tạo mảng location để chứa 3 giá trị đó là wardid, districtid và provinceid
		$location[] = $supplier->wardid;  //$location[0]
		$location[] = $ward->districtid;  //$location[1]
		$location[] = $district->provinceid; //$location[2]

		$full_address = $supplier->address;

		$data['supplier']     = $supplier;
		$data['provinces']    = $provinces;
		$data['districts']    = $districts;
		$data['wards']        = $wards;
		$data['location']     = $location;
		$data['full_address'] = $full_address;

		return view('admin.supplier.edit', $data);
    }

    public function postEdit (Request $request)
    {
		$id = $request->id;
		$this->validate($request,
            [
	            'name'    => 'required',
	            'address' => 'required',
	            'phone'   => 'required|numeric',
	            'email'   => 'required|email'
        	],
            [
	            'name.required'    => 'Vui lòng nhập tên nhà cung cấp',
	            'address.required' => 'Vui lòng nhập địa chỉ',
	            'phone.required'   => 'Vui lòng nhập số điện thoại',
	            'phone.numeric'    => 'Số điện thoại phải ở dạng số',
	            'email.required'   => 'Vui lòng nhập email',
	            'email.email'      => 'Email không đúng định dạng'
        	]
        );
		$supplier          = Supplier::find($id);
		$supplier->name    = $request->name;
		$supplier->address = $request->address;
		$supplier->phone   = $request->phone;
		$supplier->wardid  = $request->ward;

		$check = DB::table('suppliers')->where('email', '=', $request->email)->count();
		if ( ($request->email == $supplier->email) || (($request->email != $supplier->email) && ($check < 1)) ) {
			$supplier->email   = $request->email;
	    	$supplier->save();
	    	return redirect()->route('admin.supplier.getList')->with(['flash_level' => 'success', 'flash_message' => 'Sửa nhà cung cấp thành công !']);
	    } else {
            return redirect()->back()->with(['flash_level' => 'danger', 'flash_message' => 'Nhà cung cấp này đã tồn tại !']);
        }

    }

    public function delete_by_id ($id)
    {
    	$supplier = Supplier::find($id);
    	$supplier->delete();
    }

    public function getDelete ($id)
    {
        $this->delete_by_id($id);
        return redirect()->route('admin.supplier.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa nhà cung cấp thành công !']);
    }

    public function postDelete (Request $request)
    {
        if($request->checks){
            foreach($request->checks as $item) {
                $this->delete_by_id($item);
            }
            return redirect()->route('admin.supplier.getList')->with(['flash_level' => 'success', 'flash_message' => 'Xóa nhà cung cấp thành công !']);
        } else {
            return redirect()->route('admin.supplier.getList')->with(['flash_level' => 'success', 'flash_message' => 'Không có mục nào được chọn để xóa !']);
        }
    }
}
