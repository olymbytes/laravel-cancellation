# Cancel models inside your Laravel app

The `olymbytes/laravel-cancellation` package allows you to easily handle cancellation of your models. It is inspired by the SoftDeletes implementation in Laravel.

All you have to do is add a trait to your cancellable models:

```php
class Order extends Model
{
    use Cancellable;
}
```

Here's a little demo of how you can use it after adding the trait:

```php
$order = Order::find(1);
$order->cancel();
```

You can query cancelled entities:

```php
$orders = Order::onlyCancelled()->get(); // returns all the cancelled orders
```

## Documentation
Until further documentation is provided, please have a look at the tests.

## Installation

You can install the package via composer:

```bash
$ composer require olymbytes/laravel-cancellation
```

The package will automatically register itself.

You can publish the config with:
```bash
$ php artisan vendor:publish --provider="Olymbytes\Cancellation\CancellationServiceProvider" --tag="config"
```

*Note*: If you set the exclude variable to true in your config, your query results will not include cancelled results by default (just like SoftDeletes).


This is the contents of the published config file:
```php
return [
    /**
     * Exclude the cancellations from the model's queries.
     * Will apply to all, find, etc.
     */
    'exclude' => false,
];
```

## Testing
```bash
$ composer test
```

## Security

If you discover any security issues, please email mpj@foreno.dk instead of using the issue tracker.

## Credits

- [Morten Poul Jensen](https://github.com/Pauly-)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
