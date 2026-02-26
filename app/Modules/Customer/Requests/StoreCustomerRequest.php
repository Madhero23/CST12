<?php

namespace App\Modules\Customer\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Store Customer Request
 * 
 * Validation rules for creating a new customer
 */
class StoreCustomerRequest extends FormRequest
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
        return [
            'Customer_Name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\-\.]+$/'],
            'Customer_Type' => ['required', 'in:Hospital,Clinic,Distributor,Individual'],
            'Customer_Segment' => ['required', 'in:Public,Private,Government'],
            'Contact_Person' => ['required', 'string', 'max:255'],
            'Email' => ['required', 'email:rfc,dns', 'max:255', 'unique:customers,Email'],
            'Phone_Number' => ['required', 'string', 'max:20', 'regex:/^[\d\s\-\(\)\+]+$/'],
            'Address' => ['required', 'string', 'max:500'],
            'City' => ['required', 'string', 'max:100'],
            'Province' => ['required', 'string', 'max:100'],
            'Postal_Code' => ['nullable', 'string', 'max:20'],
            'Country' => ['required', 'string', 'max:100'],
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
            'Customer_Name.required' => 'Customer name is required',
            'Customer_Name.regex' => 'Customer name can only contain letters, spaces, hyphens, and periods',
            'Customer_Type.required' => 'Customer type is required',
            'Customer_Type.in' => 'Invalid customer type selected',
            'Customer_Segment.required' => 'Customer segment is required',
            'Customer_Segment.in' => 'Invalid customer segment selected',
            'Email.required' => 'Email address is required',
            'Email.email' => 'Please provide a valid email address',
            'Email.unique' => 'This email address is already registered',
            'Phone_Number.required' => 'Phone number is required',
            'Phone_Number.regex' => 'Please provide a valid phone number',
        ];
    }
}
