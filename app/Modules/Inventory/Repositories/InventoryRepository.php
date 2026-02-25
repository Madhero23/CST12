<?php

namespace App\Modules\Inventory\Repositories;

use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\StockTransfer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

class InventoryRepository
{
    /**
     * Get all inventory items with optional filters
     */
    public function getAll(array $filters = []): Collection
    {
        $query = Inventory::with(['product', 'location']);

        if (!empty($filters['location_id'])) {
            $query->where('Location_ID', $filters['location_id']);
        }

        if (!empty($filters['product_id'])) {
            $query->where('Product_ID', $filters['product_id']);
        }

        if (!empty($filters['low_stock'])) {
            $query->lowStock();
        }

        return $query->get();
    }

    /**
     * Find specific inventory record by Product and Location
     */
    public function findByProductAndLocation(int $productId, int $locationId): ?Inventory
    {
        return Inventory::where('Product_ID', $productId)
                        ->where('Location_ID', $locationId)
                        ->first();
    }

    /**
     * Create or update inventory record
     */
    public function updateStock(int $productId, int $locationId, int $quantityChange, array $subLocation = []): Inventory
    {
        $inventory = Inventory::firstOrCreate(
            ['Product_ID' => $productId, 'Location_ID' => $locationId],
            [
                'Quantity_On_Hand' => 0,
                'Quantity_Reserved' => 0,
                'Quantity_Available' => 0
            ]
        );

        if (!empty($subLocation['shelf'])) $inventory->Shelf = $subLocation['shelf'];
        if (!empty($subLocation['rack'])) $inventory->Rack = $subLocation['rack'];
        if (!empty($subLocation['area'])) $inventory->Area = $subLocation['area'];
        if (!empty($subLocation['batch_number'])) $inventory->Batch_Number = $subLocation['batch_number'];
        if (!empty($subLocation['received_date'])) $inventory->Received_Date = $subLocation['received_date'];

        $inventory->increment('Quantity_On_Hand', $quantityChange);
        // Available is OnHand - Reserved. For now assuming Reserved is managed separately or 0.
        $inventory->Quantity_Available = $inventory->Quantity_On_Hand - $inventory->Quantity_Reserved;
        $inventory->save();

        return $inventory;
    }

    /**
     * Log an inventory transaction
     */
    public function logTransaction(array $data): InventoryTransaction
    {
        return InventoryTransaction::create($data);
    }

    /**
     * Get recent transactions
     */
    public function getRecentTransactions(int $limit = 10): Collection
    {
        return InventoryTransaction::with(['product', 'sourceLocation', 'destinationLocation', 'performedBy'])
                                   ->latest('Transaction_Date')
                                   ->limit($limit)
                                   ->get();
    }

    /**
     * Get recent stock transfers (legacy support or mapped from transactions)
     * For now, we will fetch 'Transfer' type transactions
     */
    public function getRecentTransfers(int $limit = 5): Collection
    {
        return InventoryTransaction::where('Transaction_Type', 'Transfer')
                                   ->with(['product', 'sourceLocation', 'destinationLocation'])
                                   ->latest('Transaction_Date')
                                   ->limit($limit)
                                   ->get();
    }

    /**
     * Get scan logs (transactions) for a specific date
     */
    public function getScanLogs($date = null): Collection
    {
        $date = $date ?: now()->toDateString();
        
        return InventoryTransaction::with(['product', 'sourceLocation', 'destinationLocation'])
                                   ->whereDate('Transaction_Date', $date)
                                   ->orderBy('Transaction_Date', 'desc')
                                   ->get();
    }
}
