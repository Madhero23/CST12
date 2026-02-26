<?php

namespace App\Modules\Product\Services;

use App\Models\Product;
use App\Modules\Product\Repositories\ProductRepository;
use App\Modules\Shared\Services\LoggingService;
use App\Modules\Shared\Exceptions\NotFoundException;
use App\Modules\Shared\Exceptions\DatabaseException;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

/**
 * Product Service - Business logic layer for product operations
 * 
 * This service handles all business logic related to products,
 * including validation, error handling, and logging.
 */
class ProductService
{
    /**
     * @var ProductRepository
     */
    protected ProductRepository $repository;

    /**
     * @var LoggingService
     */
    protected LoggingService $logger;

    /**
     * Create a new ProductService instance
     *
     * @param ProductRepository $repository
     * @param LoggingService $logger
     */
    public function __construct(ProductRepository $repository, LoggingService $logger)
    {
        $this->repository = $repository;
        $this->logger = $logger;
    }

    /**
     * Get all products with optional filtering
     *
     * @param array $filters Optional filters
     * @return Collection
     * @throws DatabaseException
     */
    public function getAllProducts(array $filters = []): Collection
    {
        try {
            $products = $this->repository->getAll($filters);
            
            $this->logger->logInfo('Products retrieved', [
                'count' => $products->count(),
                'filters' => $filters,
            ]);

            return $products;
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to retrieve products', ['filters' => $filters]);
            throw new DatabaseException('Failed to retrieve products. Please try again later.', 500, [], $e);
        }
    }

    /**
     * Get a single product by ID
     *
     * @param int $id Product ID
     * @return Product
     * @throws NotFoundException
     * @throws DatabaseException
     */
    public function getProductById(int $id): Product
    {
        try {
            $product = $this->repository->findOrFail($id);
            
            $this->logger->logInfo('Product retrieved', [
                'product_id' => $id,
                'product_name' => $product->Product_Name,
            ]);

            return $product;
        } catch (NotFoundException $e) {
            $this->logger->logWarning('Product not found', ['product_id' => $id]);
            throw $e;
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to retrieve product', ['product_id' => $id]);
            throw new DatabaseException('Failed to retrieve product. Please try again later.', 500, [], $e);
        }
    }

    /**
     * Get featured products
     *
     * @param int $limit Number of products to return
     * @return Collection
     * @throws DatabaseException
     */
    public function getFeaturedProducts(int $limit = 6): Collection
    {
        try {
            return $this->repository->getFeatured($limit);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to retrieve featured products');
            throw new DatabaseException('Failed to retrieve featured products.', 500, [], $e);
        }
    }

    /**
     * Search products
     *
     * @param string $searchTerm Search term
     * @return Collection
     * @throws DatabaseException
     */
    public function searchProducts(string $searchTerm): Collection
    {
        try {
            // Sanitize search term
            $cleanTerm = strip_tags(trim($searchTerm));
            
            if (empty($cleanTerm)) {
                return new Collection();
            }

            $results = $this->repository->search($cleanTerm);
            
            $this->logger->logInfo('Product search performed', [
                'search_term' => $cleanTerm,
                'results_count' => $results->count(),
            ]);

            return $results;
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Product search failed', ['search_term' => $searchTerm]);
            throw new DatabaseException('Search failed. Please try again.', 500, [], $e);
        }
    }

    /**
     * Get products by category
     *
     * @param string $category Category name
     * @return Collection
     * @throws DatabaseException
     */
    public function getProductsByCategory(string $category): Collection
    {
        try {
            return $this->repository->getByCategory($category);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to retrieve products by category', ['category' => $category]);
            throw new DatabaseException('Failed to retrieve products.', 500, [], $e);
        }
    }

    /**
     * Get low stock products
     *
     * @return Collection
     * @throws DatabaseException
     */
    public function getLowStockProducts(): Collection
    {
        try {
            return $this->repository->getLowStock();
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to retrieve low stock products');
            throw new DatabaseException('Failed to retrieve low stock products.', 500, [], $e);
        }
    }

    /**
     * Get product statistics by category
     *
     * @return array
     * @throws DatabaseException
     */
    public function getProductStatistics(): array
    {
        try {
            return $this->repository->getCountByCategory();
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to retrieve product statistics');
            throw new DatabaseException('Failed to retrieve statistics.', 500, [], $e);
        }
    }

