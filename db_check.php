<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Inquiry;

echo "Active Products Count: " . Product::where('Status', 'Active')->count() . "\n";
echo "Existing Inquiries for reyes@clinic.ph: " . Inquiry::where('email', 'reyes@clinic.ph')->count() . "\n";
echo "Current Pending Inquiries (status='new'): " . Inquiry::where('status', 'new')->count() . "\n";
