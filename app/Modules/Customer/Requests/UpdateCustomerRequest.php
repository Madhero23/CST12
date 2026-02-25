<?php

namespace App\Modules\Customer\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Update Customer Request
 * 
 * Validation rules for updating an existing customer
 */
class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO: Add proper authorization check
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $customerId = $this->route('id');

        return [
            'Customer_Name' => ['sometimes', 'required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\-\.]+$/'],
            'Customer_Type' => ['sometimes', 'required', 'in:Hospital,Clinic,Distributor,Individual'],
            'Customer_Segment' => ['sometimes', 'required', 'in:Public,Private,Government'],
            'Contact_Person' => ['sometimes', 'required', 'string', 'max:255'],
            'Email' => ['sometimes', 'required', 'email:rfc,dns', 'max:255', 'unique:customers,Email,' . $customerId . ',Customer_ID'],
            'Phone_Number' => ['sometimes', 'required', 'string', 'max:20', 'regex:/^[\d\s\-\(\)\+]+$/'],
            'Address' => ['sometimes', 'required', 'string', 'max:500'],
            'City' => ['sometimes', 'required', 'string', 'max:100'],
            'Province' => ['sometimes', 'required', 'string', 'max:100'],
            'Postal_Code' => ['nullable', 'string', 'max:20'],
            'Country' => ['sometimes', 'required', 'string', 'max:100'],
            'Credit_Limit_PHP' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'Payment_Terms' => ['nullable', 'string', 'max:100'],
            'Tax_ID' => ['nullable', 'string', 'max:50'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'Customer_Name.regex' => 'Customer name can only contain letters, spaces, hyphens, and periods',
            'Customer_Type.in' => 'Invalid customer type selected',
            'Customer_Segment.in' => 'Invalid customer segment selected',
            'Email.email' => 'Please provide a valid email address',
            'Email.unique' => 'This email address is already registered',
            'Phone_Number.regex' => 'Please provide a valid phone number',
        ];
    }
}
