<?php

namespace ZEM\Shrinkwrap;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

/**
 * Registers the `shrink` macro on the `Collection` class, allowing us to
 * easily serialize a collection - this is nothing more than syntactic sugar.
 */
class ShrinkwrapMacrosProvider extends ServiceProvider
{

    public function boot ()
    {
        Collection::macro('shrink', function () {
            return Facility::shrink($this);
        });
    }
}
