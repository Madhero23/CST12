<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach(\App\Models\Sale::all() as $s) {
    echo $s->Invoice_Number . " (" . $s->Sale_ID . ") " . $s->Sale_Date . "\n";
}
