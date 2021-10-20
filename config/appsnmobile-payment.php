<?php
// config for Mobiverse/AppsnmobilePayment
return [
    'baseurl' => env('MOMO_BASEURL', false),
    'callback_url'=>env('MOMO_CALLBACK_URL',false),
    'debit_transaction_prefix'=>env('MOMO_DEBIT_TRANSACTION_PREFIX',false),
    'credit_transaction_prefix'=>env('MOMO_CREDIT_TRANSACTION_PREFIX',false),
    'debit_callback_url'=>env('MOMO_DEBIT_CALLBACK_URL',false),
    'credit_callback_url'=>env('MOMO_CREDIT_CALLBACK_URL',false),
    'auth'=>[
        'basic'=>[
            'user'=>env('MOMO_BASICAUTH_USR',false),
            'pass'=>env('MOMO_BASICAUTH_PWD',false)
        ]
    ],
    'purchase'=>[
        'balance'=>[
            'reference'=>env('MOMO_PURCHASE_BALANCE_REFERENCE',false)
        ]
    ]
];
