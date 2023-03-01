<?php

namespace ZEM\Shrinkwrap;

use Illuminate\Support\Collection;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ShrinkwrapServiceProvider extends PackageServiceProvider
{

    public function configurePackage (Package $package): void
    {
        $package->name('shrinkwrap');
    }

    public function boot ()
    {
        Collection::macro('shrink', function () {
            return Facility::shrink($this);
        });
    }
}
