<?php

namespace App\Modules\Shared\Traits;

/**
 * Input sanitization trait to prevent XSS attacks
 * 
 * This trait provides methods to sanitize user input and prevent
 * cross-site scripting (XSS) attacks throughout the application.
 */
trait SanitizationTrait
{
    /**
     * Sanitize a string to prevent XSS attacks
     *
     * @param string|null $value The value to sanitize
     * @return string|null
     */
    protected function sanitizeString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        // Remove any HTML tags and encode special characters
        return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitize an email address
     *
     * @param string|null $email The email to sanitize
     * @return string|null
     */
    protected function sanitizeEmail(?string $email): ?string
    {
        if ($email === null) {
            return null;
        }

        return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sanitize a phone number (remove non-numeric characters except +)
     *
     * @param string|null $phone The phone number to sanitize
     * @return string|null
     */
    protected function sanitizePhone(?string $phone): ?string
    {
        if ($phone === null) {
            return null;
        }

        // Keep only digits, spaces, hyphens, parentheses, and plus sign
        return preg_replace('/[^\d\s\-\(\)\+]/', '', trim($phone));
    }

    /**
     * Sanitize a URL
     *
     * @param string|null $url The URL to sanitize
     * @return string|null
     */
    protected function sanitizeUrl(?string $url): ?string
    {
        if ($url === null) {
            return null;
        }

        return filter_var(trim($url), FILTER_SANITIZE_URL);
    }

    /**
     * Sanitize an array of values
     *
     * @param array $data The array to sanitize
     * @param array $fields Fields to sanitize (empty array = all fields)
     * @return array
     */
    protected function sanitizeArray(array $data, array $fields = []): array
    {
        $sanitized = [];
        $fieldsToSanitize = empty($fields) ? array_keys($data) : $fields;

        foreach ($data as $key => $value) {
            if (in_array($key, $fieldsToSanitize)) {
                if (is_string($value)) {
                    $sanitized[$key] = $this->sanitizeString($value);
                } elseif (is_array($value)) {
                    $sanitized[$key] = $this->sanitizeArray($value);
                } else {
                    $sanitized[$key] = $value;
                }
            } else {
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }

    /**
     * Sanitize HTML content (allows safe HTML tags)
     *
     * @param string|null $html The HTML content to sanitize
     * @param array $allowedTags Tags to allow (default: basic formatting)
     * @return string|null
     */
    protected function sanitizeHtml(?string $html, array $allowedTags = ['p', 'br', 'strong', 'em', 'u']): ?string
    {
        if ($html === null) {
            return null;
        }

        $allowedTagsString = '<' . implode('><', $allowedTags) . '>';
        return strip_tags($html, $allowedTagsString);
    }

    /**
     * Remove SQL injection attempts from input
     *
     * @param string|null $value The value to sanitize
     * @return string|null
     */
    protected function sanitizeSql(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        // Remove common SQL injection patterns
        $patterns = [
            '/(\bUNION\b|\bSELECT\b|\bINSERT\b|\bUPDATE\b|\bDELETE\b|\bDROP\b|\bCREATE\b|\bALTER\b)/i',
            '/--/',
            '/\/\*.*\*\//',
            '/;/',
        ];

        $cleaned = $value;
        foreach ($patterns as $pattern) {
            $cleaned = preg_replace($pattern, '', $cleaned);
        }

        return trim($cleaned);
    }

    /**
     * Sanitize numeric input
     *
     * @param mixed $value The value to sanitize
     * @return float|int|null
     */
    protected function sanitizeNumeric($value)
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Remove any non-numeric characters except decimal point and minus sign
        $cleaned = preg_replace('/[^\d\.\-]/', '', (string) $value);

        // Check if it's a decimal number
        if (strpos($cleaned, '.') !== false) {
            return (float) $cleaned;
        }

        return (int) $cleaned;
    }

    /**
     * Sanitize boolean input
     *
     * @param mixed $value The value to sanitize
     * @return bool
     */
    protected function sanitizeBoolean($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
