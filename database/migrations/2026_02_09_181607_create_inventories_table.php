<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id('Inventory_ID');
            $table->foreignId('Product_ID')->constrained('products', 'Product_ID')->onDelete('cascade');
            $table->foreignId('Location_ID')->constrained('locations', 'Location_ID')->onDelete('cascade');
            $table->integer('Quantity_On_Hand')->default(0);
            $table->integer('Quantity_Reserved')->default(0);
            $table->integer('Quantity_Available')->default(0);
            $table->timestamp('Last_Stock_Check_Date')->nullable();
            
            // Value tracking
            $table->decimal('Value_PHP', 12, 2)->default(0.00);
            $table->decimal('Value_USD', 12, 2)->default(0.00);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Unique constraint: a product can only have one inventory record per location
            $table->unique(['Product_ID', 'Location_ID']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};