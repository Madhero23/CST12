<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotation_line_items', function (Blueprint $table) {
            $table->id('Line_Item_ID');
            $table->foreignId('Quotation_ID')->constrained('quotations', 'Quotation_ID')->onDelete('cascade');
            $table->foreignId('Product_ID')->constrained('products', 'Product_ID');
            $table->integer('Quantity');
            $table->decimal('Unit_Price', 10, 2);
            
            // Regular column instead of generated (SQLite limitation)
            $table->decimal('Line_Total', 10, 2)->default(0.00);
            
            $table->decimal('Discount_Percentage', 5, 2)->default(0.00);
            $table->text('Notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_line_items');
    }
};