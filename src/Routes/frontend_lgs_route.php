<?php


Route::group(['prefix' => config('laravel_gallery_system.frontend_lgs_route_prefix'), 'namespace' => 'ArtinCMS\LGS\Controllers', 'middleware' => config('laravel_gallery_system.frontend_lgs_middlewares')], function () {
    //gallery routes
    Route::post('getGalleryItemFront', ['as' => 'LGS.getGalleryItemFront', 'uses' => 'GalleryController@getGalleryItemFront']);


    //fronted routes
    Route::group(['prefix' => 'Slider'], function () {
        Route::post('getSliderItemFront', ['as' => 'LGS.Slider.getSliderItemFront', 'uses' => 'SliderController@getSliderItemFront']);
    });

});