<?php

namespace App\Modules\Customer\Services;

use App\Modules\Customer\Repositories\CustomerRepository;
use App\Modules\Shared\Services\LoggingService;
use App\Modules\Shared\Services\ValidationService;
use App\Modules\Shared\Exceptions\NotFoundException;
use App\Modules\Shared\Exceptions\DatabaseException;
use App\Modules\Shared\Exceptions\ValidationException;
use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Customer Service
 * 
 * Business logic layer for customer operations
 */
class CustomerService
{
    protected CustomerRepository $repository;
    protected LoggingService $logger;
    protected ValidationService $validator;

    public function __construct(
        CustomerRepository $repository,
        LoggingService $logger,
        ValidationService $validator
    ) {
        $this->repository = $repository;
        $this->logger = $logger;
        $this->validator = $validator;
    }

    /**
     * Get all customers with filters
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     * @throws DatabaseException
     */
    public function getAllCustomers(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        try {
            return $this->repository->getAll($filters, $perPage);
        } catch (DatabaseException $e) {
            $this->logger->logError($e, 'Failed to get customers');
            throw $e;
        }
    }

    /**
     * Get customer by ID
     *
     * @param int $id
     * @return Customer
     * @throws NotFoundException
     * @throws DatabaseException
     */
    public function getCustomerById(int $id): Customer
    {
        try {
            return $this->repository->findOrFail($id);
        } catch (NotFoundException $e) {
            $this->logger->logWarning('Customer not found', ['customer_id' => $id]);
            throw $e;
        } catch (DatabaseException $e) {
            $this->logger->logError($e, 'Failed to get customer', ['customer_id' => $id]);
            throw $e;
        }
    }

    /**
     * Create a new customer
     *
     * @param array $data
     * @return Customer
     * @throws ValidationException
     * @throws DatabaseException
     */
    public function createCustomer(array $data): Customer
    {
        try {
            // Validate email
            if (!$this->validator->isValidEmail($data['Email'] ?? '')) {
                throw new ValidationException('Invalid email address');
            }

            // Create customer
            $customer = $this->repository->create($data);

            $this->logger->logActivity('Customer created', null, [
                'customer_id' => $customer->Customer_ID,
                'customer_name' => $customer->Customer_Name,
            ]);

            return $customer;

        } catch (ValidationException $e) {
            $this->logger->logWarning('Customer validation failed', ['data' => $data]);
            throw $e;
        } catch (DatabaseException $e) {
            $this->logger->logError($e, 'Failed to create customer');
            throw $e;
        }
    }

    /**
     * Update a customer
     *
     * @param int $id
     * @param array $data
     * @return Customer
     * @throws NotFoundException
     * @throws ValidationException
     * @throws DatabaseException
     */
    public function updateCustomer(int $id, array $data): Customer
    {
        try {
            // Validate email if provided
            if (isset($data['Email']) && !$this->validator->isValidEmail($data['Email'])) {
                throw new ValidationException('Invalid email address');
            }

            $customer = $this->repository->update($id, $data);

            $this->logger->logActivity('Customer updated', null, [
                'customer_id' => $id,
                'updated_fields' => array_keys($data),
            ]);

            return $customer;

        } catch (NotFoundException | ValidationException $e) {
            throw $e;
        } catch (DatabaseException $e) {
            $this->logger->logError($e, 'Failed to update customer', ['customer_id' => $id]);
            throw $e;
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
    public function deleteCustomer(int $id): bool
    {
        try {
            $result = $this->repository->delete($id);

            $this->logger->logActivity('Customer deleted', null, [
                'customer_id' => $id,
            ]);

            return $result;

        } catch (NotFoundException $e) {
            throw $e;
        } catch (DatabaseException $e) {
            $this->logger->logError($e, 'Failed to delete customer', ['customer_id' => $id]);
            throw $e;
        }
    }

    /**
     * Search customers
     *
     * @param string $term
     * @return Collection
     * @throws DatabaseException
     */
    public function searchCustomers(string $term): Collection
    {
        try {
            return $this->repository->search($term);
        } catch (DatabaseException $e) {
            $this->logger->logError($e, 'Failed to search customers', ['search_term' => $term]);
            throw $e;
        }
    }

    /**
     * Get customers by type
     *
     * @param string $type
     * @return Collection
     * @throws DatabaseException
     */
    public function getCustomersByType(string $type): Collection
    {
        try {
            return $this->repository->getByType($type);
        } catch (DatabaseException $e) {
            $this->logger->logError($e, 'Failed to get customers by type', ['type' => $type]);
            throw $e;
        }
    }

    /**
     * Get active customers
     *
     * @return Collection
     * @throws DatabaseException
     */
    public function getActiveCustomers(): Collection
    {
        try {
            return $this->repository->getActive();
        } catch (DatabaseException $e) {
            $this->logger->logError($e, 'Failed to get active customers');
            throw $e;
        }
    }
}
