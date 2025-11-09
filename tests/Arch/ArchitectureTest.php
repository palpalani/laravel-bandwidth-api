<?php

arch('it does not use debugging functions')
    ->expect(['dd', 'dump', 'ray', 'var_dump', 'print_r'])
    ->not->toBeUsed();

arch('it uses strict types')
    ->expect('palPalani\Bandwidth')
    ->toUseStrictTypes();

arch('classes are final or abstract')
    ->expect('palPalani\Bandwidth')
    ->classes()
    ->not->toBeFinal(); // Laravel packages typically don't use final

arch('does not use globals')
    ->expect('palPalani\Bandwidth')
    ->not->toUse('global');

arch('ensures facades extend base facade')
    ->expect('palPalani\Bandwidth\Facades\Bandwidth')
    ->toExtend('Illuminate\Support\Facades\Facade');

arch('ensures service provider extends package service provider')
    ->expect('palPalani\Bandwidth\BandwidthServiceProvider')
    ->toExtend('Spatie\LaravelPackageTools\PackageServiceProvider');
