<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id('Sale_ID');
            $table->foreignId('Quotation_ID')->nullable()->unique()->constrained('quotations', 'Quotation_ID');
            $table->foreignId('Customer_ID')->constrained('customers', 'Customer_ID');
            $table->foreignId('Processed_By')->constrained('users', 'User_ID');
            $table->date('Sale_Date')->useCurrent();
            
            // TAX SUPPORT (Philippine VAT)
            $table->decimal('Subtotal_Amount_PHP', 12, 2);
            $table->decimal('Subtotal_Amount_USD', 12, 2);
            $table->decimal('Tax_Rate', 5, 2)->default(12.00);  // 12% VAT
            $table->decimal('Tax_Amount_PHP', 12, 2)->default(0.00);
            $table->decimal('Tax_Amount_USD', 12, 2)->default(0.00);
            $table->decimal('Total_Amount_PHP', 12, 2);
            $table->decimal('Total_Amount_USD', 12, 2);
            $table->boolean('Is_Tax_Inclusive')->default(false);
            
            $table->enum('Currency_Type', ['PHP', 'USD'])->default('PHP');
            $table->decimal('Exchange_Rate_At_Sale', 8, 4)->nullable();
            $table->enum('Status', ['Completed', 'Pending', 'Cancelled', 'Refunded'])->default('Completed');
            $table->integer('Payment_Term_Months')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('Sale_Date');
            $table->index('Status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};