<?php

namespace palPalani\LaravelBandwidth;

use Illuminate\Support\Facades\Facade;

/**
 * @see \palPalani\LaravelBandwidthApi\LaravelBandwidth
 */
class LaravelBandwidthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-bandwidth-api';
    }
}
