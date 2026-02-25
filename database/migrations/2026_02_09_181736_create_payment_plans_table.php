<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id('Payment_Plan_ID');
            $table->foreignId('Sale_ID')->constrained('sales', 'Sale_ID')->onDelete('cascade');
            $table->decimal('Total_Amount', 12, 2);
            $table->string('Currency')->default('PHP');
            $table->integer('Payment_Term_Months')->default(6);
            $table->date('Start_Date');
            $table->date('End_Date');
            $table->enum('Status', ['Active', 'Completed', 'Overdue', 'Cancelled'])->default('Active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_plans');
    }
};