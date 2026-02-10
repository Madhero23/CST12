<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id('Document_ID');
            $table->enum('Document_Type', [
                'Quotation', 
                'Invoice', 
                'FDA Certificate', 
                'Supplier Certificate', 
                'Customs Document', 
                'Receipt', 
                'Contract'
            ]);
            $table->string('File_Path');
            $table->string('File_Name');
            $table->integer('File_Size')->nullable();
            $table->enum('Related_Entity_Type', ['Product', 'Customer', 'Quotation', 'Sale', 'Supplier'])->nullable();
            $table->unsignedBigInteger('Related_Entity_ID')->nullable();
            $table->foreignId('Uploaded_By')->constrained('users', 'User_ID');
            $table->timestamp('Upload_Date')->useCurrent();
            $table->date('Expiry_Date')->nullable();
            $table->enum('Status', ['Active', 'Expired', 'Archived'])->default('Active');
            $table->integer('Version_Number')->default(1);
            $table->timestamps();
            
            $table->index(['Related_Entity_Type', 'Related_Entity_ID']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};