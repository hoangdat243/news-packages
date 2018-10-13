<?php

namespace Vinsofts\News;

use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //load migrate
         
        $this->loadMigrationsFrom(__DIR__.'/migrations');
      
        //load controller
        include __DIR__.'/controller/NewsAPIController.php';
        include __DIR__.'/controller/NewsCategoryController.php';
        include __DIR__.'/controller/NewsController.php';
        include __DIR__.'/controller/TagController.php';
        //load model
        include __DIR__.'/model/News.php';
        include __DIR__.'/model/NewsCategory.php';
        include __DIR__.'/model/Tag.php';
        //load vies
        $this->loadViewsFrom(__DIR__.'/view','v');
        //route
        include __DIR__.'/routes.php';  

        //load library
        $this->publishes([
            __DIR__.'/asset/build' => public_path('build'),
            __DIR__.'/asset/ckeditor' => public_path('ckeditor'),
            __DIR__.'/asset/ckfinder' => public_path('ckfinder'),
            __DIR__.'/asset/select2' => public_path('select2'),
            __DIR__.'/asset/vendors' => public_path('vendors'),
             ], 'public-news');
       
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
