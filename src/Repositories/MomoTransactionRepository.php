<?php

namespace Mobiverse\AppsnmobilePayment\Repositories;

use Mobiverse\AppsnmobilePayment\Models\MomoTransaction;

class MomoTransactionRepository implements IMomoTransactionRepository
{
    private MomoTransaction $model;

    public function __construct(MomoTransaction $model)
    {
        $this->model = $model;
    }

    private function create(array $attributes): MomoTransaction
    {
        return $this->model->create($attributes);
    }

    private function update($id, array $attributes): MomoTransaction
    {
        $updatedModel = $this->model->where($this->model->getKeyName(), $id)->firstOrFail();
        $updatedModel->update($attributes);
        $updatedModel->save();

        return $updatedModel;
    }

    public function createDebit(array $data): MomoTransaction
    {
        $data['internal_trx_id'] = $data['transaction_id'];
        $data['reference'] = config("appsnmobile.purchase.balance.reference");
        $data['transaction_type'] = MomoTransaction::DEBIT;

        return $this->create($data);
    }

    public function createCredit(array $data): MomoTransaction
    {
        $data['internal_trx_id'] = $data['transaction_id'];
        $data['reference'] = config("appsnmobile.purchase.balance.reference");
        $data['transaction_type'] = MomoTransaction::CREDIT;

        return $this->create($data);
    }

    public function setPending($message, $id)
    {
        return $this->update($id, [
            'status' => 'pending',
            'status_message' => substr($message, 0, 100),
        ]);
    }

    public function setFailed($message, $id)
    {
        return $this->update($id, [
            'status' => 'failed',
            'status_message' => substr($message, 0, 100),
        ]);
    }

    public function getPendingByTransactionId(string $internal_trx_id)
    {
        return $this->model->where('internal_trx_id', $internal_trx_id)->where('status', 'pending')->firstOrFail();
    }

    public function setCallbackStatus(array $data, string $status, $id): MomoTransaction
    {
        return $this->update($id, [
            'status' => $status,
            'status_message' => $data['message'],
            'external_trx_id' => $data['trans_id'],
            'callback_date' => date('Y-m-d H:i:s'),
            'callback_response' => $data,
            'completed' => true,
        ]);
    }
}
