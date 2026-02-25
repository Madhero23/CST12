<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('Customer_ID');
            $table->string('Institution_Name');
            $table->enum('Customer_Type', ['Hospital', 'School', 'Government', 'PrivateClinic', 'OtherInstitution']);
            $table->string('Contact_Person');
            $table->string('Email')->unique();
            $table->string('Phone');
            $table->text('Address');
            $table->enum('Segment_Type', ['HighValue', 'MediumValue', 'LowValue', 'Prospect']);
            $table->enum('Status', ['Active', 'Inactive', 'OnHold'])->default('Active');
            $table->string('Payment_Terms_Preference')->nullable();
            $table->decimal('Credit_Limit', 12, 2)->nullable();
            $table->decimal('Available_Credit', 12, 2)->nullable();
            $table->decimal('Total_Purchase_Value', 12, 2)->default(0.00);
            $table->date('Last_Interaction_Date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index('Customer_Type');
            $table->index('Status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};