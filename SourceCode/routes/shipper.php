<?php

//SHIPPER
Route::group(['prefix' => 'shipper','middleware' => 'shipper'], function() {
    Route::get('/home', ['as' => 'shipper.index', 'uses' => 'Shipper\ShipperController@index']);

    Route::get('/processing', ['as' => 'shipper.getProcessing', 'uses' => 'Shipper\ShipperController@getProcessing']);

    Route::get('/waiting-accepted', ['as' => 'shipper.getWaitingAccepted', 'uses' => 'Shipper\ShipperController@getWaitingAccepted']);

    Route::get('/history', ['as' => 'shipper.getHistory', 'uses' => 'Shipper\ShipperController@getHistory']);

    Route::get('detail/{id}', ['as' => 'shipper.getDetail', 'uses'=> 'Shipper\ShipperController@getDetail']);

    Route::get('update/{id}',['as' => 'shipper.getEdit', 'uses' => 'Shipper\ShipperController@getEdit']);
    Route::post('update', ['as' => 'shipper.postEdit', 'uses' => 'Shipper\ShipperController@postEdit']);

    Route::post('accept', ['as' => 'shipper.postAccept','uses' => 'Shipper\ShipperController@postAccept']);

    Route::get('info', ['as' => 'shipper.getProfile', 'uses' => 'Shipper\ShipperController@getProfile']);
    Route::get('edit-info', ['as' => 'shipper.getEditInfo', 'uses' => 'Shipper\ShipperController@getEditInfo']);
    Route::post('edit-info', ['as' => 'shipper.postEditInfo', 'uses' => 'Shipper\ShipperController@postEditInfo']);

    Route::get('password', ['as' => 'shipper.getPassword', 'uses' => 'Shipper\ShipperController@getPassword'] );
    Route::post('update-password', ['as' => 'shipper.updatePassword', 'uses' => 'Shipper\ShipperController@updatePassword']);
});