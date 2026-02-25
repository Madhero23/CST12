<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change default to Pending
        Schema::table('sales', function (Blueprint $table) {
            $table->string('Status')->default('Pending')->change();
        });

        // Update existing 'Completed' sales that haven't been fully paid
        DB::table('sales')
            ->where('Status', 'Completed')
            ->whereRaw('Amount_Paid < Total_Amount_PHP')
            ->update(['Status' => 'Pending']);
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('Status')->default('Completed')->change();
        });
    }
};
