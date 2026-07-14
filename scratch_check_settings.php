<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Central ID: " . \App\Models\Setting::get('logikraf_central_sub_account_id', 'NOT FOUND') . "\n";
echo "Config Central ID: " . config('logikraf.central_sub_account_id') . "\n";
echo "API Key: " . \App\Models\Setting::get('logikraf_api_key', 'NOT FOUND') . "\n";
