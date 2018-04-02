<?php
include 'admin.php';
include 'shipper.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

//thêm, xóa cột trong bảng, xóa bảng
Route::get('schema/drop-col', function() {
    Schema::disableForeignKeyConstraints('orders');
});

Route::get('schema/add-col', function() {
    Schema::table('users', function($table) {
        $table->string('avatar')->nullable();
    });
});

Route::get('schema/drop-table', function() {
    Schema::dropIfExists('reviews');
});


/* ------------------------------------------------------------------------------- */
// Địa chỉ: type ở đây là province, district hoặc ward và id là các id tương ứng id_province, id_district, id_ward
Route::get('address/{type}/{id}', ['as' => 'getAddress', 'uses' => 'AddressController@getAddress']);


/* ------------------------------------------------------------------------------- */
//USER

//Trang giới thiệu mở đầu
Route::get('/', ['as' => 'getIntroIndex', 'uses' => 'WelcomeController@introIndex']);

//Về trang chủ
Route::get('/trang-chu', ['as' => 'getHome', 'uses' => 'WelcomeController@index']);


//Thay đổi ngôn ngữ
Route::post('lang', 'WelcomeController@setUserLang');


//Đăng nhập
Route::get('dang-nhap', ['as' => 'getLogin', 'uses' => 'AccountController@getLogin']);
Route::post('dang-nhap', ['as' => 'postLogin', 'uses' => 'AccountController@postLogin']);


//Đăng nhập bằng mạng XH
Route::group(['prefix'=>'auth'], function(){
    Route::get('login/facebook', 'SocialController@redirectToProviderFaceBook');
    Route::get('login/facebook/callback', 'SocialController@handleProviderFaceBook');

    Route::get('login/google', 'SocialController@redirectToProviderGoogle');
    Route::get('login/google/callback', 'SocialController@handleProviderGoogle');
});


//Đăng ký thành viên
Route::get('dang-ky', ['as' => 'getRegister', 'uses' => 'AccountController@getRegister']);
Route::post('dang-ky', ['as' => 'postRegister', 'uses' => 'AccountController@postRegister']);


//Xác nhận qua mail để active tài khoản sau khi đăng ký
Route::get('verifyEmailFirst', ['as' => 'verifyEmailFirst', 'uses' => 'AccountController@verifyEmailFirst']);
Route::get('verify/{email}/{verifyToken}', ['as' => 'sendEmailDone', 'uses' => 'AccountController@sendEmailDone']);


//Quên mật khẩu
Route::group(['prefix'=>'user'], function(){
    Route::get('password/reset', ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);

    Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['uses' => 'Auth\ResetPasswordController@reset']);
});

//Đăng xuất
Route::get('dang-xuat', ['as' => 'Logout', 'uses' => 'AccountController@postLogout']);


// ---------------------------------------------------------------------------
//SẢN PHẨM

//Lấy toàn bộ sản phẩm
Route::get('san-pham', ['as' => 'getProduct', 'uses' => 'WelcomeController@product']);


//Filter sản phẩm
Route::get('san-pham-ajax', ['as' => 'getProductAjax', 'uses' => 'WelcomeController@getProductAjax']);


//Lấy sp theo bộ môn
Route::get('bo-mon/{sport}', ['as' => 'getSport', 'uses' => 'WelcomeController@sport']);


//Lấy sp theo bộ môn và thể loại
Route::get('bo-mon/{sport}/{category}', ['as' => 'getSportCate', 'uses' => 'WelcomeController@sport_category']);


//Lấy sp theo thương hiệu
Route::get('thuong-hieu/{brand}', ['as' => 'getBrand', 'uses' => 'WelcomeController@brand']);


//Lấy sp theo thương hiệu và thể loại
Route::get('thuong-hieu/{brand}/{category}', ['as' => 'getBrandCate', 'uses' => 'WelcomeController@brand_category']);


//Lấy chi tiết sản phẩm
Route::get('chi-tiet-san-pham/{id}', ['as' => 'productDetail', 'uses' => 'WelcomeController@productDetail']);


//Nhận xét sản phẩm
Route::post('review', ['as' => 'addReview', 'uses' => 'WelcomeController@addReview']);


// ---------------------------------------------------------------------------
//TIN TỨC

//Lấy toàn bộ tin tức
Route::get('tin-tuc', ['as' => 'getNews', 'uses' => 'FrontNewsController@news']);


//Filter tin tức
Route::get('tin-tuc-ajax', ['as' => 'getNewsAjax', 'uses' => 'FrontNewsController@getNewsAjax']);


