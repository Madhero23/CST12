<?php

namespace App\Http\Controllers;

use App\Modules\Inventory\Services\InventoryService;
use App\Modules\Shared\Services\LoggingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Throwable;

class InventoryController extends Controller
{
    protected InventoryService $inventoryService;
    protected LoggingService $logger;

    public function __construct(InventoryService $inventoryService, LoggingService $logger)
    {
        $this->inventoryService = $inventoryService;
        $this->logger = $logger;
    }

    public function index(): View
    {
        try {
            // Fetch Inventory items directly with relationships
            $inventoryItems = $this->inventoryService->getAllInventory();
            $lowStock = $this->inventoryService->getLowStockItems();
            
            // Placeholder/Legacy support for reports until fully implemented
            $agingReport = $this->inventoryService->getAgingReport();
            $scanLogs = $this->inventoryService->getScanLogs();
            
            // Fetch recent transfers
            $transfers = $this->inventoryService->getRecentTransfers();

            // Fetch generic lists for dropdowns
            $products = \App\Models\Product::orderBy('Product_Name')->get();
            $locations = \App\Models\Location::orderBy('Location_Name')->get();
            $suppliers = \App\Models\Supplier::orderBy('Supplier_Name')->get();
            
            return view('inventory.inventory', compact(
                'inventoryItems', 'lowStock', 'agingReport', 
                'transfers', 'products', 'locations', 'suppliers'
            ));
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to load inventory page');
            // Return empty collections on error to prevent view crash
            return view('inventory.inventory', [
                'inventoryItems' => collect([]),
                'lowStock' => collect([]),
                'agingReport' => collect([]),
                'scanLogs' => collect([]),
                'transfers' => collect([]),
                'products' => collect([]),
                'locations' => collect([]),
                'error' => 'Unable to load inventory data.',
            ]);
        }
    }

