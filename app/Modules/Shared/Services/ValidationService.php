<?php

namespace App\Modules\Shared\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Reusable validation service for common validation patterns
 * 
 * This service provides centralized validation methods to ensure
 * consistent validation rules across the application.
 */
class ValidationService
{
    /**
     * Validate email format
     *
     * @param string $email The email to validate
     * @return bool
     */
    public function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate phone number format (supports international formats)
     *
     * @param string $phone The phone number to validate
     * @return bool
     */
    public function isValidPhone(string $phone): bool
    {
        // Remove common separators
        $cleaned = preg_replace('/[\s\-\(\)\.]+/', '', $phone);
        
        // Check if it's a valid phone number (10-15 digits, optional + prefix)
        return preg_match('/^\+?[1-9]\d{9,14}$/', $cleaned) === 1;
    }

    /**
     * Validate that a string is not empty or just whitespace
     *
     * @param string|null $value The value to validate
     * @return bool
     */
    public function isNotEmpty(?string $value): bool
    {
        return !empty(trim($value ?? ''));
    }

    /**
     * Validate numeric value within range
     *
     * @param mixed $value The value to validate
     * @param float $min Minimum value
     * @param float|null $max Maximum value (null for no max)
     * @return bool
     */
    public function isNumericInRange($value, float $min, ?float $max = null): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        $numValue = (float) $value;
        
        if ($numValue < $min) {
            return false;
        }

        if ($max !== null && $numValue > $max) {
            return false;
        }

        return true;
    }

    /**
     * Validate date format
     *
     * @param string $date The date string to validate
     * @param string $format The expected format (default: Y-m-d)
     * @return bool
     */
    public function isValidDate(string $date, string $format = 'Y-m-d'): bool
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    /**
     * Validate that a value exists in an array of allowed values
     *
     * @param mixed $value The value to check
     * @param array $allowedValues Array of allowed values
     * @return bool
     */
    public function isInArray($value, array $allowedValues): bool
    {
        return in_array($value, $allowedValues, true);
    }

    /**
     * Validate string length
     *
     * @param string $value The string to validate
     * @param int $min Minimum length
     * @param int|null $max Maximum length (null for no max)
     * @return bool
     */
    public function isValidLength(string $value, int $min, ?int $max = null): bool
    {
        $length = mb_strlen($value);
        
        if ($length < $min) {
            return false;
        }

        if ($max !== null && $length > $max) {
            return false;
        }

        return true;
    }

    /**
     * Validate password strength
     *
     * @param string $password The password to validate
     * @param int $minLength Minimum length (default: 8)
     * @return array Returns ['valid' => bool, 'errors' => array]
     */
    public function validatePasswordStrength(string $password, int $minLength = 8): array
    {
        $errors = [];

        if (strlen($password) < $minLength) {
            $errors[] = "Password must be at least {$minLength} characters long";
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter";
        }

        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Password must contain at least one lowercase letter";
        }

        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = "Password must contain at least one number";
        }

        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = "Password must contain at least one special character";
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }

    /**
     * Sanitize and validate input data
     *
     * @param array $data The data to validate
     * @param array $rules Laravel validation rules
     * @return array The validated data
     * @throws ValidationException
     */
    public function validateData(array $data, array $rules): array
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
