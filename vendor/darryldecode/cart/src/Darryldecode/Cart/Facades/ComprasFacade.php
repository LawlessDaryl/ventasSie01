<?php namespace Darryldecode\Cart\Facades;

use Illuminate\Support\Facades\Facade;

class ComprasFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'compras';
    }
}