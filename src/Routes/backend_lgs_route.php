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

    //------------------------------------route for order -----------------------------------------------------------------------
    Route::post('saveOrderGalleryForm', ['as' => 'LGS.saveOrderGalleryForm', 'uses' => 'GalleryController@saveOrderGalleryForm']);
    Route::post('saveOrderGalleryItemForm', ['as' => 'LGS.saveOrderGalleryItemForm', 'uses' => 'GalleryController@saveOrderGalleryItemForm']);

    //------------------------------------auto complete -----------------------------------------------------------------------
    Route::post('autoCompleteGalleryParrent', ['as' => 'LGS.autoCompleteGalleryParrent', 'uses' => 'GalleryController@autoCompleteGalleryParrent']);

    //--------------------------------------Slider Manager Route ------------------------------------------------//
    Route::group(['prefix' => 'Slider'], function () {
        Route::get('/', ['as' => 'LGS.Slider', 'uses' => 'SliderController@index']);
        Route::post('getSlider', ['as' => 'LGS.Slider.getSlider', 'uses' => 'SliderController@getSlider']);
        Route::post('createSlider', ['as' => 'LGS.Slider.createSlider', 'uses' => 'SliderController@createSlider']);
        Route::post('setStatusSlider', ['as' => 'LGS.Slider.setStatusSlider', 'uses' => 'SliderController@setStatusSlider']);
        Route::post('trashSlider', ['as' => 'LGS.Slider.trashSlider', 'uses' => 'SliderController@trashSlider']);
        Route::post('getAdvanceStyleOptoins', ['as' => 'LGS.Slider.getAdvanceStyleOptoins', 'uses' => 'SliderController@getAdvanceStyleOptoins']);
        Route::post('getEditSliderForm', ['as' => 'LGS.Slider.getEditSliderForm', 'uses' => 'SliderController@getEditSliderForm']);
        Route::post('editSlider', ['as' => 'LGS.Slider.editSlider', 'uses' => 'SliderController@editSlider']);

        //---------------------------------------------slider items ---------------------------------------------------------------------------
        Route::post('getSliderItem', ['as' => 'LGS.Slider.getSliderItem', 'uses' => 'SliderController@getSliderItem']);
        Route::post('getAddSliderItem', ['as' => 'LGS.Slider.getAddSliderItem', 'uses' => 'SliderController@getAddSliderItem']);
        Route::post('addSliderItem', ['as' => 'LGS.Slider.addSliderItem', 'uses' => 'SliderController@createSliderItem']);
        Route::post('getViewGalleryItem', ['as' => 'LGS.Slider.getViewGalleryItem', 'uses' => 'SliderController@getViewGalleryItem']);
        Route::post('setSliderItemStatus', ['as' => 'LGS.Slider.setSliderItemStatus', 'uses' => 'SliderController@setSliderItemStatus']);

        //-------------------------------------------autoComplete----------------------------------------------------------------------------------
        Route::post('autoCompleteGalleryParrent', ['as' => 'LGS.Slider.autoCompleteGallery', 'uses' => 'SliderController@autoCompleteGallery']);
    });

    //------------------------------------------portfolio---------------------------------------------------------//
    Route::group(['prefix' => 'Portfolio'], function () {
        Route::get('/', ['as' => 'LGS.Portfolio', 'uses' => 'PortfolioController@index']);
        Route::post('getPortfolio', ['as' => 'LGS.Portfolio.getPortfolio', 'uses' => 'PortfolioController@getPortfolio']);
        Route::post('savePortfolio', ['as' => 'LGS.Portfolio.savePortfolio', 'uses' => 'PortfolioController@savePortfolio']);
        Route::post('getEditPortfolioForm', ['as' => 'LGS.Portfolio.getEditPortfolioForm', 'uses' => 'PortfolioController@getEditPortfolioForm']);
        Route::post('editPortfolio', ['as' => 'LGS.Portfolio.editPortfolio', 'uses' => 'PortfolioController@editPortfolio']);
        Route::post('trashPortfolio', ['as' => 'LGS.Portfolio.trashPortfolio', 'uses' => 'PortfolioController@trashPortfolio']);
        Route::post('setPortfolioStatus', ['as' => 'LGS.Portfolio.setPortfolioStatus', 'uses' => 'PortfolioController@setPortfolioStatus']);
        Route::post('autoCompletePortfolio', ['as' => 'LGS.Portfolio.autoCompletePortfolio', 'uses' => 'PortfolioController@autoCompletePortfolio']);
        Route::post('saveOrderPortfolioForm', ['as' => 'LGS.Portfolio.saveOrderPortfolioForm', 'uses' => 'PortfolioController@saveOrderPortfolioForm']);

    });

});