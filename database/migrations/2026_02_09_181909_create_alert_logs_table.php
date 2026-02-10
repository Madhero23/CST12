<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alert_logs', function (Blueprint $table) {
            $table->id('Alert_ID');
            $table->enum('Alert_Type', [
                'LowStock', 
                'PaymentDue', 
                'AgingStock', 
                'Replenishment', 
                'QuotationExpiry', 
                'CertificateExpiry'
            ]);
            $table->enum('Entity_Type', ['Product', 'Customer', 'Quotation', 'Payment', 'Document']);
            $table->unsignedBigInteger('Entity_ID');
            $table->text('Alert_Message');
            $table->enum('Priority_Level', ['Low', 'Medium', 'High', 'Critical']);
            $table->timestamp('Generated_Date')->useCurrent();
            $table->foreignId('Acknowledged_By')->nullable()->constrained('users', 'User_ID');
            $table->timestamp('Acknowledged_Date')->nullable();
            $table->enum('Resolution_Status', ['Open', 'Acknowledged', 'Resolved', 'Dismissed'])->default('Open');
            $table->timestamp('Created_Date')->useCurrent();
            $table->timestamps();
            
            $table->index('Resolution_Status');
            $table->index('Alert_Type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alert_logs');
    }
};