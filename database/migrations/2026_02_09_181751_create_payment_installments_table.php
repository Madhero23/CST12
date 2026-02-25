<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_installments', function (Blueprint $table) {
            $table->id('Installment_ID');
            $table->foreignId('Payment_Plan_ID')->constrained('payment_plans', 'Payment_Plan_ID')->onDelete('cascade');
            $table->integer('Installment_Number');
            $table->date('Due_Date');
            $table->decimal('Amount_Due', 10, 2);
            $table->decimal('Amount_Paid', 10, 2)->default(0.00);
            $table->decimal('Late_Fee', 10, 2)->default(0.00);
            $table->decimal('Total_Due', 10, 2)->default(0.00);
            $table->date('Payment_Date')->nullable();
            $table->enum('Payment_Method', ['BankTransfer', 'Check', 'GCash', 'Cash', 'CreditCard'])->nullable();
            $table->enum('Payment_Status', ['Pending', 'Paid', 'Overdue', 'Partial'])->default('Pending');
            $table->string('Transaction_Reference')->nullable();
            $table->string('Receipt_Path')->nullable();
            $table->decimal('Exchange_Rate_Used', 8, 4)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['Payment_Plan_ID', 'Installment_Number']);
            $table->index('Due_Date');
            $table->index('Payment_Status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_installments');
    }
};