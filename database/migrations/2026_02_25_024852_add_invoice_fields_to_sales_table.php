<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->text('Notes')->nullable()->after('Payment_Term_Months');
            $table->date('Due_Date')->nullable()->after('Notes');
            $table->string('Payment_Terms')->nullable()->after('Due_Date');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['Notes', 'Due_Date', 'Payment_Terms']);
        });
    }
};
