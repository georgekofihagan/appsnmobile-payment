<?php

namespace Mobiverse\AppsnmobilePayment;

interface IAppsnmobilePayment
{
    public function executeDebitRequest(array $data);

    public function processDebitCallback(array $data);
}
