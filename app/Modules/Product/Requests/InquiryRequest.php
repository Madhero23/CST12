<?php

namespace App\Modules\Product\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form request validation for product inquiries
 * 
 * This request handles validation and sanitization of contact form submissions.
 */
class InquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-\.]+$/', // Only letters, spaces, hyphens, and dots
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\d\s\-\(\)\+]+$/', // Phone number format
            ],
            'company' => [
                'nullable',
                'string',
                'max:255',
            ],
            'subject' => [
                'required',
                'string',
                'max:255',
            ],
            'message' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
            'product_id' => [
                'nullable',
                'integer',
                'exists:products,Product_ID',
            ],
            'product_name' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    /**
     * Get custom validation messages
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your full name.',
            'name.regex' => 'Name can only contain letters, spaces, hyphens, and dots.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.regex' => 'Please enter a valid phone number.',
            'subject.required' => 'Please enter a subject for your inquiry.',
            'message.required' => 'Please enter your message.',
            'message.min' => 'Message must be at least 10 characters long.',
            'message.max' => 'Message cannot exceed 2000 characters.',
            'product_id.exists' => 'The selected product does not exist.',
        ];
    }

    /**
     * Prepare the data for validation
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // Sanitize inputs before validation
        $this->merge([
            'name' => $this->sanitizeString($this->name),
            'email' => $this->sanitizeEmail($this->email),
            'phone' => $this->sanitizePhone($this->phone),
            'company' => $this->sanitizeString($this->company),
            'subject' => $this->sanitizeString($this->subject),
            'message' => $this->sanitizeString($this->message),
            'product_name' => $this->sanitizeString($this->product_name),
        ]);
    }

    /**
     * Sanitize string input
     *
     * @param string|null $value
     * @return string|null
     */
    protected function sanitizeString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitize email input
     *
     * @param string|null $email
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
     * Sanitize phone input
     *
     * @param string|null $phone
     * @return string|null
     */
    protected function sanitizePhone(?string $phone): ?string
    {
        if ($phone === null) {
            return null;
        }

        return preg_replace('/[^\d\s\-\(\)\+]/', '', trim($phone));
    }
}
