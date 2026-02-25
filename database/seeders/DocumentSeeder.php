<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $documents = [
            [
                'Document_Type' => 'Certificate',
                'File_Path' => 'documents/certificates/fda_patient_monitor.pdf',
                'File_Name' => 'FDA_Certificate_Patient_Monitor.pdf',
                'File_Extension' => 'pdf',
                'MIME_Type' => 'application/pdf',
                'File_Size' => 2457600,
                'Related_Entity_Type' => 'Product',
                'Related_Entity_ID' => 1,
                'Uploaded_By' => 1,
                'Expiry_Date' => $now->addYears(2),
                'Status' => 'Active',
                'Version_Number' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Document_Type' => 'Quote',
                'File_Path' => 'documents/quotations/QT-2024-001.pdf',
                'File_Name' => 'Quotation_MMGH_2024-001.pdf',
                'File_Extension' => 'pdf',
                'MIME_Type' => 'application/pdf',
                'File_Size' => 1048576,
                'Related_Entity_Type' => 'Quotation',
                'Related_Entity_ID' => 1,
                'Uploaded_By' => 2,
                'Status' => 'Active',
                'Version_Number' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Document_Type' => 'Invoice',
                'File_Path' => 'documents/invoices/INV-2023-150.pdf',
                'File_Name' => 'Invoice_StLukes_2023-150.pdf',
                'File_Extension' => 'pdf',
                'MIME_Type' => 'application/pdf',
                'File_Size' => 786432,
                'Related_Entity_Type' => 'Sale',
                'Related_Entity_ID' => 1,
                'Uploaded_By' => 5,
                'Status' => 'Active',
                'Version_Number' => 1,
                'created_at' => $now->subMonths(1),
                'updated_at' => $now,
            ],
            [
                'Document_Type' => 'Receipt',
                'File_Path' => 'documents/receipts/STLUKES-001.pdf',
                'File_Name' => 'Receipt_StLukes_Installment1.pdf',
                'File_Extension' => 'pdf',
                'MIME_Type' => 'application/pdf',
                'File_Size' => 524288,
                'Related_Entity_Type' => 'Sale',
                'Related_Entity_ID' => 1,
                'Uploaded_By' => 5,
                'Status' => 'Active',
                'Version_Number' => 1,
                'created_at' => $now->subMonths(1),
                'updated_at' => $now,
            ],
            [
                'Document_Type' => 'Contract',
                'File_Path' => 'documents/contracts/contract_stlukes.pdf',
                'File_Name' => 'Service_Contract_StLukes_2024.pdf',
                'File_Extension' => 'pdf',
                'MIME_Type' => 'application/pdf',
                'File_Size' => 3145728,
                'Related_Entity_Type' => 'Customer',
                'Related_Entity_ID' => 2,
                'Uploaded_By' => 2,
                'Expiry_Date' => $now->addYears(1),
                'Status' => 'Active',
                'Version_Number' => 1,
                'created_at' => $now->subMonths(1),
                'updated_at' => $now,
            ],
        ];

        foreach ($documents as $document) {
            DB::table('documents')->insert($document);
        }
        $this->command->info('✅ Seeded ' . count($documents) . ' documents');
    }
}