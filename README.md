# Laravel-shrinkwrap

Creates 'deflated' serialised arrays by using a dictionary of models that may be referenced more than once

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-shrinkwrap.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-shrinkwrap)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require zem/laravel-shrinkwrap
```

## Usage

```php
$skeleton = new ZEM\Shrinkwrap();
echo $skeleton->echoPhrase('Hello, ZEM!');
```

## Testing

```bash
composer test
```
