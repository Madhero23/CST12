<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('Shelf')->nullable()->after('Quantity_Available');
            $table->string('Rack')->nullable()->after('Shelf');
            $table->string('Area')->nullable()->after('Rack');
            $table->string('Batch_Number')->nullable()->after('Area');
        });

        Schema::table('inventory_transactions', function (Blueprint $table) {
            $table->string('Shelf')->nullable()->after('Destination_Location_ID');
            $table->string('Rack')->nullable()->after('Shelf');
            $table->string('Area')->nullable()->after('Rack');
            $table->string('Batch_Number')->nullable()->after('Area');
            $table->string('Receiving_Department')->nullable()->after('Batch_Number');
            $table->foreignId('Supplier_ID')->nullable()->after('Product_ID')->constrained('suppliers', 'Supplier_ID');
        });
    }

    public function down(): void
    {
        Schema::table('inventory_transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('Supplier_ID');
            $table->dropColumn(['Shelf', 'Rack', 'Area', 'Batch_Number', 'Receiving_Department']);
        });

        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn(['Shelf', 'Rack', 'Area', 'Batch_Number']);
        });
    }
};
