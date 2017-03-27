<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Cviebrock\EloquentSluggable\Services\SlugService;

class SluggableServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/sluggable.php', 'sluggable');
        $this->app->singleton(SluggableObserver::class, function ($app) {
            return new SluggableObserver(new SlugService(), $app['events']);
        });
    }
}
