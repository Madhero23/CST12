<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotation_templates', function (Blueprint $table) {
            $table->id('Template_ID');
            $table->string('Template_Name');
            $table->enum('Template_Type', ['Government', 'Private Institution', 'Hospital', 'Standard']);
            $table->string('File_Path')->nullable();
            $table->date('Created_Date')->useCurrent();
            $table->foreignId('Created_By')->nullable()->constrained('users', 'User_ID');
            $table->boolean('Is_Active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_templates');
    }
};