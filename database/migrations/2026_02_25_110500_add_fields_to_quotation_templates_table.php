<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotation_templates', function (Blueprint $table) {
            $table->string('Customer_Segment')->nullable()->after('Template_Type');
            $table->text('Header_Text')->nullable()->after('File_Path');
            $table->text('Footer_Text')->nullable()->after('Header_Text');
            $table->text('Terms_Conditions')->nullable()->after('Footer_Text');
            $table->string('Branding_Color')->nullable()->after('Terms_Conditions');
        });
    }

    public function down(): void
    {
        Schema::table('quotation_templates', function (Blueprint $table) {
            $table->dropColumn(['Customer_Segment', 'Header_Text', 'Footer_Text', 'Terms_Conditions', 'Branding_Color']);
        });
    }
};
