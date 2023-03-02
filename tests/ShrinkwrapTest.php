<?php

/** @noinspection PhpIllegalPsrClassPathInspection */

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use ZEM\Shrinkwrap\Addressable;
use ZEM\Shrinkwrap\Facility;

abstract class FakeModel implements Arrayable
{

    protected ?Collection $data = null;

    public function toArray ()
    {
        return $this->data?->toArray() ?? [];
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

class AddressableCompany extends FakeModel
{
    use Addressable;

    public function __construct ()
    {
        $this->data = collect([
            'company_name' => 'Example Inc.',
        ]);
    }
}

class AddressableUser extends FakeModel
{
    use Addressable;

    public function __construct ()
    {
        $this->data = collect([
            'username' => 'user@example.com',
            'company'  => new AddressableCompany(),
        ]);
    }
}

it('records the addressable instance such that it occurs only once in the serialized array', function () {

    $instance = new AddressableUser();

    $shrunk = Facility::shrink(collect([
        'item1' => $instance,
        'item2' => $instance,
    ]));

    // The `$shrunk` array, when json serialized, should only contain one occurrence of the string "username"
    expect(
        substr_count(json_encode($shrunk), 'username'),
    )->toBe(1);
});

it('restores the addressable instances when unserializing', function () {

    $instance = new AddressableUser();

    $payload = Facility::unshrink(Facility::shrink(collect([
        'item1' => $instance,
        'item2' => $instance,
    ])));

    expect($payload['item1']['username'])->toBe('user@example.com');
    expect($payload['item1']['company']['company_name'])->toBe('Example Inc.');
    expect($payload['item2']['username'])->toBe('user@example.com');
    expect($payload['item2']['company']['company_name'])->toBe('Example Inc.');
});
