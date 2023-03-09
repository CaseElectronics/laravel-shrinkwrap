<?php

namespace ZEM\Shrinkwrap;

use Illuminate\Support\Arr;

class Address
{

    /**
     * Create an address string (pointer) from the given class name, key and hash.
     * The hash can be used to identify the configuration (e.g. hidden, appended
     * fields) of the model.
     */
    public static function create (string $class, int|string $key, string $hash): string
    {
        return '*' . $class
            . ':' . $key
            . '#' . $hash;
    }

    /**
     * Parse an address string (pointer) into its constituent parts,
     * as an associative array with the keys `class`, `key` and `hash`.
     */
    public static function parse (string $address): ?array
    {
        if (
            preg_match('/\*(?<class>.+):(?<key>.+)#(?<hash>.+)/', $address, $matches)
        ) {
            return Arr::only($matches, ['class', 'key', 'hash']);
        }
        return null;
    }
}
