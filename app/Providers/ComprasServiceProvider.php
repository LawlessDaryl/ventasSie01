<?php

namespace App\Providers;
use Darryldecode\Cart\Cart;
use Illuminate\Support\ServiceProvider;

class ComprasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('compras', function($app)
        {
            $storage = $app['session'];
            $events = $app['events'];
            $instanceName = 'cart_2';
            $session_key = '88uuiioo99888';
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
