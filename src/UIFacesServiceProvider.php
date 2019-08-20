<?php


namespace robertogallea\UIFaces;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Contracts\Container\Container;

class UIFacesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(UIFaces::class, function (Container $app) {
            return new UIFaces(
                $app['config']['ui-faces.api-url'],
                $app['config']['ui-faces.api-key'],
            );
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/ui-faces.php',
            'ui-faces'
        );
    }
}