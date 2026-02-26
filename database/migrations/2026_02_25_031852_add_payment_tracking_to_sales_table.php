<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('Amount_Paid', 12, 2)->default(0.00)->after('Total_Amount_USD');
            $table->string('Payment_Method')->nullable()->after('Amount_Paid');
            $table->date('Last_Payment_Date')->nullable()->after('Payment_Method');
            $table->string('Payment_Reference')->nullable()->after('Last_Payment_Date');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['Amount_Paid', 'Payment_Method', 'Last_Payment_Date', 'Payment_Reference']);
        });
    }
};
