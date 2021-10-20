<?php

namespace Mobiverse\AppsnmobilePayment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MomoTransaction extends Model
{
    use HasFactory;

    private $trans_type;

    public const VODAFONE = "vodafone";
    public const MTN = "mtn";
    public const AIRTELTIGO = "airtel-tigo";

    public const CREDIT = 'credit';
    public const DEBIT = 'debit';

    protected $cast = [
        'meta_data' => 'array',
        'completed' => 'bool',
    ];

    protected $fillable = [
        'msisdn',
        'network',
        'amount',
        'transaction_type',
        'payment_request_id',
        'meta_data',
        'internal_trx_id',
        'external_trx_id',
        'status',
        'status_message',
        'callback_date',
        'callback_response',
        'callback_uuid',
        'completed',
    ];

    public function asDebit()
    {
        $this->internal_trx_id = config("appsnmobile.debit_transaction_prefix")
            .str_pad($this->id, 9, "0", STR_PAD_LEFT);

        $this->transaction_type = $this::DEBIT;

        return $this;
    }

    public function asCredit()
    {
        $this->internal_trx_id = config("appsnmobile.credit_transaction_prefix")
            .str_pad($this->id, 9, "0", STR_PAD_LEFT);

        $this->transaction_type = $this::CREDIT;

        return $this;
    }
}
