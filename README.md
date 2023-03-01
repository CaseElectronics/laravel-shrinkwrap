# Laravel-shrinkwrap

Creates 'deflated' serialised arrays by using a dictionary of models that may be referenced more than once

## Installation

You can install the package via composer:

```bash
composer require zem/laravel-shrinkwrap
```

Laravel 5.5+ will automatically register the service provider(s).

## Usage

Add the `\ZEM\Shrinkwrap\Addressable` trait to models you would like to have
"deduplicated" in the serialisation process.

```php
\ZEM\Shrinkwrap\Facility::shrink(collect([
    'item1' => $myModel,
    'item2' => $myModel,
]));

// Or using the built-in macro:

collect([
    'item1' => $myModel,
    'item2' => $myModel,
])->shrink();
```

If you have instances of addressable models at "deep" paths within your data,
make sure each iterable item is a `collection` all the way down to the model
as `toArray` will be called on each item.

## Testing

```bash
composer test
```
