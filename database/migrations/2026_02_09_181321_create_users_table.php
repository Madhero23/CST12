<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('User_ID');
            $table->string('Username')->unique();
            $table->string('Email')->unique();
            $table->string('Password_Hash');
            $table->enum('Role', ['Admin', 'SalesStaff', 'FinanceStaff', 'InventoryManager', 'SystemAdmin']);
            $table->string('Full_Name');
            $table->string('Phone');
            $table->string('Department');
            $table->timestamp('Last_Login')->nullable();
            $table->enum('Status', ['Active', 'Inactive', 'Suspended'])->default('Active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};