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
            $table->enum('Customer_Type', ['Hospital', 'School', 'Government', 'Private Clinic', 'Other Institution']);
            $table->string('Contact_Person');
            $table->string('Email');
            $table->string('Phone');
            $table->text('Address');
            $table->enum('Segment_Type', ['High-Value', 'Medium-Value', 'Low-Value', 'Prospect']);
            $table->date('Date_Created')->useCurrent();
            $table->enum('Status', ['Active', 'Inactive', 'On Hold'])->default('Active');
            $table->string('Payment_Terms_Preference')->nullable();
            $table->decimal('Total_Purchase_Value', 12, 2)->default(0.00);
            $table->date('Last_Interaction_Date')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('Email');
            $table->index('Customer_Type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};