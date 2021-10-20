<?php

namespace Mobiverse\AppsnmobilePayment;

use Illuminate\Support\ServiceProvider;
use Mobiverse\AppsnmobilePayment\Repositories\IMomoTransactionRepository;
use Mobiverse\AppsnmobilePayment\Repositories\MomoTransactionRepository;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Mobiverse\AppsnmobilePayment\Commands\AppsnmobilePaymentCommand;

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
            ->hasConfigFile()
            ->hasMigration('create_momo_transactions_table');

        $this->app->bind(IMomoTransactionRepository::class, MomoTransactionRepository::class);
        $this->app->bind('appsnmobile-payment', AppsnmobilePayment::class);
    }

//    public function register()
//    {
//        if ($this->app->runningInConsole()) {
//
//            $this->publishes([
//                __DIR__.'/../config/appsnmobile-payment.php' => config_path('appsnmobile-payment.php'),
//            ], 'appsnmobile-payment-config');
//
//            if (! class_exists('CreateMomoTransactionsTable')) {
//                $this->publishes([
//                    __DIR__ . '/../database/migrations/create_momo_transactions_table.php.stub' =>
//                        database_path('migrations/' . date('Y_m_d_His', time()) . '_create_momo_transactions_table.php'),
//
//                ], 'migrations');
//            }
//        }
//    }
//
//    public function boot()
//    {
//        //
//    }
}
