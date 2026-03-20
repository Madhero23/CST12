<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Quotation;
use App\Models\QuotationLineItem;
use App\Models\Location;

$q = Quotation::with('customer')->find(7);
if ($q) {
    echo "Quotation 7 Status: " . $q->Status . "\n";
    echo "Customer: " . ($q->customer->Institution_Name ?? 'N/A') . " (ID: " . $q->Customer_ID . ")\n";
    echo "Total Amount: " . $q->Total_Amount_PHP . "\n";
    echo "Quotation Number: " . ($q->Quotation_Number ?? 'N/A') . "\n";
} else {
    echo "Quotation 7 NOT FOUND\n";
}

$items = QuotationLineItem::where('Quotation_ID', 7)->get();
echo "Line Items: " . $items->count() . "\n";
foreach($items as $item) {
    echo "- Product ID: " . $item->Product_ID . ", Qty: " . $item->Quantity . ", Price: " . $item->Unit_Price . "\n";
}

echo "Locations: " . Location::count() . "\n";
