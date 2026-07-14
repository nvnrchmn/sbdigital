<?php

return [
    'api_key' => env('LOGIKRAF_API_KEY'),
    'webhook_secret' => env('LOGIKRAF_WEBHOOK_SECRET'),
    'base_url' => env('LOGIKRAF_BASE_URL', 'https://logikraf.id/api/payment-hub/v1'),
    'central_sub_account_id' => env('LOGIKRAF_CENTRAL_SUB_ACCOUNT_ID', '6a53272e56bb2b5c48851f14'),
];
