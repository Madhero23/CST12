<?php

namespace App\Modules\Shared\Exceptions;

use Exception;

/**
 * Base custom exception class for application-specific exceptions
 */
class CustomException extends Exception
{
    /**
     * Additional context data for the exception
     *
     * @var array
     */
    protected array $context = [];

    /**
     * Create a new custom exception instance
     *
     * @param string $message The exception message
     * @param int $code The exception code
     * @param array $context Additional context data
     * @param \Throwable|null $previous Previous exception
     */
    public function __construct(
        string $message = "",
        int $code = 0,
        array $context = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }

    /**
     * Get the exception context data
     *
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Set additional context data
     *
     * @param array $context
     * @return self
     */
    public function setContext(array $context): self
    {
        $this->context = $context;
        return $this;
    }
}
