<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_interactions', function (Blueprint $table) {
            $table->id('Interaction_ID');
            $table->foreignId('Customer_ID')->constrained('customers', 'Customer_ID');
            $table->foreignId('User_ID')->constrained('users', 'User_ID');
            $table->enum('Interaction_Type', ['Call', 'Email', 'Meeting', 'WhatsApp', 'SMS', 'SiteVisit']);
            $table->timestamp('Interaction_Date')->useCurrent();
            $table->string('Subject');
            $table->text('Details');
            $table->foreignId('Related_Quotation_ID')->nullable()->constrained('quotations', 'Quotation_ID');
            $table->date('Follow_Up_Date')->nullable();
            $table->enum('Status', ['Completed', 'Pending', 'Cancelled'])->default('Completed');
            $table->integer('Duration_Minutes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('Customer_ID');
            $table->index('Interaction_Date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_interactions');
    }
};