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
                'Quote', 
                'Invoice', 
                'Receipt', 
                'Contract', 
                'Certificate', 
                'TechnicalSpec', 
                'Identity', 
                'Other'
            ]);
            $table->string('File_Path');
            $table->string('File_Name');
            $table->string('File_Extension', 10)->nullable();
            $table->string('MIME_Type', 100)->nullable();
            $table->integer('File_Size')->nullable();
            $table->enum('Related_Entity_Type', ['Product', 'Quotation', 'Customer', 'User', 'Sale', 'Document'])->nullable();
            $table->unsignedBigInteger('Related_Entity_ID')->nullable();
            $table->foreignId('Uploaded_By')->constrained('users', 'User_ID');
            $table->date('Expiry_Date')->nullable();
            $table->enum('Status', ['Active', 'Expired', 'Archived'])->default('Active');
            $table->integer('Version_Number')->default(1);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['Related_Entity_Type', 'Related_Entity_ID']);
            $table->index('Document_Type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};