<?php
// config for Mobiverse/AppsnmobilePayment
return [
    'baseurl' => env('MOMO_BASEURL', ''),
    'callback_url'=>env('MOMO_CALLBACK_URL',''),
    'debit_transaction_prefix'=>env('MOMO_DEBIT_TRANSACTION_PREFIX',''),
    'credit_transaction_prefix'=>env('MOMO_CREDIT_TRANSACTION_PREFIX',''),
    'debit_callback_url'=>env('MOMO_DEBIT_CALLBACK_URL',''),
    'credit_callback_url'=>env('MOMO_CREDIT_CALLBACK_URL',''),
    'auth'=>[
        'basic'=>[
            'user'=>env('MOMO_BASICAUTH_USR',''),
            'pass'=>env('MOMO_BASICAUTH_PWD','')
        ]
    ]
];
