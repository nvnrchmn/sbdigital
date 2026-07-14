<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$logikraf = new \App\Services\LogikrafService();
$res = $logikraf->createSubAccount('test-tenant-123', 'Perumahan Test 123', 'test12345@example.com');
var_dump($res);
