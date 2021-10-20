<?php

namespace Mobiverse\AppsnmobilePayment\Repositories;

use Mobiverse\AppsnmobilePayment\Models\MomoTransaction;

interface IMomoTransactionRepository
{
    public function createDebit(array $data): MomoTransaction;

    public function createCredit(array $data): MomoTransaction;

    public function setPending($message, $id);

    public function setFailed($message, $id);

    public function getPendingByTransactionId(string $internal_trx_id);

    public function setCallbackStatus(array $data, string $status, $id): MomoTransaction;
}
