<?php
Route::group(['prefix' => config('laravel_gallery_system.backend_lgs_route_prefix'), 'namespace' => 'ArtinCMS\LGS\Controllers', 'middleware' => config('laravel_gallery_system.backend_lgs_middlewares')], function () {
    Route::get('/', ['as' => 'LGS.Gallery', 'uses' => 'GalleryController@index']);
    Route::post('getGallery', ['as' => 'LGS.getGallery', 'uses' => 'GalleryController@getGallery']);
});