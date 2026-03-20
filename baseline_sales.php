<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Sale;

echo "Sales: " . Sale::count() . "\n";
echo "Max Sale ID: " . Sale::max('Sale_ID') . "\n";
