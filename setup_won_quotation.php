<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Quotation;

$q = Quotation::find(7);
if ($q) {
     $q->Status = 'Won';
     $q->save();
     echo "Quotation 7 status updated to: " . $q->Status . "\n";
} else {
    echo "Quotation 7 NOT FOUND\n";
}
