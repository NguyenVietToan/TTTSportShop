<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Product;
use App\ProductProperty;

class CartController extends Controller
{

	//Lấy thông tin giỏ hàng
    public function getCartInfo () {
    	$cartItems = Cart::content();
    	$total = Cart::subtotal(0,'','.');  // 0 là số chữ số phần thập phân; '' là dấu ngăn cách phần thập phân với phần nguyên; '.' là dấu ngăn cách hàng nghìn
    	return view('user.pages.cart', compact('cartItems', 'total'));
    }


    //Thêm 1 sp vào giỏ
    public function postAddItem (Request $request){
        $pro_id  = $request->pro_id;
        $size    = $request->size;
        $options = [];
        $data['pro_id'] = $pro_id;
        if (!empty($size)) {
            $options['size'] = $size;
            $data['size_id'] = $size;
        }
        $product_property = new ProductProperty;
        $maxQty = $product_property->getQty($data);  //lấy số lượng sp còn lại (hàm trong ProductProperty.php)
        if (empty($maxQty)) {
            return response()->json([
                'state' => 0,
                'msg'   => 'Sản phẩm đã hết hàng'
            ]);
        }

        $product           = Product::find($pro_id);
        $options['image']  = $product->image;
        $response          = array();
        $options['maxQty'] = $maxQty;
        //nếu có sp thì thêm vào giỏ: cần kiểm tra có giá khuyến mãi ko
        if (!empty($product)) {
            if (!empty($product->sale_price) && $product->sale_price < $product->price) {
                Cart::add(array('id' => $pro_id, 'name' => $product->name, 'qty' => 1, 'price' => $product->sale_price, 'options' => $options));
            } else {
                Cart::add(array('id' => $pro_id, 'name' => $product->name, 'qty' => 1, 'price' => $product->price, 'options' => $options));
            }
            $response = [    //truyền kết quả sang ajax
                'state' => 1,
                'msg'   => 'successful!'
            ];
        } else {
            $response = [
                'state' => 0,
                'msg'   => 'fail'
            ];
        }
        return response()->json($response);
    }


    //Xóa sản phẩm khỏi giỏ
    public function getDeleteItem ($id) {
    	Cart::remove($id);
    	return redirect()->route('getCartInfo');
    }


    //Cập nhật số lượng sản phẩm trong giỏ
    public function getUpdateItem (Request $request, $id) {
        $qty       = $request->qty;
        $proId     = $request->proId;
        $rowId     = $request->rowId;
        Cart::update($rowId, $qty);
        $cartItems = Cart::content();
        $total     = Cart::subtotal(0,'','.');
        return view('user.pages.cart_content', compact('cartItems', 'total'))->with(['flash_level' => 'success', 'flash_message' => 'Cập nhật số lượng sản phẩm thành công']);
    }

}
