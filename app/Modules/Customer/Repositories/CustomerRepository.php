<?php

namespace App\Modules\Customer\Repositories;

use App\Models\Customer;
use App\Modules\Shared\Exceptions\NotFoundException;
use App\Modules\Shared\Exceptions\DatabaseException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

/**
 * Customer Repository
 * 
 * Handles all database operations for customers
 */
class CustomerRepository
{
    /**
     * Get all customers with optional filters
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     * @throws DatabaseException
     */
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        try {
            $query = Customer::query();

            // Apply filters
            if (!empty($filters['type'])) {
                $query->where('Customer_Type', $filters['type']);
            }

            if (!empty($filters['segment'])) {
                $query->where('Customer_Segment', $filters['segment']);
            }

            if (!empty($filters['status'])) {
                if ($filters['status'] === 'active') {
                    $query->active();
                }
            }

            if (!empty($filters['search'])) {
                $query->where(function ($q) use ($filters) {
                    $q->where('Customer_Name', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('Email', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('Phone_Number', 'like', '%' . $filters['search'] . '%');
                });
            }

            return $query->orderBy('Customer_Name')->paginate($perPage);

        } catch (Throwable $e) {
            throw new DatabaseException('Failed to retrieve customers: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Find a customer by ID
     *
     * @param int $id
     * @return Customer
     * @throws NotFoundException
     * @throws DatabaseException
     */
    public function findOrFail(int $id): Customer
    {
        try {
            $customer = Customer::find($id);

            if (!$customer) {
                throw new NotFoundException("Customer with ID {$id} not found");
            }

            return $customer;

        } catch (NotFoundException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to find customer: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Create a new customer
     *
     * @param array $data
     * @return Customer
     * @throws DatabaseException
     */
    public function create(array $data): Customer
    {
        try {
            return Customer::create($data);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to create customer: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Update a customer
     *
     * @param int $id
     * @param array $data
     * @return Customer
     * @throws NotFoundException
     * @throws DatabaseException
     */
    public function update(int $id, array $data): Customer
    {
        try {
            $customer = $this->findOrFail($id);
            $customer->update($data);
            return $customer->fresh();

        } catch (NotFoundException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to update customer: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Delete a customer
     *
     * @param int $id
     * @return bool
     * @throws NotFoundException
     * @throws DatabaseException
     */
    public function delete(int $id): bool
    {
        try {
            $customer = $this->findOrFail($id);
            return $customer->delete();

        } catch (NotFoundException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to delete customer: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Get customers by type
     *
     * @param string $type
     * @return Collection
     * @throws DatabaseException
     */
    public function getByType(string $type): Collection
    {
        try {
            return Customer::where('Customer_Type', $type)->get();
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to retrieve customers by type: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Get customers by segment
     *
     * @param string $segment
     * @return Collection
     * @throws DatabaseException
     */
    public function getBySegment(string $segment): Collection
    {
        try {
            return Customer::where('Customer_Segment', $segment)->get();
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to retrieve customers by segment: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Get active customers
     *
     * @return Collection
     * @throws DatabaseException
     */
    public function getActive(): Collection
    {
        try {
            return Customer::active()->get();
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to retrieve active customers: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Search customers
     *
     * @param string $term
     * @return Collection
     * @throws DatabaseException
     */
    public function search(string $term): Collection
    {
        try {
            return Customer::where('Customer_Name', 'like', '%' . $term . '%')
                ->orWhere('Email', 'like', '%' . $term . '%')
                ->orWhere('Phone_Number', 'like', '%' . $term . '%')
                ->limit(20)
                ->get();

        } catch (Throwable $e) {
            throw new DatabaseException('Failed to search customers: ' . $e->getMessage(), 0, $e);
        }
    }
}
