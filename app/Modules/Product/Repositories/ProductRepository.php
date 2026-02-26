<?php

namespace App\Modules\Product\Repositories;

use App\Models\Product;
use App\Modules\Shared\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Product Repository - Data access layer for product operations
 * 
 * This repository handles all database operations related to products,
 * providing a clean interface for data access.
 */
class ProductRepository
{
    /**
     * Get all products with optional filtering
     *
     * @param array $filters Optional filters (category, status, search)
     * @return Collection
     */
    public function getAll(array $filters = []): Collection
    {
        $query = Product::query()
            ->select('products.*')
            ->leftJoin('inventories', 'products.Product_ID', '=', 'inventories.Product_ID')
            ->selectRaw('SUM(inventories.Quantity_Available) as total_stock')
            ->groupBy('products.Product_ID');

        // Apply category filter
        if (!empty($filters['category'])) {
            $query->where('Category', $filters['category']);
        }

        // Apply search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('Product_Name', 'LIKE', "%{$search}%")
                  ->orWhere('Description', 'LIKE', "%{$search}%");
            });
        }

        // Apply status filter
        if (!empty($filters['status'])) {
            switch ($filters['status']) {
                case 'in-stock':
                    $query->havingRaw('SUM(inventories.Quantity_Available) > 0');
                    break;
                case 'low-stock':
                    $query->havingRaw('SUM(inventories.Quantity_Available) > 0 AND SUM(inventories.Quantity_Available) <= products.Min_Stock_Level');
                    break;
                case 'out-of-stock':
                    $query->havingRaw('SUM(inventories.Quantity_Available) <= 0 OR SUM(inventories.Quantity_Available) IS NULL');
                    break;
            }
        }

        return $query->orderBy('products.created_at', 'desc')->get();
    }

    /**
     * Find a product by ID
     *
     * @param int $id The product ID
     * @return Product
     * @throws NotFoundException
     */
    public function findById(int $id): Product
    {
        $product = Product::find($id);

        if (!$product) {
            throw new NotFoundException('Product', ['id' => $id]);
        }

        return $product;
    }

    /**
     * Find a product by ID or fail
     *
     * @param int $id The product ID
     * @return Product
     * @throws NotFoundException
     */
    public function findOrFail(int $id): Product
    {
        try {
            return Product::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new NotFoundException('Product', ['id' => $id]);
        }
    }

    /**
     * Get products by category
     *
     * @param string $category The category name
     * @return Collection
     */
    public function getByCategory(string $category): Collection
    {
        return Product::where('Category', $category)
            ->orderBy('Product_Name')
            ->get();
    }

    /**
     * Get featured products (high-value or new arrivals)
     *
     * @param int $limit Number of products to return
     * @return Collection
     */
    public function getFeatured(int $limit = 6): Collection
    {
        return Product::where('Unit_Price_PHP', '>', 50000)
            ->orWhere('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get low stock products
     *
     * @return Collection
     */
    public function getLowStock(): Collection
    {
        return Product::whereBetween('Min_Stock_Level', [1, 10])
            ->orderBy('Min_Stock_Level')
            ->get();
    }

    /**
     * Search products by name or description
     *
     * @param string $searchTerm The search term
     * @return Collection
     */
    public function search(string $searchTerm): Collection
    {
        return Product::where('Product_Name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('Description', 'LIKE', "%{$searchTerm}%")
            ->orderBy('Product_Name')
            ->get();
    }

    /**
     * Create a new product
     *
     * @param array $data Product data
     * @return Product
     */
    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            return Product::create($data);
        });
    }

    /**
     * Update a product
     *
     * @param int $id Product ID
     * @param array $data Updated data
     * @return Product
     * @throws NotFoundException
     */
    public function update(int $id, array $data): Product
    {
        return DB::transaction(function () use ($id, $data) {
            $product = $this->findOrFail($id);
            $product->update($data);
            return $product->fresh();
        });
    }

    /**
     * Delete a product
     *
     * @param int $id Product ID
     * @return bool
     * @throws NotFoundException
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $product = $this->findOrFail($id);
            return $product->delete();
        });
    }

    /**
     * Get product count by category
     *
     * @return array
     */
    public function getCountByCategory(): array
    {
        return Product::select('Category', DB::raw('count(*) as count'))
            ->groupBy('Category')
            ->pluck('count', 'Category')
            ->toArray();
    }
}
