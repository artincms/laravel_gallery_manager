<?php
Route::group(['prefix' => config('laravel_gallery_system.backend_lgs_route_prefix'), 'namespace' => 'ArtinCMS\LGS\Controllers', 'middleware' => config('laravel_gallery_system.backend_lgs_middlewares')], function () {
    Route::get('/', ['as' => 'LGS.Gallery', 'uses' => 'GalleryController@index']);
    Route::post('getGallery', ['as' => 'LGS.getGallery', 'uses' => 'GalleryController@getGallery']);
    Route::post('saveGallery', ['as' => 'LGS.saveGallery', 'uses' => 'GalleryController@saveGallery']);
    Route::post('getEditGalleryForm', ['as' => 'LGS.getEditGalleryForm', 'uses' => 'GalleryController@getEditGalleryForm']);
    Route::post('editGallery', ['as' => 'LGS.editGallery', 'uses' => 'GalleryController@editGallery']);
    Route::post('trashGallery', ['as' => 'LGS.trashGallery', 'uses' => 'GalleryController@trashGallery']);
    Route::post('setGalleryStatus', ['as' => 'LGS.setGalleryStatus', 'uses' => 'GalleryController@setGalleryStatus']);
    Route::post('getGalleryItem', ['as' => 'LGS.getGalleryItem', 'uses' => 'GalleryController@getGalleryItem']);
});