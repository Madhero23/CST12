<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('Product_ID');
            $table->string('Product_Name');
            $table->text('Description')->nullable();
            $table->enum('Category', [
                'Hospital Equipment', 
                'Pharmacy Supplies', 
                'Nursing Items', 
                'EMS Equipment', 
                'Laboratory Equipment', 
                'Dental Equipment'
            ]);
            $table->json('Specifications')->nullable();
            $table->string('Images_Path')->nullable();
            $table->decimal('Unit_Price_PHP', 10, 2);
            $table->decimal('Unit_Price_USD', 10, 2);
            $table->integer('Min_Stock_Level')->default(10);
            $table->integer('Reorder_Quantity')->default(25);
            $table->enum('FDA_Certification_Status', ['Certified', 'Pending', 'Not Required', 'Expired'])->nullable();
            $table->foreignId('Supplier_ID')->nullable()->constrained('suppliers', 'Supplier_ID');
            $table->date('Created_Date')->useCurrent();
            $table->timestamp('Last_Updated')->useCurrent();
            $table->timestamps();
            
            $table->index('Category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};