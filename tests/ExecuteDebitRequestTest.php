<?php

namespace Mobiverse\AppsnmobilePayment\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mobiverse\AppsnmobilePayment\AppsnmobilePaymentFacade;
use PHPUnit\Framework\TestCase;

class ExecuteDebitRequestTest extends TestCase
{
    use RefreshDatabase;

    // other tests

    /** @test */
    function a_momo_transaction_is_created_when_an_execute_debit_request_is_fired()
    {
        AppsnmobilePaymentFacade::executeDebitRequest([
            'msisdn' => '0244377919',
            'network' => \Mobiverse\AppsnmobilePayment\Models\MomoTransaction::VODAFONE,
            'amount' => 0.10,
            'payment_request_id' => 1,
            'transaction_id' => 'AD001',
        ]);
    }
}

