<?php

namespace Mobiverse\AppsnmobilePayment;

use Mobiverse\AppsnmobilePayment\Repositories\IMomoTransactionRepository;
use Mobiverse\AppsnmobilePayment\Repositories\MomoTransactionRepository;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AppsnmobilePaymentServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('appsnmobile-payment')
            ->hasConfigFile('appsnmobile-payment')
            ->hasMigration('create_momo_transactions_table');

        $this->app->bind(IMomoTransactionRepository::class, MomoTransactionRepository::class);
        $this->app->bind(IAppsnmobilePayment::class, AppsnmobilePayment::class);
    }
}
