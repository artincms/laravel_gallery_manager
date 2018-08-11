<?php

namespace ArtinCMS\LGS;

use Illuminate\Support\ServiceProvider;

class LGSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    public function boot()
    {
    	// the main router
        $this->loadRoutesFrom( __DIR__.'/Routes/backend_lgs_route.php');
        $this->loadRoutesFrom( __DIR__.'/Routes/frontend_lgs_route.php');

	    $this->publishes([
		    __DIR__ . '/Database/Migrations/' => database_path('migrations')
	    ], 'migrations');

        $this->loadViewsFrom(__DIR__ . '/Views', 'laravel_gallery_system');
        // the main migration folder for create sms_ir tables

        // for publish the views into main app
        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/laravel_gallery_system'),
        ]);

	    // for publish the assets files into main app
	    $this->publishes([
		    __DIR__.'/assets' => public_path('vendor/laravel_gallery_system'),
	    ], 'public');

	    // for publish the sms_ir config file to the main app config folder
	    $this->publishes([
		    __DIR__ . '/Config/LGS.php' => config_path('laravel_gallery_system.php'),
	    ]);

	    //publish vue components
        $this->publishes([
            __DIR__ . '/Components' => resource_path('assets/js/components/laravel_gallery_system'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    	// set the main config file
	    $this->mergeConfigFrom(
		    __DIR__ . '/Config/LGS.php', 'laravel_gallery_system'
	    );

		// bind the LCSC Facade
	    $this->app->bind('lGS', function () {
		    return new lGS;
	    });
    }
}
