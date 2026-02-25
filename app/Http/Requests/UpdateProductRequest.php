<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Will be protected by admin middleware
    }

    public function rules(): array
    {
        return [
            'Product_Name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-\(\)\/]+$/'
            ],
            'Category' => [
                'sometimes',
                'required',
                'in:DiagnosticEquipment,MedicalInstruments,MonitoringDevices,EmergencyEquipment,InfusionSystems,LaboratoryEquipment'
            ],
            'Description' => 'sometimes|required|string|max:1000',
            'Unit_Price_PHP' => 'sometimes|required|numeric|min:0|max:99999999.99',
            'Stock_Quantity' => 'sometimes|required|integer|min:0',
            'Status' => 'sometimes|required|in:Active,Inactive,Discontinued',
            'Supplier_ID' => 'nullable|exists:suppliers,Supplier_ID',
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
            'Unit_Price_PHP.numeric' => 'Price must be a valid number',
            'Stock_Quantity.integer' => 'Stock quantity must be a whole number',
        ];
    }
}
