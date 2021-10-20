# This is a Laravel package for the Apps N Mobile payment service

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mobiverse/appsnmobile-payment.svg?style=flat-square)](https://packagist.org/packages/mobiverse/appsnmobile-payment)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mobiverse/appsnmobile-payment/run-tests?label=tests)](https://github.com/mobiverse/appsnmobile-payment/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/mobiverse/appsnmobile-payment/Check%20&%20fix%20styling?label=code%20style)](https://github.com/mobiverse/appsnmobile-payment/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mobiverse/appsnmobile-payment.svg?style=flat-square)](https://packagist.org/packages/mobiverse/appsnmobile-payment)

###Note: This is work in progress.

This package consumes the AppsnMobile payment APIs therefore you would require an account with ApsnMobile to use it.


## Installation

You can install the package via composer:

```bash
composer require mobiverse/appsnmobile-payment
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Mobiverse\AppsnmobilePayment\AppsnmobilePaymentServiceProvider" --tag="appsnmobile-payment-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Mobiverse\AppsnmobilePayment\AppsnmobilePaymentServiceProvider" --tag="appsnmobile-payment-config"
```

This is the contents of the published config file:

```php
return [
    'baseurl' => env('MOMO_BASEURL', ''),
    'callback_url'=>env('MOMO_CALLBACK_URL',''),
    'debit_transaction_prefix'=>env('MOMO_DEBIT_TRANSACTION_PREFIX',''),
    'credit_transaction_prefix'=>env('MOMO_CREDIT_TRANSACTION_PREFIX',''),
    'debit_callback_url'=>env('MOMO_DEBIT_CALLBACK_URL',''),
    'credit_callback_url'=>env('MOMO_CREDIT_CALLBACK_URL',''),
    'auth'=>[
        'basic'=>[
            'user'=>env('MOMO_BASICAUTH_USR',''),
            'pass'=>env('MOMO_BASICAUTH_PWD','')
        ]
    ],
    'purchase'=>[
        'balance'=>[
            'reference'=>env('MOMO_PURCHASE_BALANCE_REFERENCE','')
        ]
    ]
];
```

## Usage

```php
$momo_transaction = [
    'msisdn' => '0244377919',
    'network' => MomoTransaction::VODAFONE,
    'amount' => 0.10,
    'payment_request_id' => 1,
    'transaction_id' => $transaction_id
];

\Mobiverse\AppsnmobilePayment\AppsnmobilePaymentFacade::executeDebitRequest($momo_transaction);
```
In the controller of your callback url add the following action:
```php
public function debitCallback(IMomoPaymentService $momoPaymentService, Request $request){
    $momoPaymentService->processDebitCallback($request->all());
    return response();
}
```

Implement listeners for the **PaymentSucceeded** and **PaymentFailed** events. eg.
```php
PaymentSucceeded::class => [
    SendReceipt::class,
],
PaymentFailed::class => [
    FailedPaymentNotification::class,
]
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [George Hagan](https://github.com/georgekofihagan)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
