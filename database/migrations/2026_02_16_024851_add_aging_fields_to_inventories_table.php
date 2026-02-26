<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->date('Manufacturing_Date')->nullable()->after('Last_Stock_Check_Date');
            $table->date('Received_Date')->nullable()->after('Manufacturing_Date');
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn(['Manufacturing_Date', 'Received_Date']);
        });
    }
};
