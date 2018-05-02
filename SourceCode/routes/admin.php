<?php

//Đăng nhập - Đăng xuất cho admin và auth\admin
Route::group(['prefix' => 'member'], function() {
    Route::get('login', ['as' => 'member.getLogin', 'uses' => 'Auth\Admin\AuthAdminController@getLogin']);
    Route::post('login', ['as' => 'member.postLogin', 'uses' => 'Auth\Admin\AuthAdminController@postLogin']);
    Route::get('update', 'Auth\Admin\AuthAdminController@getEdit');
    Route::post('update', 'Auth\Admin\AuthAdminController@postEdit');
    Route::get('logout', ['as'=>'member.getLogout','uses'=>'Auth\Admin\AuthAdminController@getLogout']);
});


//--------------------------------------------------------------------------------------------------------------

//ADMIN

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    //Trang chủ
    Route::get('home', ['as' => 'admin.home', 'uses' => 'Admin\HomeController@index']);


    //--------------------------------------------------------------------------------------------------

    //Quản lý tài khoản admin
    Route::get('info', ['as' => 'admin.getProfile', 'uses' => 'Auth\Admin\AuthAdminController@getProfile']);

    Route::get('edit-info', ['as' => 'admin.getEditInfo', 'uses' => 'Auth\Admin\AuthAdminController@getEditInfo']);
    Route::post('edit-info', ['as' => 'admin.postEditInfo', 'uses' => 'Auth\Admin\AuthAdminController@postEditInfo']);

    Route::get('password', ['as' => 'admin.getPassword', 'uses' => 'Auth\Admin\AuthAdminController@getPassword'] );
    Route::post('update-password', ['as' => 'admin.updatePassword', 'uses' => 'Auth\Admin\AuthAdminController@updatePassword']);


    //--------------------------------------------------------------------------------------------------

    //QL thể loại sản phẩm
    Route::group(['prefix' => 'cate'], function() {
        Route::get('list', ['as' => 'admin.cate.getList', 'uses' => 'Admin\CateController@getList']);

        Route::get('add', ['as' => 'admin.cate.getAdd', 'uses' => 'Admin\CateController@getAdd']);
        Route::post('add', ['as' => 'admin.cate.postAdd', 'uses' => 'Admin\CateController@postAdd']);

        //khi di chuột vào edit hay delete thì để ý ở góc dưới bên trái màn hình có hiển thị url: ...edit?12 (12 là id của sản phẩm) nên cần có thêm tham số truyền vào phía sau trong route
        Route::get('edit/{id}', ['as' => 'admin.cate.getEdit', 'uses' => 'Admin\CateController@getEdit']);
        Route::post('edit', ['as' => 'admin.cate.postEdit', 'uses' => 'Admin\CateController@postEdit']);
        Route::get('delete/{id}', ['as' => 'admin.cate.getDelete', 'uses' => 'Admin\CateController@getDelete']);
        Route::post('delete', ['as' => 'admin.cate.postDelete', 'uses' => 'Admin\CateController@postDelete']);
    });


    //QL bộ môn sản phẩm
    Route::group(['prefix' => 'sport'], function() {
        Route::get('list', ['as' => 'admin.sport.getList', 'uses' => 'Admin\SportController@getList']);

        Route::get('add', ['as' => 'admin.sport.getAdd', 'uses' => 'Admin\SportController@getAdd']);
        Route::post('add', ['as' => 'admin.sport.postAdd', 'uses' => 'Admin\SportController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.sport.getEdit', 'uses' => 'Admin\SportController@getEdit']);
        Route::post('edit', ['as' => 'admin.sport.postEdit', 'uses' => 'Admin\SportController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.sport.getDelete', 'uses' => 'Admin\SportController@getDelete']);
        Route::post('delete', ['as' => 'admin.sport.postDelete', 'uses' => 'Admin\SportController@postDelete']);
    });


    //QL thương hiệu sản phẩm
    Route::group(['prefix' => 'brand'], function() {
        Route::get('list', ['as' => 'admin.brand.getList', 'uses' => 'Admin\BrandController@getList']);

        Route::get('add', ['as' => 'admin.brand.getAdd', 'uses' => 'Admin\BrandController@getAdd']);
        Route::post('add', ['as' => 'admin.brand.postAdd', 'uses' => 'Admin\BrandController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.brand.getEdit', 'uses' => 'Admin\BrandController@getEdit']);
        Route::post('edit', ['as' => 'admin.brand.postEdit', 'uses' => 'Admin\BrandController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.brand.getDelete', 'uses' => 'Admin\BrandController@getDelete']);
        Route::post('delete', ['as' => 'admin.brand.postDelete', 'uses' => 'Admin\BrandController@postDelete']);
    });


    //QL sản phẩm
    Route::group(['prefix' => 'product'], function() {
        Route::get('list', ['as' => 'admin.product.getList', 'uses' => 'Admin\ProductController@getList']);

        Route::get('add', ['as' => 'admin.product.getAdd', 'uses' => 'Admin\ProductController@getAdd']);
        Route::post('add', ['as' => 'admin.product.postAdd', 'uses' => 'Admin\ProductController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.product.getEdit', 'uses' => 'Admin\ProductController@getEdit']);
        Route::post('edit', ['as' => 'admin.product.postEdit', 'uses' => 'Admin\ProductController@postEdit']);

        //xóa 1 sản phẩm bình thường
        Route::get('delete/{id}', ['as' => 'admin.product.getDelete', 'uses' => 'Admin\ProductController@getDelete']);

        //xóa sản phẩm theo checkbox
        Route::post('delete', ['as' => 'admin.product.postDelete', 'uses' => 'Admin\ProductController@postDelete']);

        //xóa hình ảnh chi tiết trong edit product
        Route::get('delimg/{id}', ['as' => 'admin.product.getDelImg', 'uses' => 'Admin\DeleteImageProController@getDelImg']);

        //tìm kiếm
        Route::get('search', ['as' => 'admin.product.getSearchProduct', 'uses' => 'Admin\SearchController@getSearchProduct']);

        //giảm giá
        Route::get('sale', ['as' => 'addSale', 'uses' => 'Admin\ProductController@addSale']);
    });


    //QL thuộc tính sản phẩm
    Route::group(['prefix' => 'property'], function() {
        Route::get('list', ['as' => 'admin.property.getList', 'uses' => 'Admin\PropertyController@getList']);

        Route::get('add', ['as' => 'admin.property.getAdd', 'uses' => 'Admin\PropertyController@getAdd']);
        Route::post('add', ['as' => 'admin.property.postAdd', 'uses' => 'Admin\PropertyController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.property.getEdit', 'uses' => 'Admin\PropertyController@getEdit']);
        Route::post('edit', ['as' => 'admin.property.postEdit', 'uses' => 'Admin\PropertyController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.property.getDelete', 'uses' => 'Admin\PropertyController@getDelete']);
        Route::post('delete', ['as' => 'admin.property.postDelete', 'uses' => 'Admin\PropertyController@postDelete']);

        //Lấy size theo thể loại sản phẩm
        Route::get('getSizeByCateId', ['as' => 'admin.property.getSizeByCateId', 'uses' => 'Admin\PropertyController@getSizeByCateId']);
        Route::get('getSizeByProIdExist', ['as' => 'admin.property.getSizeByProIdExist', 'uses' => 'Admin\PropertyController@getSizeByProIdExist']);

        //tìm kiếm
        Route::get('search/property', ['as' => 'admin.property.getSearchProperty', 'uses' => 'Admin\SearchController@getSearchProperty']);
    });


    //Quản lý size
    Route::group(['prefix' => 'size'], function() {
        Route::get('list', ['as' => 'admin.size.getList', 'uses' => 'Admin\SizeController@getList']);

        Route::get('add', ['as' => 'admin.size.getAdd', 'uses' => 'Admin\SizeController@getAdd']);
        Route::post('add', ['as' => 'admin.size.postAdd', 'uses' => 'Admin\SizeController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.size.getEdit', 'uses' => 'Admin\SizeController@getEdit']);
        Route::post('edit', ['as' => 'admin.size.postEdit', 'uses' => 'Admin\SizeController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.size.getDelete', 'uses' => 'Admin\SizeController@getDelete']);
        Route::post('delete', ['as' => 'admin.size.postDelete', 'uses' => 'Admin\SizeController@postDelete']);
    });


    //Quản lý nhà cung cấp
    Route::group(['prefix' => 'supplier'], function() {
        Route::get('list', ['as' => 'admin.supplier.getList', 'uses' => 'Admin\SupplierController@getList']);

        Route::get('add', ['as' => 'admin.supplier.getAdd', 'uses' => 'Admin\SupplierController@getAdd']);
        Route::post('add', ['as' => 'admin.supplier.postAdd', 'uses' => 'Admin\SupplierController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.supplier.getEdit', 'uses' => 'Admin\SupplierController@getEdit']);
        Route::post('edit', ['as' => 'admin.supplier.postEdit', 'uses' => 'Admin\SupplierController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.supplier.getDelete', 'uses' => 'Admin\SupplierController@getDelete']);
        Route::post('delete', ['as' => 'admin.supplier.postDelete', 'uses' => 'Admin\SupplierController@postDelete']);
    });


    //--------------------------------------------------------------------------------------------------

    //Quản lý loại tin
    Route::group(['prefix' => 'newscate'], function() {
        Route::get('list', ['as' => 'admin.newscate.getList', 'uses' => 'Admin\NewsCateController@getList']);

        Route::get('add', ['as' => 'admin.newscate.getAdd', 'uses' => 'Admin\NewsCateController@getAdd']);
        Route::post('add', ['as' => 'admin.newscate.postAdd', 'uses' => 'Admin\NewsCateController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.newscate.getEdit', 'uses' => 'Admin\NewsCateController@getEdit']);
        Route::post('edit', ['as' => 'admin.newscate.postEdit', 'uses' => 'Admin\NewsCateController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.newscate.getDelete', 'uses' => 'Admin\NewsCateController@getDelete']);
        Route::post('delete', ['as' => 'admin.newscate.postDelete', 'uses' => 'Admin\NewsCateController@postDelete']);
    });


    //Quản lý tin tức
    Route::group(['prefix' => 'news'], function() {
        Route::get('list', ['as' => 'admin.news.getList', 'uses' => 'Admin\NewsController@getList']);

        Route::get('add', ['as' => 'admin.news.getAdd', 'uses' => 'Admin\NewsController@getAdd']);
        Route::post('add', ['as' => 'admin.news.postAdd', 'uses' => 'Admin\NewsController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.news.getEdit', 'uses' => 'Admin\NewsController@getEdit']);
        Route::post('edit', ['as' => 'admin.news.postEdit', 'uses' => 'Admin\NewsController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.news.getDelete', 'uses' => 'Admin\NewsController@getDelete']);
        Route::post('delete', ['as' => 'admin.news.postDelete', 'uses' => 'Admin\NewsController@postDelete']);
    });

    //--------------------------------------------------------------------------------------------------

    //Quản lý loại video
    Route::group(['prefix' => 'videocate'], function() {
        Route::get('list', ['as' => 'admin.videocate.getList', 'uses' => 'Admin\VideoCateController@getList']);

        Route::get('add', ['as' => 'admin.videocate.getAdd', 'uses' => 'Admin\VideoCateController@getAdd']);
        Route::post('add', ['as' => 'admin.videocate.postAdd', 'uses' => 'Admin\VideoCateController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.videocate.getEdit', 'uses' => 'Admin\VideoCateController@getEdit']);
        Route::post('edit', ['as' => 'admin.videocate.postEdit', 'uses' => 'Admin\VideoCateController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.videocate.getDelete', 'uses' => 'Admin\VideoCateController@getDelete']);
        Route::post('delete', ['as' => 'admin.videocate.postDelete', 'uses' => 'Admin\VideoCateController@postDelete']);
    });


    //Quản lý video
    Route::group(['prefix' => 'video'], function() {
        Route::get('list', ['as' => 'admin.video.getList', 'uses' => 'Admin\VideoController@getList']);

        Route::get('add', ['as' => 'admin.video.getAdd', 'uses' => 'Admin\VideoController@getAdd']);
        Route::post('add', ['as' => 'admin.video.postAdd', 'uses' => 'Admin\VideoController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.video.getEdit', 'uses' => 'Admin\VideoController@getEdit']);
        Route::post('edit', ['as' => 'admin.video.postEdit', 'uses' => 'Admin\VideoController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.video.getDelete', 'uses' => 'Admin\VideoController@getDelete']);
        Route::post('delete', ['as' => 'admin.video.postDelete', 'uses' => 'Admin\VideoController@postDelete']);
    });

    //--------------------------------------------------------------------------------------------------

    //Quản lý banner lớn
    Route::group(['prefix' => 'largebanner'], function() {
        Route::get('list', ['as' => 'admin.largebanner.getList', 'uses' => 'Admin\LargeBannerController@getList']);

        Route::get('add', ['as' => 'admin.largebanner.getAdd', 'uses' => 'Admin\LargeBannerController@getAdd']);
        Route::post('add', ['as' => 'admin.largebanner.postAdd', 'uses' => 'Admin\LargeBannerController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.largebanner.getEdit', 'uses' => 'Admin\LargeBannerController@getEdit']);
        Route::post('edit', ['as' => 'admin.largebanner.postEdit', 'uses' => 'Admin\LargeBannerController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.largebanner.getDelete', 'uses' => 'Admin\LargeBannerController@getDelete']);
        Route::post('delete', ['as' => 'admin.largebanner.postDelete', 'uses' => 'Admin\LargeBannerController@postDelete']);
    });


    //Quản lý banner nhỏ
    Route::group(['prefix' => 'smallbanner'], function() {
        Route::get('list', ['as' => 'admin.smallbanner.getList', 'uses' => 'Admin\SmallBannerController@getList']);

        Route::get('add', ['as' => 'admin.smallbanner.getAdd', 'uses' => 'Admin\SmallBannerController@getAdd']);
        Route::post('add', ['as' => 'admin.smallbanner.postAdd', 'uses' => 'Admin\SmallBannerController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.smallbanner.getEdit', 'uses' => 'Admin\SmallBannerController@getEdit']);
        Route::post('edit', ['as' => 'admin.smallbanner.postEdit', 'uses' => 'Admin\SmallBannerController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.smallbanner.getDelete', 'uses' => 'Admin\SmallBannerController@getDelete']);
        Route::post('delete', ['as' => 'admin.smallbanner.postDelete', 'uses' => 'Admin\SmallBannerController@postDelete']);
    });


    //--------------------------------------------------------------------------------------------------

    //Quản lý nhân viên
    Route::group(['prefix' => 'member'], function() {
        Route::get('list', ['as' => 'admin.member.getList', 'uses' => 'Admin\MemberController@getList']);

        Route::get('add', ['as' => 'admin.member.getAdd', 'uses' => 'Admin\MemberController@getAdd']);
        Route::post('add', ['as' => 'admin.member.postAdd', 'uses' => 'Admin\MemberController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.member.getEdit', 'uses' => 'Admin\MemberController@getEdit']);
        Route::post('edit', ['as' => 'admin.member.postEdit', 'uses' => 'Admin\MemberController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.member.getDelete', 'uses' => 'Admin\MemberController@getDelete']);
        // Route::post('delete', ['as' => 'admin.member.postDelete', 'uses' => 'Admin\MemberController@postDelete']);
    });


    //--------------------------------------------------------------------------------------------------

    //Quản lý thành viên
    Route::group(['prefix' => 'user'], function() {
        Route::get('list', ['as' =>'admin.user.getList','uses' => 'Admin\UserController@getList']);

        Route::get('add', ['as' => 'admin.user.getAdd', 'uses' => 'Admin\UserController@getAdd']);
        Route::post('add', ['as' => 'admin.user.postAdd', 'uses' => 'Admin\UserController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.user.getEdit', 'uses' => 'Admin\UserController@getEdit']);
        Route::post('edit', ['as' => 'admin.user.postEdit', 'uses' => 'Admin\UserController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.user.getDelete', 'uses' => 'Admin\UserController@getDelete']);
    });



    //--------------------------------------------------------------------------------------------------

    //Quản lý khách hàng
    Route::group(['prefix' => 'customer'], function() {
        Route::get('list', ['as' =>'admin.customer.getList','uses' => 'Admin\CustomerController@getList']);

        Route::get('add', ['as' => 'admin.customer.getAdd', 'uses' => 'Admin\CustomerController@getAdd']);
        Route::post('add', ['as' => 'admin.customer.postAdd', 'uses' => 'Admin\CustomerController@postAdd']);
        //Lấy thông tin theo user_id
        Route::get('getInfoByUserId', ['as' => 'admin.customer.getInfoByUserId', 'uses' => 'Admin\CustomerController@getInfoByUserId']);

        Route::get('edit/{id}', ['as' => 'admin.customer.getEdit', 'uses' => 'Admin\CustomerController@getEdit']);
        Route::post('edit', ['as' => 'admin.customer.postEdit', 'uses' => 'Admin\CustomerController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.customer.getDelete', 'uses' => 'Admin\CustomerController@getDelete']);
    });


    //--------------------------------------------------------------------------------------------------

    //Quản lý đơn hàng
    Route::group(['prefix'=>'order'], function(){
        Route::get('list', ['as'  => 'admin.order.getList', 'uses'=> 'Admin\OrderController@getList']);
        Route::get('add', ['as' => 'admin.order.getAdd' , 'uses'=> 'Admin\OrderController@getAdd']);
        Route::post('add', ['as' => 'admin.order.postAdd', 'uses' => 'Admin\OrderController@postAdd']);

        Route::get('edit/{id}', ['as' => 'admin.order.getEdit', 'uses' => 'Admin\OrderController@getEdit']);
        Route::post('edit', ['as' => 'admin.order.postEdit', 'uses' => 'Admin\OrderController@postEdit']);

        Route::get('delete/{id}', ['as' => 'admin.order.getDelete', 'uses' => 'Admin\OrderController@getDelete']);
        Route::post('delete', ['as' => 'admin.order.postDelete', 'uses' => 'Admin\OrderController@postDelete']);

        Route::get('detail/{id}', ['as' => 'admin.order.getDetail', 'uses' => 'Admin\OrderController@getDetail']);
    });

    //Lấy số lượng lớn nhất của sản phẩm
    Route::get('max-qty', ['as' => 'getMaxQty','uses' => 'Admin\PropertyController@getMaxQty']);


    //--------------------------------------------------------------------------------------------------

    //Phân công giao hàng
    Route::group(['prefix'=>'shipping'], function(){
        Route::get('list',['as'=>'admin.shipping.getList','uses'=>'Admin\ShippingController@getList']);

        Route::get('assign',['as'=>'admin.shipping.getAssign','uses'=>'Admin\ShippingController@getAssign']);
        Route::post('assign',['as'=>'admin.shipping.postAssign','uses'=>'Admin\ShippingController@postAssign']);

        Route::get('update/{id}',['as'=>'admin.shipping.getUpdate','uses'=>'Admin\ShippingController@getUpdate']);
        Route::post('update',['as'=>'admin.shipping.postUpdate','uses'=>'Admin\ShippingController@postUpdate']);

        Route::post('delete',['as'=>'admin.shipping.postDelete','uses'=>'Admin\ShippingController@postDelete']);
    });


    //--------------------------------------------------------------------------------------------------

    //Thống kê bán hàng
    Route::group(['prefix'=>'statistic'], function(){
        Route::get('time-statistic',['as'=>'admin.statistic.getTimeStatistic','uses'=>'Admin\StatisticController@getTimeStatistic']);

        Route::get('result',['as'=>'admin.statistic.getResult','uses'=>'Admin\StatisticController@getResult']);

        Route::get('filter',['as'=>'admin.statistic.getFilter','uses'=>'Admin\StatisticController@getFilter']);
    });
});


//--------------------------------------------------------------------------------------------------------------