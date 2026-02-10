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
            $table->integer('Current_Stock')->default(0);
            $table->date('Last_Stock_Movement_Date')->nullable();
            $table->enum('Aging_Status', ['Current', '6-Months', '1-Year', '5+ Years'])->nullable();
            
            // Using regular columns instead of generated columns (SQLite limitation)
            $table->decimal('Value_PHP', 12, 2)->default(0.00);
            $table->decimal('Value_USD', 12, 2)->default(0.00);
            
            $table->boolean('Low_Stock_Flag')->default(false);
            $table->date('Reorder_Point_Reached_Date')->nullable();
            $table->date('Created_Date')->useCurrent();
            $table->timestamp('Updated_Date')->useCurrent();
            $table->timestamps();
            
            // Unique constraint: a product can only have one inventory record per location
            $table->unique(['Product_ID', 'Location_ID']);
            
            // Index for better performance
            $table->index('Low_Stock_Flag');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};