<?php


Route::group(['prefix' => config('laravel_gallery_system.frontend_lgs_route_prefix'), 'namespace' => 'ArtinCMS\LGS\Controllers', 'middleware' => config('laravel_gallery_system.frontend_lgs_middlewares')], function () {

});