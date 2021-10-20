<?php

namespace Mobiverse\AppsnmobilePayment;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mobiverse\AppsnmobilePayment\AppsnmobilePayment
 */
class AppsnmobilePaymentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return IAppsnmobilePayment::class;
    }
}
