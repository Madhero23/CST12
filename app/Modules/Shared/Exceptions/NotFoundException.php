<?php

namespace App\Modules\Shared\Exceptions;

/**
 * Exception thrown when a resource is not found
 */
class NotFoundException extends CustomException
{
    public function __construct(
        string $resource = "Resource",
        array $context = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct(
            "{$resource} not found",
            404,
            $context,
            $previous
        );
    }
}
