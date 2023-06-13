<?php

namespace PlanA23\EGPayment\Facades;

use Illuminate\Support\Facades\Facade;

class PlanAEGPaymentsFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'PlanA23_payments';
    }
}