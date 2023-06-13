# Egypt Payments Getaway

[![Latest Version on Packagist](https://img.shields.io/packagist/v/plan-a23/egpayment.svg?style=flat-square)](https://packagist.org/packages/plan-a23/egpayment)
[![Total Downloads](https://img.shields.io/packagist/dt/plan-a23/egpayment.svg?style=flat-square)](https://packagist.org/packages/plan-a23/egpayment)
![GitHub Actions](https://github.com/plan-a23/egpayment/actions/workflows/main.yml/badge.svg)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Supported gateways

- [PayPal](https://paypal.com/)
- [PayMob](https://paymob.com/)
- [WeAccept](https://paymob.com/)
- [Kashier](https://kashier.io/)
- [Fawry](https://fawry.com/)
- [HyperPay](https://www.hyperpay.com/)
- [Thawani](https://thawani.om/)
- [Tap](https://www.tap.company/)
- [Opay](https://www.opaycheckout.com/)
- [Paytabs](https://site.paytabs.com/)
- [E Wallets (Vodafone Cash - Orange Money - Meza Wallet - Etisalat Cash)](https://paymob.com/)

## Installation

You can install the package via composer:

```bash
composer require plan-a23/egpayment
```
## Publish Vendor Files

```bash
php artisan vendor:publish --tag="PlanA23-payments-config"
php artisan vendor:publish --tag="PlanA23-payments-lang"
```

### config file PlanA23-payments.php file
```php
<?php
return [

    #PAYMOB
    'PAYMOB_API_KEY' => env('PAYMOB_API_KEY'),
    'PAYMOB_INTEGRATION_ID' => env('PAYMOB_INTEGRATION_ID'),
    'PAYMOB_IFRAME_ID' => env('PAYMOB_IFRAME_ID'),
    'PAYMOB_HMAC' => env('PAYMOB_HMAC'),
    'PAYMOB_CURRENCY'=> env('PAYMOB_CURRENCY',"EGP"),


    #HYPERPAY
    'HYPERPAY_BASE_URL' => env('HYPERPAY_BASE_URL', "https://eu-test.oppwa.com"),
    'HYPERPAY_URL' => env('HYPERPAY_URL', env('HYPERPAY_BASE_URL') . "/v1/checkouts"),
    'HYPERPAY_TOKEN' => env('HYPERPAY_TOKEN'),
    'HYPERPAY_CREDIT_ID' => env('HYPERPAY_CREDIT_ID'),
    'HYPERPAY_MADA_ID' => env('HYPERPAY_MADA_ID'),
    'HYPERPAY_APPLE_ID' => env('HYPERPAY_APPLE_ID'),
    'HYPERPAY_CURRENCY' => env('HYPERPAY_CURRENCY', "SAR"),


    #KASHIER
    'KASHIER_ACCOUNT_KEY' => env('KASHIER_ACCOUNT_KEY'),
    'KASHIER_IFRAME_KEY' => env('KASHIER_IFRAME_KEY'),
    'KASHIER_TOKEN' => env('KASHIER_TOKEN'),
    'KASHIER_URL' => env('KASHIER_URL', "https://checkout.kashier.io"),
    'KASHIER_MODE' => env('KASHIER_MODE', "test"), //live or test
    'KASHIER_CURRENCY'=>env('KASHIER_CURRENCY',"EGP"),
    'KASHIER_WEBHOOK_URL'=>env('KASHIER_WEBHOOK_URL'),


    #FAWRY
    'FAWRY_URL' => env('FAWRY_URL', "https://atfawry.fawrystaging.com/"),//https://www.atfawry.com/ for production
    'FAWRY_SECRET' => env('FAWRY_SECRET'),
    'FAWRY_MERCHANT' => env('FAWRY_MERCHANT'),


    #PayPal
    'PAYPAL_CLIENT_ID' => env('PAYPAL_CLIENT_ID'),
    'PAYPAL_SECRET' => env('PAYPAL_SECRET'),
    'PAYPAL_CURRENCY' => env('PAYPAL_CURRENCY', "USD"),
    'PAYPAL_MODE' => env('PAYPAL_MODE',"sandbox"),//sandbox or live


    #THAWANI
    'THAWANI_API_KEY' => env('THAWANI_API_KEY', ''),
    'THAWANI_URL' => env('THAWANI_URL', "https://uatcheckout.thawani.om/"),
    'THAWANI_PUBLISHABLE_KEY' => env('THAWANI_PUBLISHABLE_KEY', ''),

    #TAP
    'TAP_CURRENCY' => env('TAP_CURRENCY',"USD"),
    'TAP_SECRET_KEY'=>env('TAP_SECRET_KEY',''),
    'TAP_PUBLIC_KEY'=>env('TAP_PUBLIC_KEY',''),
    'TAP_LANG_KEY'=>env('TAP_LANG_KEY','ar'),


    #OPAY
    'OPAY_CURRENCY'=>env('OPAY_CURRENCY',"EGP"),
    'OPAY_SECRET_KEY'=>env('OPAY_SECRET_KEY'),
    'OPAY_PUBLIC_KEY'=>env('OPAY_PUBLIC_KEY'),
    'OPAY_MERCHANT_ID'=>env('OPAY_MERCHANT_ID'),
    'OPAY_COUNTRY_CODE'=>env('OPAY_COUNTRY_CODE',"EG"),
    'OPAY_BASE_URL'=>env('OPAY_BASE_URL',"https://sandboxapi.opaycheckout.com"),//https://api.opaycheckout.com for production


    #PAYMOB_WALLET (Vodafone-cash,orange-money,etisalat-cash,we-cash,meza-wallet) - test phone 01010101010 ,PIN & OTP IS 123456
    'PAYMOB_WALLET_INTEGRATION_ID'=>env('PAYMOB_WALLET_INTEGRATION_ID'),

    #Paytabs
    'PAYTABS_PROFILE_ID'  => env('PAYTABS_PROFILE_ID'),
    'PAYTABS_SERVER_KEY' =>  env('PAYTABS_SERVER_KEY'),
    'PAYTABS_BASE_URL' =>   env('PAYTABS_BASE_URL',"https://secure-egypt.paytabs.com"),
    'PAYTABS_CHECKOUT_LANG' => env('PAYTABS_CHECKOUT_LANG',"AR"),
    'PAYTABS_CURRENCY'=>env('PAYTABS_CURRENCY',"EGP"),

    'VERIFY_ROUTE_NAME' => "payment-verify",
    'APP_NAME'=>env('APP_NAME'),
];
```
## Web.php MUST Have Route with name “payment-verify”

```php
Route::get('/payments/verify/{payment?}',[YourPaymentController::class,'payment_verify'])->name('payment-verify');
```

## Usage
### To Use PayMob Payment
```php
use PlanA23\EGPayment\PaymobPayment;
```
### To Use PayMob Wallet Payment
```php
use PlanA23\EGPayment\PaymobWalletPayment;
```
### To Use Fawry Payment
```php
use PlanA23\EGPayment\FawryPayment;
```
### To Use HyperPay Payment
```php
use PlanA23\EGPayment\HyperPayPayment;
```
### To Use Kashier Payment
```php
use PlanA23\EGPayment\KashierPayment;
```
### To Use PayPalPayment
```php
use PlanA23\EGPayment\PayPalPayment;
```
### To Use Thawani Payment
```php
use PlanA23\EGPayment\ThawaniPayment;
```
### To Use Tap Payment
```php
use PlanA23\EGPayment\TapPayment;
```
### To Use Opay Payment
```php
use PlanA23\EGPayment\OpayPayment;
```
### To Use PayTabs Payment
```php
use PlanA23\EGPayment\PaytabsPayment;
```
## Payments Function
### pay function
```php
    $payment->pay(
	$amount, 
	$user_id = null, 
	$user_first_name = null, 
	$user_last_name = null, 
	$user_email = null, 
	$user_phone = null, 
	$source = null
);
```
or
```php
    $payment->setUserId($id)
        ->setUserFirstName($first_name)
        ->setUserLastName($last_name)
        ->setUserEmail($email)
        ->setUserPhone($phone)
        ->setCurrency($currency)
        ->setAmount($amount)
        ->pay();

);
```
response
```json
[
  "payment_id"=>"",
  "redirect_url"=>"", 
  "html"=>""
]
```
payment_id: refrence code that should stored in your orders table

redirect_url: redirect url available for some payment gateways 

html: rendered html available for some payment gateways

### verify function
```php
$payment->verify($request);
```
response
```
[
  "success"=>true,
  "payment_id"=>"PID",	  
  "message"=>"Done Successfully",	  
  "process_data"=>""
]

```


## Test Cards

- [Thawani](https://docs.thawani.om/docs/thawani-ecommerce-api/ZG9jOjEyMTU2Mjc3-thawani-test-card)
- [Kashier](https://developers.kashier.io/payment/testing)
- [Paymob](https://docs.paymob.com/docs/card-payments)
- [Fawry](https://developer.fawrystaging.com/docs/testing/testing)
- [Tap](https://www.tap.company/eg/en/developers)
- [Opay](https://doc.opaycheckout.com/end-to-end-testing)
- [PayTabs](https://support.paytabs.com/en/support/solutions/articles/60000712315-what-are-the-test-cards-available-to-perform-payments-)


### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email ahmed.m.eid.2001@gmail.com instead of using the issue tracker.

## Credits

-   [ahmed eid](https://github.com/ahmedeid46)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
