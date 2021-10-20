<?php

namespace Mobiverse\AppsnmobilePayment\Models;

use Mobiverse\AppsnmobilePayment\Models\MomoTransaction;

class AppsnmobilePaymentRequest
{
    private MomoTransaction $momoTransaction;

    public function __construct(MomoTransaction $momoTransaction)
    {
        $this->momoTransaction = $momoTransaction;
    }

    public function toArray()
    {
        return [
            'customer_number' => $this->momoTransaction->msisdn,
            'nw' => $this->setNetwork($this->momoTransaction->network),
            'exttrid' => $this->momoTransaction->internal_trx_id,
            'reference' => 'adowaa payment'.$this->momoTransaction->reference,
            'trans_type' => $this->setTransType($this->momoTransaction->transaction_type),
            'ts' => date('Y-m-d H:i:s'),
            'amount' => $this->momoTransaction->amount,
        ];
    }

    private function setNetwork(string $network)
    {
        $networks = [
            MomoTransaction::VODAFONE=>'VOD',
            MomoTransaction::MTN=>'MTN',
            MomoTransaction::AIRTELTIGO=>'AIR'
        ];
        return $networks[$network];
    }

    private function setTransType($trans_type)
    {
        $trans_types = [
            MomoTransaction::CREDIT => 'CTM',
            MomoTransaction::DEBIT => 'CTM'
        ];
        return $trans_types[$trans_type];
    }
}
