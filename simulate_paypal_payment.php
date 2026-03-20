<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\FinanceController;
use Illuminate\Http\Request;
use App\Models\Sale;

// Simulate Admin Login (ID: 1)
Auth::loginUsingId(1);

$controller = $app->make(FinanceController::class);

$saleId = 7; // The sale from TC-FIN-002 (Sent status, ID 7)
$sale = Sale::find($saleId);

if (!$sale) {
    die("Sale 7 not found.\n");
}

echo "Pre-Payment Status for Sale 7:\n";
echo "- Total Amount: " . $sale->Total_Amount_PHP . "\n";
echo "- Amount Paid: " . ($sale->Amount_Paid ?? 0) . "\n";

// Craft invalid request
$request = Request::create("/admin/finance/sale/{$saleId}/payment", 'POST', [
    'amount_paid' => 1000,
    'payment_method' => 'Paypal', // INVALID
    'payment_date' => date('Y-m-d'),
    'payment_reference' => 'BYPASS-TEST-PAYPAL'
]);

echo "\nAttempting to record 'Paypal' payment via Controller...\n";

try {
    $response = $controller->recordPayment($request, $saleId);
    echo "Response Status: " . $response->getStatusCode() . "\n";
    echo "Response Content: " . $response->getContent() . "\n";
} catch (\Throwable $e) {
    echo "Caught Exception: " . $e->getMessage() . "\n";
}

// Check database state after attempt
$sale->refresh();
echo "\nPost-Payment Status for Sale 7:\n";
echo "- Amount Paid: " . ($sale->Amount_Paid ?? 0) . "\n";
echo "- Payment Method in Sale Record: " . ($sale->Payment_Method ?? 'NULL') . "\n";

$installment = \App\Models\PaymentInstallment::where('Transaction_Reference', 'BYPASS-TEST-PAYPAL')->first();
if ($installment) {
    echo "- NEW Installment Record Found! (ID: " . $installment->Installment_ID . ")\n";
    echo "- Stored Method in Installment: " . $installment->Payment_Method . "\n";
} else {
    echo "- No installment record created.\n";
}
