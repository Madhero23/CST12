<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('Title')->nullable()->after('Quotation_Number');
            $table->text('Additional_Notes')->nullable()->after('Follow_Up_Date');
        });
    }

    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn(['Title', 'Additional_Notes']);
        });
    }
};
