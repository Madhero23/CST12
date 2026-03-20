<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Quotation;
use App\Models\Sale;

$q = Quotation::find(8);
if ($q) {
    echo "Quotation 8 Status: " . $q->Status . "\n";
    echo "Customer ID: " . $q->Customer_ID . "\n";
    echo "Total Amount: " . $q->Total_Amount_PHP . "\n";
    echo "Quotation Number: " . ($q->Quotation_Number ?? 'N/A') . "\n";
} else {
    echo "Quotation 8 NOT FOUND\n";
}

$sales = Sale::where('Quotation_ID', 8)->get();
echo "Linked Sales: " . $sales->count() . "\n";

echo "Total Sales Count: " . Sale::count() . "\n";
