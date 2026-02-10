<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('User_ID');  // Primary key
            $table->string('Username')->unique();
            $table->string('Password_Hash');
            $table->enum('Role', ['Admin', 'Sales Staff', 'Finance Staff', 'Inventory Manager', 'System Admin']);
            $table->string('Full_Name');
            $table->string('Email');
            $table->string('Phone');
            $table->string('Department');
            $table->timestamp('Last_Login')->nullable();
            $table->enum('Status', ['Active', 'Inactive', 'Suspended'])->default('Active');
            $table->date('Created_Date')->useCurrent();
            $table->timestamps(); // Creates created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};