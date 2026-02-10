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
            $table->string('Quotation_Number')->unique();
            $table->foreignId('Customer_ID')->constrained('customers', 'Customer_ID');
            $table->foreignId('Created_By')->constrained('users', 'User_ID');
            $table->date('Creation_Date')->useCurrent();
            $table->date('Expiration_Date');
            $table->enum('Status', ['Draft', 'Sent', 'Pending', 'Approved', 'Won', 'Lost'])->default('Draft');
            $table->integer('Version_Number')->default(1);
            $table->foreignId('Parent_Quotation_ID')->nullable()->constrained('quotations', 'Quotation_ID');
            $table->foreignId('Template_ID')->nullable()->constrained('quotation_templates', 'Template_ID');
            $table->string('Template_Used')->nullable();
            $table->decimal('Total_Amount_PHP', 12, 2);
            $table->decimal('Total_Amount_USD', 12, 2);
            $table->date('Conversion_Date')->nullable();
            $table->text('Reason_For_Loss')->nullable();
            $table->date('Follow_Up_Date')->nullable();
            $table->timestamps();
            
            $table->index('Status');
            $table->index('Customer_ID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};