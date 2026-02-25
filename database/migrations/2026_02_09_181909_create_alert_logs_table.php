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
            $table->enum('Alert_Type', ['Security', 'System', 'Maintenance', 'Inventory', 'Sales']);
            $table->string('Subject');
            $table->text('Message');
            $table->enum('Severity', ['Low', 'Medium', 'High', 'Critical'])->default('Medium');
            $table->boolean('Is_Read')->default(false);
            $table->foreignId('Read_By')->nullable()->constrained('users', 'User_ID');
            $table->timestamp('Read_Date')->nullable();
            $table->enum('Resolution_Status', ['Unresolved', 'InProgress', 'Resolved', 'Dismissed'])->default('Unresolved');
            $table->enum('Related_Entity_Type', ['Product', 'Quotation', 'Customer', 'User', 'Sale', 'Document'])->nullable();
            $table->unsignedBigInteger('Related_Entity_ID')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['Related_Entity_Type', 'Related_Entity_ID']);
            $table->index('Alert_Type');
            $table->index('Severity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alert_logs');
    }
};