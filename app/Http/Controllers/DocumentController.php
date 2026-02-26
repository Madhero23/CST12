<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Quotation;
use App\Models\QuotationLineItem;
use App\Modules\Shared\Services\LoggingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Throwable;

class DocumentController extends Controller
{
    protected LoggingService $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }
    public function index(): View
    {
        try {
            $documents = Document::with(['uploader'])->latest()->get();
            $customers = \App\Models\Customer::orderBy('Institution_Name')->get();
            
            // Eager load everything needed for the UI
            $quotations = \App\Models\Quotation::with(['customer', 'creator', 'lineItems.product'])
                ->latest()
                ->get();
                
            $products = \App\Models\Product::orderBy('Product_Name')->get();
            
            // Calculate stats for the grid
            $stats = [
                'active' => $quotations->whereIn('Status', ['Pending', 'Sent', 'Draft'])->count(),
                'templates' => 3, // Placeholder matching reference image
                'certificates' => $documents->where('Document_Type', 'Certificate')->count(),
                'avgDays' => 8.4 // Placeholder matching reference image
            ];
            
            $templates = \App\Models\QuotationTemplate::where('Is_Active', true)->get();
            $sales = \App\Models\Sale::with(['customer'])->latest()->get();
            
            return view('document.document', compact('documents', 'customers', 'quotations', 'products', 'stats', 'templates', 'sales'));
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to load documents page');
            return view('document.document', [
                'documents' => collect([]),
                'quotations' => collect([]),
                'customers' => collect([]),
                'products' => collect([]),
                'sales' => collect([]),
                'error' => 'Unable to load documents.',
            ]);
        }
    }

    public function upload(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'related_type'  => 'nullable|string|in:Customer,Product,Quotation,Sale',
                'related_id'    => 'nullable|integer',
                'document_type' => 'required|string',
                'file'          => 'required|file|max:10240',
                'expiry_date'   => 'nullable|date',
                'document_name' => 'nullable|string',
                'additional_notes' => 'nullable|string',
            ]);

            $file = $request->file('file');
            $path = $file->store('documents', 'public');

            $document = Document::create([
                'Document_Type'       => $validated['document_type'],
                'File_Path'           => $path,
                'File_Name'           => $validated['document_name'] ?? $file->getClientOriginalName(),
                'File_Extension'      => $file->getClientOriginalExtension(),
                'MIME_Type'           => $file->getMimeType(),
                'File_Size'           => $file->getSize(),
                'Related_Entity_Type' => $validated['related_type'] ?? null,
                'Related_Entity_ID'   => $validated['related_id'] ?? null,
                'Uploaded_By'         => auth()->id() ?? 1,
                'Expiry_Date'         => $validated['expiry_date'] ?? null,
                'Status'              => 'Active',
                'Version_Number'      => 1,
                'Additional_Notes'    => $validated['additional_notes'] ?? null,
            ]);

            $this->logger->logActivity('Document uploaded', null, [
                'document_id' => $document->Document_ID,
                'file_name'   => $document->File_Name,
                'type'        => $document->Document_Type,
            ]);

            return response()->json(['success' => true, 'document' => $document], 201);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to upload document');
            return response()->json(['success' => false, 'message' => 'Failed to upload document: ' . $e->getMessage()], 500);
        }
    }

    public function download(int $id)
    {
        try {
            $document = Document::findOrFail($id);

            $this->logger->logActivity('Document downloaded', null, [
                'document_id' => $document->Document_ID,
                'file_name'   => $document->File_Name,
            ]);

            return response()->download(
                Storage::disk('public')->path($document->File_Path),
                $document->File_Name
            );
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to download document', ['document_id' => $id]);
            abort(404);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $document = Document::findOrFail($id);
            $fileName = $document->File_Name;
            Storage::disk('public')->delete($document->File_Path);
            $document->delete();

            $this->logger->logActivity('Document deleted', null, [
                'document_id' => $id,
                'file_name'   => $fileName,
            ]);

            return response()->json(['success' => true, 'message' => 'Document deleted']);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to delete document', ['document_id' => $id]);
            return response()->json(['success' => false, 'message' => 'Failed to delete document'], 500);
        }
    }

    public function reviseQuotation(Request $request, int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $oldQuote = Quotation::with('lineItems')->findOrFail($id);
            
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'expiration_date' => 'nullable|date',
                'change_type' => 'nullable|string|max:255',
                'new_unit_price' => 'nullable|numeric|min:0',
                'new_quantity' => 'nullable|integer|min:1',
                'revision_notes' => 'nullable|string',
            ]);

            // Create new version
            $newQuote = $oldQuote->replicate();
            $newQuote->Version_Number = $oldQuote->Version_Number + 1;
            $newQuote->Parent_Quotation_ID = $oldQuote->Quotation_ID;
            $newQuote->Status = 'Draft';
            
            // Append version suffix to ensure uniqueness (e.g., QT-2026-0003-V2)
            $baseNumber = preg_replace('/-V\d+$/', '', $oldQuote->Quotation_Number);
            $newQuote->Quotation_Number = $baseNumber . '-V' . $newQuote->Version_Number;
            
            if ($validated['title'] ?? null) {
                $newQuote->Title = $validated['title'];
            }
            
            if ($validated['expiration_date'] ?? null) {
                $newQuote->Expiration_Date = $validated['expiration_date'];
            }
            
            // Store revision context in Additional_Notes
            $notesArr = [];
            if ($validated['change_type'] ?? null) $notesArr[] = "Change Type: " . $validated['change_type'];
            if ($validated['revision_notes'] ?? null) $notesArr[] = "Notes: " . $validated['revision_notes'];
            $newQuote->Additional_Notes = implode("\n", $notesArr);
            
            $newQuote->save();

            // Copy line items with optional overrides
            $subtotalUSD = 0;
            foreach ($oldQuote->lineItems as $index => $item) {
                $newItem = $item->replicate();
                $newItem->Quotation_ID = $newQuote->Quotation_ID;
                
                // For the first item, apply overrides if provided
                if ($index === 0) {
                    if ($validated['new_unit_price'] ?? null) {
                        $newItem->Unit_Price = $validated['new_unit_price'];
                    }
                    if ($validated['new_quantity'] ?? null) {
                        $newItem->Quantity = $validated['new_quantity'];
                    }
                    $newItem->Line_Total = $newItem->Unit_Price * $newItem->Quantity;
                }
                
                $newItem->save();
                $subtotalUSD += $newItem->Line_Total;
            }

            // Recalculate Totals for the new quote (VAT Inclusive 12%)
        $rate = 56.00; // Consistent with createQuotation
        $taxRate = $newQuote->Tax_Rate ?? 12.00;
        
        $totalUSD = $subtotalUSD; // In this context, $subtotalUSD is the sum of Line_Totals
        $totalPHP = $totalUSD * $rate;

        $subtotalAmountUSD = $totalUSD / (1 + ($taxRate / 100));
        $subtotalAmountPHP = $totalPHP / (1 + ($taxRate / 100));
        
        $newQuote->Subtotal_Amount_USD = $subtotalAmountUSD;
        $newQuote->Subtotal_Amount_PHP = $subtotalAmountPHP;
        $newQuote->Tax_Amount_USD = $totalUSD - $subtotalAmountUSD;
        $newQuote->Tax_Amount_PHP = $totalPHP - $subtotalAmountPHP;
        $newQuote->Total_Amount_USD = $totalUSD;
        $newQuote->Total_Amount_PHP = $totalPHP;
        $newQuote->Is_Tax_Inclusive = true;
        $newQuote->save();

            DB::commit();

            $this->logger->logActivity('Quotation revised', null, [
                'old_id' => $id,
                'new_id' => $newQuote->Quotation_ID,
                'version' => $newQuote->Version_Number
            ]);

            return response()->json(['success' => true, 'quotation' => $newQuote]);
        } catch (Throwable $e) {
            DB::rollBack();
            $this->logger->logError($e, 'Failed to revise quotation', ['id' => $id]);
            return response()->json(['success' => false, 'message' => 'Revision failed: ' . $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:Draft,Sent,Pending,Approved,Won,Lost',
                'status_notes' => 'nullable|string'
            ]);

            $quote = Quotation::findOrFail($id);
            $quote->Status = $validated['status'];
            $quote->Status_Notes = $validated['status_notes'] ?? null;
            $quote->save();

            $this->logger->logActivity('Quotation status updated', null, [
                'id' => $id,
                'status' => $quote->Status
            ]);

            return response()->json(['success' => true, 'status' => $quote->Status]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Update failed'], 500);
        }
    }

    public function saveTemplate(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'template_id'      => 'nullable|numeric',
                'template_name'    => 'required|string|max:255',
                'template_type'    => 'required|in:Standard,Hospital,Government,PrivateInstitution',
                'customer_segment' => 'nullable|string|max:255',
                'header_text'      => 'nullable|string',
                'footer_text'      => 'nullable|string',
                'terms_conditions' => 'nullable|string',
                'branding_color'   => 'nullable|string|max:7',
            ]);

            $template = \App\Models\QuotationTemplate::updateOrCreate(
                ['Template_ID' => $request->template_id],
                [
                    'Template_Name'    => $validated['template_name'],
                    'Template_Type'    => $validated['template_type'],
                    'Customer_Segment' => $validated['customer_segment'] ?? null,
                    'Header_Text'      => $validated['header_text'] ?? null,
                    'Footer_Text'      => $validated['footer_text'] ?? null,
                    'Terms_Conditions' => $validated['terms_conditions'] ?? null,
                    'Branding_Color'   => $validated['branding_color'] ?? '#14B8A6',
                    'Created_By'       => auth()->id() ?? 1,
                    'Is_Active'        => true,
                ]
            );

            return response()->json([
                'success' => true, 
                'template' => $template,
                'message' => 'Template saved successfully'
            ]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Failed to save template: ' . $e->getMessage()], 500);
        }
    }

    public function deleteTemplate(int $id): JsonResponse
    {
        try {
            \App\Models\QuotationTemplate::findOrFail($id)->delete();
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete template'], 500);
        }
    }
}