//Lấy chi tiết tin
Route::get('chi-tiet-tin-tuc/{id}', ['as' => 'newsDetails', 'uses' => 'FrontNewsController@newsDetails']);


//Bình luận về tin tức
Route::group(['middleware' => 'user'], function() {
    Route::post('binh-luan/{id}', ['as' => 'postComment', 'uses' => 'FrontNewsController@postComment']);
});

// ---------------------------------------------------------------------------
//VIDEO

//Lấy toàn bộ video
Route::get('video', ['as' => 'getVideo', 'uses' => 'FrontVideoController@video']);


//Filter video
Route::get('video-ajax', ['as' => 'getVideoAjax', 'uses' => 'FrontVideoController@getVideoAjax']);


//Lấy chi tiết video
Route::get('chi-tiet-video/{id}', ['as' => 'videoDetails', 'uses' => 'FrontVideoController@videoDetails']);


// ---------------------------------------------------------------------------
//KHUYẾN MÃI

//Lấy toàn bộ danh sách sản phẩm khuyến mãi
Route::get('khuyen-mai', ['as' => 'getSaleProduct', 'uses' => 'WelcomeController@getSaleProduct']);


// ---------------------------------------------------------------------------
//GIỎ HÀNG

//Thêm sp vào giỏ hàng
Route::post('gio-hang/them', ['as' => 'postAddItem', 'uses' => 'CartController@postAddItem']);


//Lấy thông tin giỏ hàng
Route::get('gio-hang', ['as' => 'getCartInfo', 'uses' => 'CartController@getCartInfo']);


//Xóa sản phẩm khỏi giỏ hàng
Route::get('gio-hang/xoa/{id}', ['as' => 'getDeleteItem', 'uses' => 'CartController@getDeleteItem']);


//Cập nhật số lượng sản phẩm trong giỏ
Route::get('gio-hang/sua/{id}', ['as' => 'getUpdateItem', 'uses' => 'CartController@getUpdateItem']);


// ---------------------------------------------------------------------------
//DANH SÁCH YÊU THÍCH

Route::group(['prefix' => 'yeu-thich', 'middleware' => 'user'], function() {
    //Hiển thị wishlist
    Route::get('/', ['as' => 'getWishList', 'uses' => 'WishListController@getWishList']);

    //Thêm vào wishlist
    Route::post('them', ['as' => 'addToWishList', 'uses' => 'WishListController@addToWishList']);

    //Xóa khỏi wishlist
    Route::post('xoa', ['as' => 'postDeleteWishList', 'uses' => 'WishListController@postDeleteWishList']);
});


// ---------------------------------------------------------------------------
//QUẢN LÝ TÀI KHOẢN CÁ NHÂN

Route::group(['middleware' => 'user'], function() {
    Route::get('tai-khoan', ['as' => 'getAccount', 'uses' => 'ProfileController@getAccount']);

    Route::get('thong-tin', ['as' => 'getProfile', 'uses' => 'ProfileController@getProfile']);
    Route::post('cap-nhat-thong-tin', ['as' => 'updateProfile', 'uses' => 'ProfileController@updateProfile']);

    Route::get('don-hang', ['as' => 'getOrder', 'uses' => 'ProfileController@getOrder']);
    Route::get('chi-tiet-don-hang/{id}', ['as' => 'getOrderDetail', 'uses' => 'ProfileController@getOrderDetail']);

    Route::get('mat-khau', ['as' => 'getPassword', 'uses' => 'ProfileController@getPassword'] );
    Route::post('doi-mat-khau', ['as' => 'updatePassword', 'uses' => 'ProfileController@updatePassword']);
});


// ---------------------------------------------------------------------------
//TÌM KIẾM

Route::get('tim-kiem', ['as' => 'getSearch', 'uses' => 'WelcomeController@getSearch']);


// ---------------------------------------------------------------------------
//THANH TOÁN

Route::get('dia-chi-thanh-toan', ['as' => 'getDeliveryAddress', 'uses' => 'CheckoutController@getDeliveryAddress']);

Route::post('thanh-toan', ['as' => 'checkout', 'uses' => 'CheckoutController@checkout']);


// ---------------------------------------------------------------------------
//LIÊN HỆ

Route::get('lien-he', ['as' => 'getContact', 'uses' => 'ContactController@getContact']);

Route::post('gui-lien-he', ['as' => 'postContact', 'uses' => 'ContactController@postContact']);


// ---------------------------------------------------------------------------
//GIỚI THIỆU

Route::get('gioi-thieu', ['as' => 'getIntroduce', 'uses' => 'WelcomeController@getIntroduce']);

Route::get('reset-time', 'AccountController@resetDate');