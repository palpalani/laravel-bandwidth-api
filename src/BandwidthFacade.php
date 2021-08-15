<?php

namespace palPalani\Bandwidth;

use Illuminate\Support\Facades\Facade;

/**
 * @see \palPalani\Bandwidth\Bandwidth
 */
class BandwidthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bandwidth';
    }
}
