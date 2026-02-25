<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id('Rate_ID');
            $table->string('Currency_Pair')->default('USD-PHP');
            $table->decimal('Rate_Value', 8, 4);
            $table->date('Effective_Date')->useCurrent();
            $table->enum('Source', ['BSP', 'Manual', 'API']);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('Effective_Date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};