<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Sale;
use App\Models\PaymentInstallment;

$sale = Sale::where('Status', '!=', 'Completed')->orderBy('Sale_ID', 'desc')->first();
if ($sale) {
    echo "Using Sale ID: " . $sale->Sale_ID . " (Invoice: " . $sale->Invoice_Number . ")\n";
    echo "Outstanding Balance: " . ($sale->Total_Amount_PHP - ($sale->Amount_Paid ?? 0)) . "\n";
    echo "Current Amount Paid: " . ($sale->Amount_Paid ?? 0) . "\n";
} else {
    echo "No eligible sales found.\n";
}

echo "Total Payments Count: " . PaymentInstallment::count() . "\n";
echo "Total Sales with Payment: " . Sale::where('Amount_Paid', '>', 0)->count() . "\n";
