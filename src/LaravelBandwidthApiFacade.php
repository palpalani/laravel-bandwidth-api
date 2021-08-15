<?php

namespace palPalani\LaravelBandwidthApi;

use Illuminate\Support\Facades\Facade;

/**
 * @see \palPalani\LaravelBandwidthApi\LaravelBandwidthApi
 */
class LaravelBandwidthApiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-bandwidth-api';
    }
}
