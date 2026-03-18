<?php

namespace App\Modules\Inventory\Services;

use App\Modules\Inventory\Repositories\InventoryRepository;
use App\Modules\Shared\Services\LoggingService;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

class InventoryService
{
    protected InventoryRepository $repository;
    protected LoggingService $logger;

    public function __construct(InventoryRepository $repository, LoggingService $logger)
    {
        $this->repository = $repository;
        $this->logger = $logger;
    }

    /**
     * Get all inventory items with optional filters
     */
    public function getAllInventory(array $filters = []): Collection
    {
        return $this->repository->getAll($filters);
    }

    /**
     * Record Stock In: Increase stock at a specific location
     */
    public function recordStockIn(int $productId, int $locationId, int $quantity, array $metadata = [], ?int $performedBy = null): Inventory
    {
        return DB::transaction(function () use ($productId, $locationId, $quantity, $metadata, $performedBy) {
            // 1. Update Inventory
            $inventory = $this->repository->updateStock($productId, $locationId, $quantity, [
                'shelf' => $metadata['shelf'] ?? null,
                'rack' => $metadata['rack'] ?? null,
                'area' => $metadata['area'] ?? null,
                'batch_number' => $metadata['batch_number'] ?? null,
                'received_date' => $metadata['transaction_date'] ?? now(),
            ]);

            // 2. Log Transaction
            $this->repository->logTransaction([
                'Product_ID' => $productId,
                'Transaction_Type' => 'StockIn',
                'Quantity' => $quantity,
                'Unit_Price_At_Transaction' => $inventory->product->Unit_Price_PHP ?? 0,
                'Total_Value' => ($inventory->product->Unit_Price_PHP ?? 0) * $quantity,
                'Destination_Location_ID' => $locationId,
                'Transaction_Date' => $metadata['transaction_date'] ?? now(),
                'Shelf' => $metadata['shelf'] ?? null,
                'Rack' => $metadata['rack'] ?? null,
                'Area' => $metadata['area'] ?? null,
                'Batch_Number' => $metadata['batch_number'] ?? null,
                'Receiving_Department' => $metadata['receiving_department'] ?? null,
                'Supplier_ID' => $metadata['supplier_id'] ?? null,
                'Notes' => $metadata['notes'] ?? null,
                'Performed_By' => $performedBy,
            ]);

            $this->logger->logActivity('Stock In recorded', null, [
                'product_id' => $productId,
                'location_id' => $locationId,
                'qty' => $quantity,
                'department' => $metadata['receiving_department'] ?? null
            ]);

            return $inventory;
        });
    }

