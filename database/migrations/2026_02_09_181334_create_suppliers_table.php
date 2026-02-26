<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id('Supplier_ID');
            $table->string('Supplier_Name');
            $table->string('Contact_Person');
            $table->string('Email');
            $table->string('Phone');
            $table->text('Address');
            $table->string('Country')->default('Philippines');
            $table->string('Specialization')->nullable();
            $table->integer('Years_In_Service')->nullable();
            $table->enum('Status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};