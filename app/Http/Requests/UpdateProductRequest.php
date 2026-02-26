<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Will be protected by admin middleware
    }

    public function rules(): array
    {
        return [
            'Product_Code' => 'nullable|string|max:100|unique:products,Product_Code',
            'Product_Name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-\(\)\/]+$/'
            ],
            'Category' => [
                'required',
                'in:DiagnosticEquipment,MedicalInstruments,MonitoringDevices,EmergencyEquipment,InfusionSystems,LaboratoryEquipment'
            ],
            'Description' => 'required|string|max:1000',
            'Unit_Price_PHP' => 'required|numeric|min:0|max:99999999.99',
            'Stock_Quantity' => 'required|integer|min:0',
            'Supplier_ID' => 'nullable|exists:suppliers,Supplier_ID',
            'Status' => 'sometimes|required|in:Active,Inactive,Discontinued',
            'FDA_Certification_Status' => 'nullable|in:Certified,Pending,NotRequired,Expired',
        ];
    }

    public function messages(): array
    {
        return [
            'Product_Name.required' => 'Product name is required',
            'Product_Name.regex' => 'Product name contains invalid characters',
            'Category.required' => 'Please select a category',
            'Category.in' => 'Invalid category selected',
            'Description.required' => 'Product description is required',
            'Unit_Price_PHP.required' => 'Price in PHP is required',
            'Unit_Price_PHP.numeric' => 'Price must be a valid number',
            'Stock_Quantity.required' => 'Stock quantity is required',
            'Stock_Quantity.integer' => 'Stock quantity must be a whole number',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Set aging_date to today if not provided
        if (!$this->has('aging_date')) {
            $this->merge([
                'aging_date' => now()->toDateString(),
            ]);
        }
    }
}
