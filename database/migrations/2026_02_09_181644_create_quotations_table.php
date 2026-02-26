<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id('Quotation_ID');
            $table->string('Quotation_Number')->unique()->index();
            $table->foreignId('Customer_ID')->constrained('customers', 'Customer_ID');
            $table->foreignId('Created_By')->constrained('users', 'User_ID');
            $table->date('Expiration_Date');
            $table->enum('Status', ['Draft', 'Sent', 'Pending', 'Approved', 'Won', 'Lost'])->default('Draft');
            $table->integer('Version_Number')->default(1);
            $table->foreignId('Parent_Quotation_ID')->nullable()->constrained('quotations', 'Quotation_ID');
            $table->foreignId('Template_ID')->nullable()->constrained('quotation_templates', 'Template_ID');
            $table->string('Template_Used')->nullable();
            
            // TAX SUPPORT (Philippine VAT)
            $table->decimal('Subtotal_Amount_PHP', 12, 2);
            $table->decimal('Subtotal_Amount_USD', 12, 2);
            $table->decimal('Tax_Rate', 5, 2)->default(12.00);  // 12% VAT
            $table->decimal('Tax_Amount_PHP', 12, 2)->default(0.00);
            $table->decimal('Tax_Amount_USD', 12, 2)->default(0.00);
            $table->decimal('Total_Amount_PHP', 12, 2);
            $table->decimal('Total_Amount_USD', 12, 2);
            $table->boolean('Is_Tax_Inclusive')->default(false);
            
            $table->date('Conversion_Date')->nullable();
            $table->text('Reason_For_Loss')->nullable();
            $table->date('Follow_Up_Date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('Status');
            $table->index('Customer_ID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};