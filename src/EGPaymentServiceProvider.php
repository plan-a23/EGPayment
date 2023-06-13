<?php

namespace PlanA23\EGPayment;

use Illuminate\Support\ServiceProvider;
use PlanA23\EGPayment\Classes\FawryPayment;
use PlanA23\EGPayment\Classes\HyperPayPayment;
use PlanA23\EGPayment\Classes\KashierPayment;
use PlanA23\EGPayment\Classes\PayPalPayment;
use PlanA23\EGPayment\Classes\PaytabsPayment;
use PlanA23\EGPayment\Classes\ThawaniPayment;
use PlanA23\EGPayment\Classes\TapPayment;
use PlanA23\EGPayment\Classes\OpayPayment;
use PlanA23\EGPayment\Classes\PaymobWalletPayment;
use PlanA23\EGPayment\Classes\PaymobPayment;

class EGPaymentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configure();

        $langPath = 'vendor/payments';
        $langPath = (function_exists('lang_path'))
            ? lang_path($langPath)
            : resource_path('lang/' . $langPath);

        $this->registerPublishing($langPath);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'PlanA23');




        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/PlanA23'),
            __DIR__ . '/../config/config.php' => config_path('PlanA23-payments.php'),
            __DIR__ . '/../resources/lang' => $langPath,
        ], 'PlanA23-payments-all');

        $this->registerTranslations($langPath);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(PaymobPayment::class, function () {
            return new PaymobPayment();
        });
        $this->app->bind(FawryPayment::class, function () {
            return new FawryPayment();
        });
        $this->app->bind(ThawaniPayment::class, function () {
            return new ThawaniPayment();
        });
        $this->app->bind(PaypalPayment::class, function () {
            return new PaypalPayment();
        });
        $this->app->bind(HyperPayPayment::class, function () {
            return new HyperPayPayment();
        });
        $this->app->bind(KashierPayment::class, function () {
            return new KashierPayment();
        });
        $this->app->bind(TapPayment::class, function () {
            return new TapPayment();
        });
        $this->app->bind(OpayPayment::class, function () {
            return new OpayPayment();
        });
        $this->app->bind(PaymobWalletPayment::class, function () {
            return new PaymobWalletPayment();
        });
        $this->app->bind(PaytabsPayment::class, function () {
            return new PaytabsPayment();
        });
    }

    /**
     * Setup the configuration for PlanA23 Payments.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php',
            'PlanA23-payments'
        );
    }
    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations($langPath)
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'PlanA23');
        $this->loadTranslationsFrom($langPath, 'PlanA23');
    }
    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing($langPath)
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('PlanA23-payments.php'),
        ], 'PlanA23-payments-config');

        $this->publishes([
            __DIR__ . '/../resources/lang' => $langPath,
        ], 'PlanA23-payments-lang');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/payments'),
        ], 'PlanA23-payments-views');
    }
}