    /**
     * Record Stock Out: Decrease stock at a specific location
     */
    public function recordStockOut(int $productId, int $locationId, int $quantity, $transactionDate = null, ?string $notes = null, ?int $performedBy = null): Inventory
    {
        return DB::transaction(function () use ($productId, $locationId, $quantity, $transactionDate, $notes, $performedBy) {
            $inventory = $this->repository->findByProductAndLocation($productId, $locationId);

            // FR-INV-02: Zero-stock guard
            if (!$inventory || $inventory->Quantity_Available <= 0) {
                $productName = $inventory?->product?->Product_Name ?? \App\Models\Product::find($productId)?->Product_Name ?? 'Unknown';
                throw new Exception("Invalid action: product [{$productName}] has 0 stocks.");
            }

            // FR-INV-03: Insufficient stock guard
            if ($inventory->Quantity_Available < $quantity) {
                throw new Exception("Insufficient stock. Available: {$inventory->Quantity_Available}, Requested: {$quantity}.");
            }

            // FR-INV-04: Reason/notes required for stock out
            if (empty(trim($notes ?? ''))) {
                throw new Exception("A reason (notes) is required for stock out transactions.");
            }

            // 1. Update Inventory (Negative quantity)
            $updatedInventory = $this->repository->updateStock($productId, $locationId, -$quantity);

            // 2. Log Transaction
            $this->repository->logTransaction([
                'Product_ID' => $productId,
                'Transaction_Type' => 'StockOut',
                'Quantity' => $quantity,
                'Unit_Price_At_Transaction' => $inventory->product->Unit_Price_PHP ?? 0,
                'Total_Value' => ($inventory->product->Unit_Price_PHP ?? 0) * $quantity,
                'Source_Location_ID' => $locationId,
                'Notes' => $notes,
                'Performed_By' => $performedBy,
                'Transaction_Date' => $transactionDate ?? now(),
            ]);

            // FR-INV-07: Replenishment alert — check if stock fell below Min_Stock_Level
            $product = $inventory->product;
            if ($product && $updatedInventory->Quantity_On_Hand < ($product->Min_Stock_Level ?? 10)) {
                DB::table('alert_logs')->insert([
                    'Alert_Type' => 'LowStock',
                    'Message' => "Low stock alert: {$product->Product_Name} has {$updatedInventory->Quantity_On_Hand} units remaining (Min: {$product->Min_Stock_Level}). Reorder quantity: {$product->Reorder_Quantity}.",
                    'Related_Entity_Type' => 'Product',
                    'Related_Entity_ID' => $productId,
                    'Severity' => $updatedInventory->Quantity_On_Hand <= 0 ? 'Critical' : 'Warning',
                    'Is_Read' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $this->logger->logWarning('Low stock alert created', [
                    'product_id' => $productId,
                    'current_stock' => $updatedInventory->Quantity_On_Hand,
                    'min_stock_level' => $product->Min_Stock_Level,
                ]);
            }

            $this->logger->logActivity('Stock Out recorded', null, [
                'product_id' => $productId,
                'location_id' => $locationId,
                'qty' => $quantity
            ]);

            return $updatedInventory;
        });
    }

    /**
     * Transfer Stock between locations
     */
    public function transferStock(int $productId, int $fromLocationId, int $toLocationId, int $quantity, $transactionDate = null, ?string $notes = null, ?int $performedBy = null): InventoryTransaction
    {
        return DB::transaction(function () use ($productId, $fromLocationId, $toLocationId, $quantity, $transactionDate, $notes, $performedBy) {
            // 1. Check Source Stock
            $sourceInventory = $this->repository->findByProductAndLocation($productId, $fromLocationId);
            if (!$sourceInventory || $sourceInventory->Quantity_Available < $quantity) {
                throw new Exception("Insufficient stock at the source location.");
            }

            // 2. Decrement Source
            $this->repository->updateStock($productId, $fromLocationId, -$quantity);

            // 3. Increment Destination
            $this->repository->updateStock($productId, $toLocationId, $quantity);

            // 4. Log Transaction (Transfer)
            $transaction = $this->repository->logTransaction([
                'Product_ID' => $productId,
                'Transaction_Type' => 'Transfer',
                'Quantity' => $quantity,
                'Unit_Price_At_Transaction' => $sourceInventory->product->Unit_Price_PHP ?? 0,
                'Total_Value' => ($sourceInventory->product->Unit_Price_PHP ?? 0) * $quantity,
                'Source_Location_ID' => $fromLocationId,
                'Destination_Location_ID' => $toLocationId,
                'Notes' => $notes,
                'Performed_By' => $performedBy,
                'Transaction_Date' => $transactionDate ?? now(),
            ]);

            $this->logger->logActivity('Stock Transfer', null, [
                'product_id' => $productId,
                'from_location' => $fromLocationId,
                'to_location' => $toLocationId,
                'qty' => $quantity
            ]);

            return $transaction;
        });
    }

    /**
     * Get recent transfers (mapped from transactions for now)
     */
    public function getRecentTransfers(): Collection
    {
        return $this->repository->getRecentTransfers();
    }
    
    public function getLowStockItems(): Collection
    {
        return $this->repository->getAll(['low_stock' => true]);
    }

    public function getAgingReport(): Collection
    {
        // Items older than 6 months (Received_Date < now - 6 months)
        return \App\Models\Inventory::with(['product', 'location'])
            ->whereNotNull('Received_Date')
            ->where('Received_Date', '<', now()->subMonths(6))
            ->orderBy('Received_Date', 'asc')
            ->get();
    }

    public function updateLocation(int $productId, int $oldLocationId, int $newLocationId, array $coords, $transactionDate = null, ?int $performedBy = null): Inventory
    {
        return DB::transaction(function () use ($productId, $oldLocationId, $newLocationId, $coords, $transactionDate, $performedBy) {
            $inventory = Inventory::where('Product_ID', $productId)
                ->where('Location_ID', $oldLocationId)
                ->firstOrFail();

            if ($oldLocationId !== $newLocationId) {
                // If location changed, we move the entire quantity to the new record
                $qty = $inventory->Quantity_On_Hand;
                
                // 1. Remove from old
                $inventory->decrement('Quantity_On_Hand', $qty);
                $inventory->Quantity_Available = $inventory->Quantity_On_Hand - $inventory->Quantity_Reserved;
                $inventory->save();

                // 2. Add to new (or create)
                $inventory = $this->repository->updateStock($productId, $newLocationId, $qty, [
                    'shelf' => $coords['shelf'] ?? null,
                    'rack' => $coords['rack'] ?? null,
                    'area' => $coords['area'] ?? null,
                ]);

                // 3. Log as Transfer
                $this->repository->logTransaction([
                    'Product_ID' => $productId,
                    'Transaction_Type' => 'Transfer',
                    'Quantity' => $qty,
                    'Unit_Price_At_Transaction' => $inventory->product->Unit_Price_PHP ?? 0,
                    'Total_Value' => ($inventory->product->Unit_Price_PHP ?? 0) * $qty,
                    'Source_Location_ID' => $oldLocationId,
                    'Destination_Location_ID' => $newLocationId,
                    'Shelf' => $coords['shelf'] ?? null,
                    'Rack' => $coords['rack'] ?? null,
                    'Area' => $coords['area'] ?? null,
                    'Notes' => $coords['notes'] ?? 'Location Updated (Warehouse Change)',
                    'Performed_By' => $performedBy,
                    'Transaction_Date' => $transactionDate ?? now(),
                ]);
            } else {
                // If same location, just update coordinates
                $inventory->Shelf = $coords['shelf'] ?? $inventory->Shelf;
                $inventory->Rack = $coords['rack'] ?? $inventory->Rack;
                $inventory->Area = $coords['area'] ?? $inventory->Area;
                $inventory->save();

                // Log as simple update (Adjustment with 0 qty just for coordinates)
                $this->repository->logTransaction([
                    'Product_ID' => $productId,
                    'Transaction_Type' => 'Adjustment',
                    'Quantity' => 0,
                    'Unit_Price_At_Transaction' => $inventory->product->Unit_Price_PHP ?? 0,
                    'Total_Value' => 0,
                    'Destination_Location_ID' => $newLocationId,
                    'Shelf' => $coords['shelf'] ?? null,
                    'Rack' => $coords['rack'] ?? null,
                    'Area' => $coords['area'] ?? null,
                    'Notes' => $coords['notes'] ?? 'Location coordinates updated',
                    'Performed_By' => $performedBy,
                    'Transaction_Date' => $transactionDate ?? now(),
                ]);
            }

            $this->logger->logActivity('Inventory location updated', null, [
                'product_id' => $productId,
                'old_loc' => $oldLocationId,
                'new_loc' => $newLocationId,
                'shelf' => $coords['shelf'] ?? null
            ]);

            return $inventory;
        });
    }

    public function getScanLogs($date = null): Collection
    {
        return $this->repository->getScanLogs($date);
    }
}
