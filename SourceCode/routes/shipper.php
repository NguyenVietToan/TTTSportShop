<?php

//SHIPPER
Route::group(['prefix' => 'shipper','middleware' => 'shipper'], function() {
    // Trang chủ shipper
    Route::get('/home', ['as' => 'shipper.index', 'uses' => 'Shipper\ShipperController@index']);

    //Danh sách các đơn hàng cần chuyển
    Route::get('/processing', ['as' => 'shipper.getProcessing', 'uses' => 'Shipper\ShipperController@getProcessing']);

    //Danh sách các đơn hàng cần xác nhận từ admin
    Route::get('/waiting-accepted', ['as' => 'shipper.getWaitingAccepted', 'uses' => 'Shipper\ShipperController@getWaitingAccepted']);

    //Danh sách lịch sử đơn hàng đã chuyển
    Route::get('/history', ['as' => 'shipper.getHistory', 'uses' => 'Shipper\ShipperController@getHistory']);

    //Chi tiết từng mặt hàng trong đơn hàng
    Route::get('detail/{id}', ['as' => 'shipper.getDetail', 'uses'=> 'Shipper\ShipperController@getDetail']);

    //Cập nhật trạng thái chuyển hàng của từng mặt hàng trong đơn hàng
    Route::get('update/{id}',['as' => 'shipper.getEdit', 'uses' => 'Shipper\ShipperController@getEdit']);
    Route::post('update', ['as' => 'shipper.postEdit', 'uses' => 'Shipper\ShipperController@postEdit']);

    //Xác nhận các đơn hàng đã hoàn thành và gửi tới admin chờ xác nhận
    Route::post('accept', ['as' => 'shipper.postAccept','uses' => 'Shipper\ShipperController@postAccept']);

    Route::get('info', ['as' => 'shipper.getProfile', 'uses' => 'Shipper\ShipperController@getProfile']);
    Route::get('edit-info', ['as' => 'shipper.getEditInfo', 'uses' => 'Shipper\ShipperController@getEditInfo']);
    Route::post('edit-info', ['as' => 'shipper.postEditInfo', 'uses' => 'Shipper\ShipperController@postEditInfo']);

    Route::get('password', ['as' => 'shipper.getPassword', 'uses' => 'Shipper\ShipperController@getPassword'] );
    Route::post('update-password', ['as' => 'shipper.updatePassword', 'uses' => 'Shipper\ShipperController@updatePassword']);
});