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
            $table->string('Product_Code')->unique()->nullable();
            $table->string('Product_Name');
            $table->text('Description')->nullable();

            $table->enum('Category', [
                'DiagnosticEquipment',
                'MedicalInstruments',
                'MonitoringDevices',
                'EmergencyEquipment',
                'InfusionSystems',
                'LaboratoryEquipment'
            ]);

            $table->json('Specifications')->nullable();
            $table->string('Images_Path')->nullable();
            $table->decimal('Unit_Price_PHP', 10, 2);
            $table->decimal('Unit_Price_USD', 10, 2);
            $table->integer('Min_Stock_Level')->default(10);
            $table->integer('Reorder_Quantity')->default(25);

            $table->enum('Status', ['Active', 'Inactive', 'Discontinued'])->default('Active');
            $table->enum('FDA_Certification_Status', ['Certified', 'Pending', 'NotRequired', 'Expired'])->nullable();

            $table->integer('Warranty_Months')->nullable();
            $table->text('Warranty_Terms')->nullable();
            $table->decimal('Weight_KG', 8, 2)->nullable();
            $table->decimal('Length_CM', 8, 2)->nullable();
            $table->decimal('Width_CM', 8, 2)->nullable();
            $table->decimal('Height_CM', 8, 2)->nullable();

            $table->foreignId('Supplier_ID')->nullable()->constrained('suppliers', 'Supplier_ID');
            $table->timestamps();
            $table->softDeletes();

            $table->index('Category');
            $table->index('Status');
            $table->index('Product_Code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};