# Laravel Wallet

<a href="https://github.com/siarheipashkevich/laravel-wallet/actions"><img src="https://github.com/siarheipashkevich/laravel-wallet/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/pashkevich/laravel-wallet"><img src="https://img.shields.io/packagist/dt/pashkevich/laravel-wallet" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/pashkevich/laravel-wallet"><img src="https://img.shields.io/packagist/v/pashkevich/laravel-wallet" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/pashkevich/laravel-wallet"><img src="https://img.shields.io/packagist/l/pashkevich/laravel-wallet" alt="License"></a>

> [!WARNING]
> under development

## Installation

You can install the package via composer:

```bash
composer require pashkevich/laravel-wallet
```

### Configuring the package

You can publish the config file with:

```bash
php artisan vendor:publish --tag=laravel-wallet
```

This is the contents of the file that will be published at `config/wallet.php`:

```php
<?php

return [
    'apple' => [
        //
    ],

    'google' => [
        //
    ],
];
```

## Usage

```php
use Pashkevich\Wallet\Facades\Wallet;

$pass = new Pass(...);

Wallet::provider('apple')->createPass($pass);

Wallet::provider('google')->createPass($pass);
```

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email siarheipashkveich@gmail.com instead of using the issue
tracker.

## Credits

- [Sergey Pashkevich](https://github.com/siarheipashkevich)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
