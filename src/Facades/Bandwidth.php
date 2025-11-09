<?php

declare(strict_types=1);

namespace palPalani\Bandwidth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \palPalani\Bandwidth\Bandwidth
 */
class Bandwidth extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bandwidth';
    }
}
