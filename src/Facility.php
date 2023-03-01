<?php

namespace ZEM\Shrinkwrap;

use Illuminate\Contracts\Support\Arrayable;

/**
 * This class serializes and deserializes arrays including (nested) "addressable" objects,
 * and contains static properties relevant to / used during the serialization process.
 */
class Facility
{

    // TODO create `SerializationContext` with singleton accessor (for now, until we have a better idea)

    public static bool $active = false;

    /**
     * The root object being serialized (we will never treat it as "addressable", as that would
     * not be possible since the root object cannot be replaced by a reference to itself)
     * @var mixed
     */
    public static mixed $root;

    /**
     * "Dictionary" of addressable objects, keyed by their address
     * @var array
     */
    public static array $dict;

    /**
     * Recursively deflate an arrayable object. This simply serializes an array, then checks
     * if any of the values are addressable objects that indexed themselves in the dictionary.
     * If so, the dictionary is returned along with the serialized array, otherwise the
     * serialized array is returned as-is.
     * @param array|Arrayable $arrayable
     * @return array
     */
    public static function shrink (array|Arrayable $arrayable): array
    {
        self::$active = true;
        self::$root   = $arrayable;
        self::$dict   = [];
        $result       = (is_array($arrayable) ? collect($arrayable) : $arrayable)->toArray();
        self::$active = false;
        return count(self::$dict) ? [
            '__dict' => self::$dict,
            '__data' => $result,
        ] : $result;
    }

    /**
     * Recursively inflate a "deflated" array. This "walks over" the array and replaces any
     * string values that start with an asterisk (which indicates an "address" / pointer)
     * with the corresponding value from the dictionary.
     */
    public static function unshrink (mixed $item, ?array $dict = null): array
    {
        if (is_array($item)) {
            if (
                $dict === null &&
                array_key_exists('__dict', $item) &&
                array_key_exists('__data', $item)
            ) {
                return self::unshrink($item['__data'], $item['__dict']);
            } else {
                return array_map(fn($item) => self::unshrink($item, $dict), $item);
            }
        } else if (is_string($item) && str_starts_with($item, '*')) {
            return $dict[$item] ?? $item;
        } else {
            return $item;
        }
    }
}
