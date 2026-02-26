<?php

namespace App\Modules\Shared\Services;

use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Centralized logging service for consistent error and activity logging
 * 
 * This service provides a unified interface for logging throughout the application,
 * ensuring consistent log formatting and proper error tracking.
 */
class LoggingService
{
    /**
     * Log an error with context information
     *
     * @param Throwable $exception The exception to log
     * @param string $context Additional context about where the error occurred
     * @param array $data Additional data to include in the log
     * @return void
     */
    public function logError(Throwable $exception, string $context = '', array $data = []): void
    {
        Log::error($context ?: 'Application Error', [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
            'data' => $data,
        ]);
    }

    /**
     * Log an informational message
     *
     * @param string $message The message to log
     * @param array $data Additional data to include
     * @return void
     */
    public function logInfo(string $message, array $data = []): void
    {
        Log::info($message, $data);
    }

    /**
     * Log a warning message
     *
     * @param string $message The warning message
     * @param array $data Additional data to include
     * @return void
     */
    public function logWarning(string $message, array $data = []): void
    {
        Log::warning($message, $data);
    }

    /**
     * Log a successful operation
     *
     * @param string $operation The operation that succeeded
     * @param array $data Additional data to include
     * @return void
     */
    public function logSuccess(string $operation, array $data = []): void
    {
        Log::info("Success: {$operation}", $data);
    }

    /**
     * Log a database query for debugging
     *
     * @param string $query The SQL query
     * @param array $bindings The query bindings
     * @return void
     */
    public function logQuery(string $query, array $bindings = []): void
    {
        if (config('app.debug')) {
            Log::debug('Database Query', [
                'query' => $query,
                'bindings' => $bindings,
            ]);
        }
    }

    /**
     * Log user activity
     *
     * @param string $action The action performed
     * @param int|null $userId The user ID who performed the action
     * @param array $data Additional data about the action
     * @return void
     */
    public function logActivity(string $action, ?int $userId = null, array $data = []): void
    {
        Log::info("User Activity: {$action}", [
            'user_id' => $userId,
            'data' => $data,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
