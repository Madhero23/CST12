<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuotationTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $templates = [
            [
                'Template_Name' => 'Government Bid Format',
                'Template_Type' => 'Government',
                'File_Path' => 'templates/government_bid.docx',
                'Created_By' => 1,
                'Is_Active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Template_Name' => 'Hospital Quotation Template',
                'Template_Type' => 'Hospital',
                'File_Path' => 'templates/hospital_standard.docx',
                'Created_By' => 2,
                'Is_Active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Template_Name' => 'Private Institution Standard',
                'Template_Type' => 'PrivateInstitution',
                'File_Path' => 'templates/private_institution.docx',
                'Created_By' => 1,
                'Is_Active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Template_Name' => 'Standard Quick Quote',
                'Template_Type' => 'Standard',
                'File_Path' => 'templates/quick_quote.docx',
                'Created_By' => 3,
                'Is_Active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('quotation_templates')->insert($templates);
        $this->command->info('✅ Seeded ' . count($templates) . ' quotation templates');
    }
}