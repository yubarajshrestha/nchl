<?php

return [
    'merchant_id'               => env('NCHL_MERCHANT_ID', null),
    'app_id'                    => env('NCHL_APP_ID', null),
    'app_name'                  => env('NCHL_APP_NAME', null),
    'password'                  => env('NCHL_APP_PASSWORD', null),
    'txn_currency'              => env('NCHL_CURRENCY', 'NPR'),
    'gateway'                   => env('NCHL_GATEWAY', 'https://www.connectips.com/connectipsgw/loginpage'),
    'validation_url'            => env('NCHL_VALIDATION_URL', 'https://www.connectips.com/connectipsgw/api/creditor/validatetxn'),
    'transaction_detail_url'    => env('NCHL_TRANSACTION_DETAIL_URL', 'https://www.connectips.com/connectipswebws/api/creditor/gettxndetail'),
];
