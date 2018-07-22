<?php
Route::group(['prefix' => config('laravel_gallery_system.backend_lgs_route_prefix'), 'namespace' => 'ArtinCMS\LGS\Controllers', 'middleware' => config('laravel_gallery_system.backend_lgs_middlewares')], function () {
    Route::get('/', ['as' => 'LGS.Gallery', 'uses' => 'GalleryController@index']);
    Route::post('getGallery', ['as' => 'LGS.getGallery', 'uses' => 'GalleryController@getGallery']);
    Route::post('saveGallery', ['as' => 'LGS.saveGallery', 'uses' => 'GalleryController@saveGallery']);
    Route::post('getEditGalleryForm', ['as' => 'LGS.getEditGalleryForm', 'uses' => 'GalleryController@getEditGalleryForm']);
    Route::post('editGallery', ['as' => 'LGS.editGallery', 'uses' => 'GalleryController@editGallery']);
    Route::post('trashGallery', ['as' => 'LGS.trashGallery', 'uses' => 'GalleryController@trashGallery']);
    Route::post('setGalleryStatus', ['as' => 'LGS.setGalleryStatus', 'uses' => 'GalleryController@setGalleryStatus']);

    //----------------------------------items route------------------------------------------------------
    Route::post('getGalleryItem', ['as' => 'LGS.getGalleryItem', 'uses' => 'GalleryController@getGalleryItem']);
    Route::post('getAddGalleryItemForm', ['as' => 'LGS.getAddGalleryItemForm', 'uses' => 'GalleryController@getAddGalleryItemForm']);
    Route::post('createGalleryItem', ['as' => 'LGS.createGalleryItem', 'uses' => 'GalleryController@createGalleryItem']);
    Route::post('setItemStatus', ['as' => 'LGS.setItemStatus', 'uses' => 'GalleryController@setItemStatus']);
    Route::post('getEditGalleryItemForm', ['as' => 'LGS.getEditGalleryItemForm', 'uses' => 'GalleryController@getEditGalleryItemForm']);
    Route::post('editGalleryItem', ['as' => 'LGS.editGalleryItem', 'uses' => 'GalleryController@editGalleryItem']);
    Route::post('trashGalleryItem', ['as' => 'LGS.trashGalleryItem', 'uses' => 'GalleryController@trashGalleryItem']);
});