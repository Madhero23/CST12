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
            $table->enum('Transaction_Type', ['Stock In', 'Stock Out', 'Transfer', 'Adjustment', 'Return']);
            $table->foreignId('Product_ID')->constrained('products', 'Product_ID');
            $table->integer('Quantity');
            $table->timestamp('Transaction_Date')->useCurrent();
            $table->string('Reference_Number')->nullable();
            $table->foreignId('Source_Location_ID')->nullable()->constrained('locations', 'Location_ID');
            $table->foreignId('Destination_Location_ID')->nullable()->constrained('locations', 'Location_ID');
            $table->text('Notes')->nullable();
            $table->foreignId('Performed_By')->nullable()->constrained('users', 'User_ID');
            $table->timestamps();
            
            $table->index('Transaction_Date');
            $table->index(['Product_ID', 'Transaction_Type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};