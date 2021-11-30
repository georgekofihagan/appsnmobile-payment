<?php

namespace Mobiverse\AppsnmobilePayment;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Mobiverse\AppsnmobilePayment\Events\PaymentFailed;
use Mobiverse\AppsnmobilePayment\Events\PaymentPending;
use Mobiverse\AppsnmobilePayment\Events\PaymentSucceeded;
use Mobiverse\AppsnmobilePayment\Exceptions\AppsnmobileException;
use Mobiverse\AppsnmobilePayment\Models\AppsnmobilePaymentRequest;
use Mobiverse\AppsnmobilePayment\Models\MomoTransaction;
use Mobiverse\AppsnmobilePayment\Repositories\IMomoTransactionRepository;

class AppsnmobilePayment implements IAppsnmobilePayment
{
    private IMomoTransactionRepository $momoTransactionRepository;

    public function __construct(IMomoTransactionRepository $momoTransactionRepository)
    {
        $this->momoTransactionRepository = $momoTransactionRepository;
    }

    public function executeDebitRequest(array $data)
    {
        try {
            $transaction = $this->momoTransactionRepository->createDebit($data);

            $response = $this->makeRequest(
                (new AppsnmobilePaymentRequest($transaction))->toArray(),
                MomoTransaction::DEBIT
            );

            if (! $this->requestWasSuccessful($response)) {
                $this->momoTransactionRepository->setFailed($response->body(), $transaction->id);

                throw new AppsnmobileException($response->body());
            }

            $this->handleResponse($response, $transaction);
        } catch (QueryException | ConnectionException | Exception $ex) {
            throw new AppsnmobileException($ex->getMessage());
        }
    }

    private function requestWasSuccessful($response)
    {
        if (! $response->successful() || is_null($response->json()) || ! isset($response->json()['resp_code'])) {
            return false;
        }

        return true;
    }

    private function makeRequest($params, $transaction_type)
    {
        $params['callback_url'] = config("appsnmobile.{$transaction_type}_callback_url");

        return Http::timeout(60)->withoutVerifying()
            ->acceptJson()
            ->withBasicAuth(config('appsnmobile.auth.basic.user'), config('appsnmobile.auth.basic.pass'))
            ->post(config('appsnmobile.baseurl')."?endpoint=sendRequest", $params);
    }

    public function processDebitCallback(array $data)
    {
        $transaction = $this->momoTransactionRepository->getPendingByTransactionId($data['trans_ref']);
        $status = $this->getFinalStatus($data);

        $transaction = $this->momoTransactionRepository->setCallbackStatus($data, $status, $transaction->id);
        if ($status == 'success') {
            PaymentSucceeded::dispatch($transaction);
        } else {
            PaymentFailed::dispatch($transaction);
        }
    }

    private function getFinalStatus(array $data)
    {
        if (substr($data['trans_status'], 0, 4) == "000/") {
            return "success";
        }

        return "failed";
    }

    /**
     * @param Response $response
     * @param mixed $data
     * @param MomoTransaction $transaction
     * @throws AppsnmobileException
     */
    private function handleResponse(Response $response, MomoTransaction $transaction): void
    {
        $data = $response->json();

        if ($data['resp_code'] == "015") {
            $transaction = $this->momoTransactionRepository->setPending($data['resp_desc'], $transaction->id);
            PaymentPending::dispatch($transaction);
        } else {
            $this->momoTransactionRepository->setFailed($data['resp_desc'], $transaction->id);

            throw new AppsnmobileException($data['resp_desc']);
        }
    }
}
