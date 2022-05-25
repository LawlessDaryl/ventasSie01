<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Darryldecode\Cart\Cart;

class EditarTransferenciaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('editartransferencia', function($app)
        {
            $storage = $app['session'];
            $events = $app['events'];
            $instanceName = 'cart_5';
            $session_key = '88uuiioo99889';
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
