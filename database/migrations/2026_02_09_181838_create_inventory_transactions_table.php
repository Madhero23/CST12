<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id('Transaction_ID');
            $table->foreignId('Product_ID')->constrained('products', 'Product_ID');
            $table->enum('Transaction_Type', ['StockIn', 'StockOut', 'Transfer', 'Adjustment', 'Return']);
            $table->integer('Quantity');
            $table->timestamp('Transaction_Date')->useCurrent();
            $table->string('Reference_Number')->nullable();
            
            // CRITICAL: Price tracking for historical valuation
            $table->decimal('Unit_Price_At_Transaction', 10, 2);
            $table->decimal('Total_Value', 12, 2);
            
            $table->foreignId('Source_Location_ID')->nullable()->constrained('locations', 'Location_ID');
            $table->foreignId('Destination_Location_ID')->nullable()->constrained('locations', 'Location_ID');
            $table->text('Notes')->nullable();
            $table->foreignId('Performed_By')->nullable()->constrained('users', 'User_ID');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['Product_ID', 'Source_Location_ID', 'Destination_Location_ID'], 'inv_trans_locations_idx');
            $table->index('Transaction_Type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};