    /**
     * Create a new product
     *
     * @param array $data Product data
     * @return Product
     * @throws DatabaseException
     */
    public function createProduct(array $data): Product
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($data) {
            try {
                // 1. Calculate Unit_Price_USD if not provided
                if (!isset($data['Unit_Price_USD']) || empty($data['Unit_Price_USD'])) {
                    $rate = \Illuminate\Support\Facades\DB::table('exchange_rates')
                        ->where('Currency_Pair', 'USD-PHP')
                        ->orderBy('Effective_Date', 'desc')
                        ->value('Rate_Value') ?? 57.00; // Default if no rate found
                    
                    $data['Unit_Price_USD'] = round($data['Unit_Price_PHP'] / $rate, 2);
                }

                // 2. Set default status and code if missing
                $data['Status'] = $data['Status'] ?? 'Active';
                if (!isset($data['Product_Code']) || empty($data['Product_Code'])) {
                    $data['Product_Code'] = 'PRD-' . strtoupper(\Illuminate\Support\Str::random(8));
                }

                // 3. Create the product
                $product = $this->repository->create($data);

                // 4. Initialize Inventory at Main Warehouse (ID: 1)
                $stockQuantity = $data['Stock_Quantity'] ?? 0;
                \Illuminate\Support\Facades\DB::table('inventories')->insert([
                    'Product_ID' => $product->Product_ID,
                    'Location_ID' => 1, // Main Office & Warehouse - Manila
                    'Quantity_On_Hand' => $stockQuantity,
                    'Quantity_Available' => $stockQuantity,
                    'Value_PHP' => $stockQuantity * $product->Unit_Price_PHP,
                    'Value_USD' => $stockQuantity * $product->Unit_Price_USD,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // 5. Log Inventory Transaction
                \Illuminate\Support\Facades\DB::table('inventory_transactions')->insert([
                    'Transaction_Type' => 'StockIn',
                    'Product_ID' => $product->Product_ID,
                    'Quantity' => $stockQuantity,
                    'Transaction_Date' => now(),
                    'Reference_Number' => 'INITIAL-STOCK',
                    'Unit_Price_At_Transaction' => $product->Unit_Price_PHP,
                    'Total_Value' => $stockQuantity * $product->Unit_Price_PHP,
                    'Destination_Location_ID' => 1,
                    'Notes' => 'Initial stock on product creation',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                $this->logger->logActivity('Product created with initial stock', null, [
                    'product_id' => $product->Product_ID,
                    'product_name' => $product->Product_Name,
                    'initial_stock' => $stockQuantity,
                ]);

                return $product;
            } catch (Throwable $e) {
                $this->logger->logError($e, 'Failed to create product in transaction', ['data' => $data]);
                throw new DatabaseException('Failed to create product. Please try again.', 500, [], $e);
            }
        });
    }

    /**
     * Update an existing product
     *
     * @param int $id Product ID
     * @param array $data Updated data
     * @return Product
     * @throws NotFoundException
     * @throws DatabaseException
     */
    public function updateProduct(int $id, array $data): Product
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($id, $data) {
            try {
                // 1. Get current product state
                $product = $this->repository->findOrFail($id);

                // 2. Recalculate Unit_Price_USD if PHP price changed
                if (isset($data['Unit_Price_PHP']) && $data['Unit_Price_PHP'] != $product->Unit_Price_PHP) {
                    $rate = \Illuminate\Support\Facades\DB::table('exchange_rates')
                        ->where('Currency_Pair', 'USD-PHP')
                        ->orderBy('Effective_Date', 'desc')
                        ->value('Rate_Value') ?? 57.00;
                    
                    $data['Unit_Price_USD'] = round($data['Unit_Price_PHP'] / $rate, 2);
                }

                // 3. Update the product record
                $product = $this->repository->update($id, $data);

                // 4. Update Inventory if Stock_Quantity provided
                if (isset($data['Stock_Quantity'])) {
                    $newQuantity = $data['Stock_Quantity'];
                    
                    // Fetch current inventory record for Main Warehouse (Location 1)
                    $inventory = \Illuminate\Support\Facades\DB::table('inventories')
                        ->where('Product_ID', $id)
                        ->where('Location_ID', 1)
                        ->first();

                    if ($inventory) {
                        $oldQuantity = $inventory->Quantity_On_Hand;
                        $diff = $newQuantity - $oldQuantity;

                        if ($diff != 0) {
                            \Illuminate\Support\Facades\DB::table('inventories')
                                ->where('Inventory_ID', $inventory->Inventory_ID)
                                ->update([
                                    'Quantity_On_Hand' => $newQuantity,
                                    'Quantity_Available' => $newQuantity, // Simplified for now
                                    'Value_PHP' => $newQuantity * $product->Unit_Price_PHP,
                                    'Value_USD' => $newQuantity * $product->Unit_Price_USD,
                                    'updated_at' => now(),
                                ]);

                            // Log Transaction for Adjustment
                            \Illuminate\Support\Facades\DB::table('inventory_transactions')->insert([
                                'Transaction_Type' => 'Adjustment',
                                'Product_ID' => $id,
                                'Quantity' => abs($diff),
                                'Transaction_Date' => now(),
                                'Reference_Number' => 'MANUAL-EDIT',
                                'Unit_Price_At_Transaction' => $product->Unit_Price_PHP,
                                'Total_Value' => abs($diff) * $product->Unit_Price_PHP,
                                'Destination_Location_ID' => 1,
                                'Notes' => 'Stock adjusted via Product Edit modal. Direction: ' . ($diff > 0 ? 'Increase' : 'Decrease'),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    } else {
                        // Create inventory if missing for some reason
                        \Illuminate\Support\Facades\DB::table('inventories')->insert([
                            'Product_ID' => $id,
                            'Location_ID' => 1,
                            'Quantity_On_Hand' => $newQuantity,
                            'Quantity_Available' => $newQuantity,
                            'Value_PHP' => $newQuantity * $product->Unit_Price_PHP,
                            'Value_USD' => $newQuantity * $product->Unit_Price_USD,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
                
                $this->logger->logActivity('Product updated', null, [
                    'product_id' => $id,
                    'product_name' => $product->Product_Name,
                ]);

                return $product;
            } catch (NotFoundException $e) {
                throw $e;
            } catch (Throwable $e) {
                $this->logger->logError($e, 'Failed to update product in transaction', ['product_id' => $id, 'data' => $data]);
                throw new DatabaseException('Failed to update product. Please try again.', 500, [], $e);
            }
        });
    }

    /**
     * Delete a product
     *
     * @param int $id Product ID
     * @return bool
     * @throws NotFoundException
     * @throws DatabaseException
     */
    public function deleteProduct(int $id): bool
    {
        try {
            $result = $this->repository->delete($id);
            
            $this->logger->logActivity('Product deleted', null, [
                'product_id' => $id,
            ]);

            return $result;
        } catch (NotFoundException $e) {
            $this->logger->logWarning('Product not found for deletion', ['product_id' => $id]);
            throw $e;
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to delete product', ['product_id' => $id]);
            throw new DatabaseException('Failed to delete product.', 500, [], $e);
        }
    }
}
