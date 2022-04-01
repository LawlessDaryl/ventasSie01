<?php

namespace App\Providers;
use Darryldecode\Cart\Cart;
use Illuminate\Support\ServiceProvider;

class TransferenciaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('transferencias', function($app)
        {
            $storage = $app['session'];
            $events = $app['events'];
            $instanceName = 'cart_3';
            $session_key = '88uuiioo9988896';
            return new Cart(
                $storage,
                $events,
                $instanceName,
                $session_key,
                config('shopping_cart')
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
