<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Sale;

$latest = Sale::orderBy('Sale_ID', 'desc')->first();
if ($latest) {
    echo "Latest Invoice: " . $latest->Invoice_Number . " (ID: " . $latest->Sale_ID . ")\n";
    echo "Customer ID: " . $latest->Customer_ID . "\n";
    echo "Total Amount: " . $latest->Total_Amount_PHP . "\n";
    echo "Quotation ID Link: " . ($latest->Quotation_ID ?? 'NULL') . "\n";
    echo "Notes: " . ($latest->Notes ?? 'None') . "\n";
} else {
    echo "No sales found.\n";
}

echo "Total Sales Count: " . Sale::count() . "\n";
