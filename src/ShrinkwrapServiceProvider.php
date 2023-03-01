<?php

namespace ZEM\Shrinkwrap;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ShrinkwrapServiceProvider extends PackageServiceProvider
{
    public function configurePackage (Package $package): void
    {
        $package
            ->name('shrinkwrap')
            ->publishesServiceProvider(ShrinkwrapMacrosProvider::class);
    }
}
