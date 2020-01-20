<?php

namespace Quyen\Cmspackage;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Quyen\Cmspackage\NewsController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'cmspackage');
        $this->publishes([
            base_path(). 'resources/views/admin/cms/news' => __DIR__.'/views'
        ]);
    }
}
