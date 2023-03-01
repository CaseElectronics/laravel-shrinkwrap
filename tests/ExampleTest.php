<?php

/** @noinspection PhpIllegalPsrClassPathInspection */

use Illuminate\Contracts\Support\Arrayable;
use ZEM\Shrinkwrap\Addressable;
use ZEM\Shrinkwrap\Facility;

abstract class FakeModel implements Arrayable
{

    public function toArray ()
    {
        return ['fake_model_field' => 1];
    }

    public function getKey ()
    {
        return 1;
    }

    public function getAppends ()
    {
        return [];
    }

    public function getHidden ()
    {
        return [];
    }

    public function getArrayableRelations ()
    {
        return [];
    }
}

class AddressableModel extends FakeModel
{
    use Addressable;
}

it('records the addressable instance such that it occurs only once in the serialized array', function () {

    $instance = new AddressableModel();

    $shrunk = Facility::shrink(collect([
        'item1' => $instance,
        'item2' => $instance,
    ]));

    // The `$shrunk` array, when json serialized, should only contain one occurrence of the string "fake_model_field"
    expect(
        substr_count(json_encode($shrunk), 'fake_model_field'),
    )->toBe(1);

    $unshrunk = Facility::unshrink($shrunk);

    expect($unshrunk['item1']['fake_model_field'])->toBe(1);
    expect($unshrunk['item2']['fake_model_field'])->toBe(1);
});

it('restores the addressable instances when unserializing', function () {

    $instance = new AddressableModel();

    $unshrunk = Facility::unshrink(Facility::shrink(collect([
        'item1' => $instance,
        'item2' => $instance,
    ])));

    expect($unshrunk['item1']['fake_model_field'])->toBe(1);
    expect($unshrunk['item2']['fake_model_field'])->toBe(1);
});
