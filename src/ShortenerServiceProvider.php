<?php
declare(strict_types = 1);

namespace MuhamedDidovic\Shortener;

use MuhamedDidovic\Shortener\Link;
use MuhamedDidovic\Shortener\Observers\LinkObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

class ShortenerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Link::observe(LinkObserver::class);

        $source = realpath($raw = __DIR__ . '/../config/shortener.php') ?: $raw;
        //        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {

        $this->loadViewsFrom(__DIR__ . '/views', 'shortener');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        $this->publishes([
            $source                         => config_path('shortener.php'),
            __DIR__ . '/../database/migrations'         => database_path('migrations'),
            __DIR__ . '/../resources/views' => resource_path('views/vendor/shortener'),
            __DIR__ . '/../public/css'      => public_path('css/'),
            __DIR__ . '/../public/js'       => public_path('js/'),
        ], 'shortener');

        //        $this->publishes([
        //            __DIR__ . '/views' => resource_path('views/vendor/shortener'),
        //        ], 'shortener::view');
        //            $this->publishes([
        //                __DIR__.'/path/to/config/courier.php' => config_path('courier.php'),
        //            ]);
        //        }
        //        elseif ($this->app instanceof LumenApplication) {
        //            $this->app->configure('shortener');
        //        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $source = realpath($raw = __DIR__ . '/../config/shortener.php') ?: $raw;
        $this->mergeConfigFrom($source, 'shortener');
    }
}
