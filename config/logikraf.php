<?php

return [
    'api_key' => env('LOGIKRAF_API_KEY'),
    'webhook_secret' => env('LOGIKRAF_WEBHOOK_SECRET'),
    'base_url' => env('LOGIKRAF_BASE_URL', 'https://logikraf.id/api/payment-hub/v1'),
];
