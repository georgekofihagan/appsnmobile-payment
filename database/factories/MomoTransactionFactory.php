<?php

namespace Mobiverse\AppsnmobilePayment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mobiverse\AppsnmobilePayment\Models\MomoTransaction;

class MomoTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MomoTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'msisdn' => '',
            'network' => '',
            'amount' => 20,
            'transaction_type' => '',
            'payment_request_id' => 0,
            'internal_trx_id' => '',
            'status' => '',
        ];
    }
}
