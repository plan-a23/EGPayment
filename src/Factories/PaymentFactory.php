<?php

namespace PlanA23\EGPayment\Factories;

use NPlanA23\EGPayment\Interfaces\PaymentInterface;
use PlanA23\EGPayment\Classes;


class PaymentFactory
{


    /**
     *
     * get the payment class that the user want
     * if not exist return ex
     * @param string $name
     * @return PaymentInterface|Exception
     * @throws Exception
     */

    public function get(string $name): PaymentInterface|Exception
    {

        $className = 'PlanA23\EGPayment\Classes\\' . $name . 'Payment';

        if (class_exists($className))
            return new $className();

        throw new \Exception("Invalid gateway");
    }


}
