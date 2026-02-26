<?php

namespace App\Modules\Finance\Repositories;

use App\Models\Transaction;
use App\Modules\Shared\Exceptions\NotFoundException;
use App\Modules\Shared\Exceptions\DatabaseException;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class TransactionRepository
{
    public function getAll(array $filters = []): Collection
    {
        try {
            $query = Transaction::query();

            if (!empty($filters['customer_id'])) {
                $query->where('customer_id', $filters['customer_id']);
            }

            if (!empty($filters['type'])) {
                $query->where('type', $filters['type']);
            }

            if (!empty($filters['status'])) {
                $query->where('status', $filters['status']);
            }

            return $query->orderBy('transaction_date', 'desc')->get();
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to retrieve transactions: ' . $e->getMessage(), 0, $e);
        }
    }

    public function create(array $data): Transaction
    {
        try {
            return Transaction::create($data);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to create transaction: ' . $e->getMessage(), 0, $e);
        }
    }

    public function findOrFail(int $id): Transaction
    {
        try {
            $transaction = Transaction::find($id);
            if (!$transaction) {
                throw new NotFoundException("Transaction with ID {$id} not found");
            }
            return $transaction;
        } catch (NotFoundException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to find transaction: ' . $e->getMessage(), 0, $e);
        }
    }
}
