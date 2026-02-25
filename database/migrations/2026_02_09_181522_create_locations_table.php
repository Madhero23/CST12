<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id('Location_ID');
            $table->string('Location_Name');
            $table->text('Address');
            $table->string('Contact_Number');
            $table->enum('Status', ['Active', 'Inactive', 'UnderMaintenance'])->default('Active');
            $table->foreignId('Manager_ID')->nullable()->constrained('users', 'User_ID');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};