    public function stockIn(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,Product_ID',
                'quantity' => 'required|integer|min:1',
                'location_id' => 'required|exists:locations,Location_ID',
                'transaction_date' => 'required|date',
                'receiving_department' => 'nullable|string|max:255',
                'shelf' => 'nullable|string|max:100',
                'rack' => 'nullable|string|max:100',
                'area' => 'nullable|string|max:100',
                'batch_number' => 'nullable|string|max:100',
                'supplier_id' => 'nullable|exists:suppliers,Supplier_ID',
                'notes' => 'required|string|min:3', // FR-INV-04: Reason required
            ]);

            $inventory = $this->inventoryService->recordStockIn(
                (int)$validated['product_id'],
                (int)$validated['location_id'],
                (int)$validated['quantity'],
                $validated,
                Auth::id()
            );

            return response()->json([
                'success' => true,
                'message' => 'Stock in recorded successfully',
                'inventory' => $inventory->load(['product', 'location']),
            ]);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to record stock in');
            return response()->json([
                'success' => false,
                'message' => 'Failed to record stock in: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function stockOut(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,Product_ID',
                'quantity' => 'required|integer|min:1',
                'location_id' => 'required|exists:locations,Location_ID',
                'transaction_date' => 'required|date',
                'notes' => 'required|string|min:3',  // FR-INV-04: Reason required
            ]);

            $inventory = $this->inventoryService->recordStockOut(
                (int)$validated['product_id'],
                (int)$validated['location_id'],
                (int)$validated['quantity'],
                $validated['transaction_date'],
                $validated['notes'] ?? null,
                Auth::id()
            );

            return response()->json([
                'success' => true,
                'message' => 'Stock out recorded successfully',
                'inventory' => $inventory->load(['product', 'location']),
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => $e->getMessage(),
            ], 422); // 422 Unprocessable Entity — zero-stock guard / insufficient stock (FR-INV-02)
        }
    }

    public function updateLocation(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,Product_ID',
                'old_location_id' => 'required|exists:locations,Location_ID',
                'location_id' => 'required|exists:locations,Location_ID',
                'shelf' => 'nullable|string|max:100',
                'rack' => 'nullable|string|max:100',
                'area' => 'nullable|string|max:100',
                'transaction_date' => 'required|date',
                'notes' => 'nullable|string',
            ]);

            $inventory = $this->inventoryService->updateLocation(
                (int)$validated['product_id'],
                (int)$validated['old_location_id'],
                (int)$validated['location_id'],
                [
                    'shelf' => $validated['shelf'] ?? null,
                    'rack' => $validated['rack'] ?? null,
                    'area' => $validated['area'] ?? null,
                    'notes' => $validated['notes'] ?? null,
                ],
                $validated['transaction_date'],
                Auth::id()
            );

            return response()->json([
                'success' => true,
                'message' => 'Location updated successfully',
                'inventory' => $inventory->load(['product', 'location']),
            ]);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to update location');
            return response()->json([
                'success' => false,
                'message' => 'Failed to update location: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function createTransfer(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,Product_ID',
                'from_location_id' => 'required|exists:locations,Location_ID',
                'to_location_id' => 'required|exists:locations,Location_ID|different:from_location_id',
                'quantity' => 'required|integer|min:1',
                'transaction_date' => 'required|date',
                'notes' => 'nullable|string',
            ]);

            $transaction = $this->inventoryService->transferStock(
                (int)$validated['product_id'],
                (int)$validated['from_location_id'],
                (int)$validated['to_location_id'],
                (int)$validated['quantity'],
                $validated['transaction_date'],
                $validated['notes'] ?? null,
                Auth::id()
            );

            return response()->json([
                'success' => true,
                'message' => 'Stock transfer completed successfully',
                'transaction' => $transaction->load(['product', 'sourceLocation', 'destinationLocation']),
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function getScanLogs(Request $request): JsonResponse
    {
        try {
            $date = $request->query('date', now()->toDateString());
            $logs = $this->inventoryService->getScanLogs($date);

            return response()->json([
                'success' => true,
                'data' => $logs->map(function ($log) {
                    $time = $log->Transaction_Date ? $log->Transaction_Date->format('h:i A') : 'N/A';
                    $product = $log->product->Product_Name ?? 'Unknown Product';
                    
                    // Logic to determine location based on transaction type
                    $location = 'N/A';
                    if ($log->Transaction_Type === 'StockIn') {
                        $location = $log->destinationLocation->Location_Name ?? 'Unknown Location';
                    } elseif ($log->Transaction_Type === 'StockOut' || $log->Transaction_Type === 'Transfer') {
                        $location = $log->sourceLocation->Location_Name ?? 'Unknown Location';
                    }

                    return [
                        'time' => $time,
                        'product' => $product,
                        'location' => $location,
                        'type' => $log->Transaction_Type,
                        'quantity' => $log->Quantity
                    ];
                })
            ]);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to fetch scan logs');
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch scan logs'
            ], 500);
        }
    }

    /**
     * Complete a transfer (stub — not yet implemented)
     */
    public function completeTransfer(Request $request, int $id): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Transfer completion is not yet implemented.',
        ], 501);
    }

    /**
     * Export scan logs as CSV
     */
    public function exportScanLogCsv(Request $request)
    {
        try {
            $date = $request->query('date', now()->toDateString());
            $logs = $this->inventoryService->getScanLogs($date);
            
            $filename = "scan_{$date}.csv";
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];

            $callback = function() use ($logs) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Time', 'Product', 'Type', 'Location', 'Quantity']);

                foreach ($logs as $log) {
                    $time = $log->Transaction_Date ? $log->Transaction_Date->format('h:i A') : 'N/A';
                    $product = $log->product->Product_Name ?? 'Unknown Product';
                    
                    $location = 'N/A';
                    if ($log->Transaction_Type === 'StockIn') {
                        $location = $log->destinationLocation->Location_Name ?? 'Unknown Location';
                    } elseif ($log->Transaction_Type === 'StockOut' || $log->Transaction_Type === 'Transfer') {
                        $location = $log->sourceLocation->Location_Name ?? 'Unknown Location';
                    }

                    fputcsv($file, [
                        $time,
                        $product,
                        $log->Transaction_Type,
                        $location,
                        $log->Quantity
                    ]);
                }
                fclose($file);
            };

            return response()->streamDownload($callback, $filename, $headers);
            
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Export failed'], 500);
        }
    }

    /**
     * Record a barcode/QR scan (stub — not yet implemented)
     */
    public function recordScan(Request $request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Barcode scanning is not yet implemented.',
        ], 501);
    }
}
