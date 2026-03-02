<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('id');

        return [
            'Product_Code' => 'nullable|string|max:100|unique:products,Product_Code,' . $productId . ',Product_ID',
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
            'product_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
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
            'Unit_Price_PHP.min' => 'Price must be a positive number',
            'Stock_Quantity.required' => 'Stock quantity is required',
            'Stock_Quantity.integer' => 'Stock quantity must be a whole number',
            'product_image.image' => 'Product image must be a valid image file',
            'product_image.mimes' => 'Product image must be JPG or PNG format',
            'product_image.max' => 'Product image must not exceed 2MB',
        ];
    }

    /**
     * FR-PC-13: Map UI category names to DB enum values
     */
    private static array $categoryMapping = [
        'diagnostic_equipment' => 'DiagnosticEquipment',
        'medical_instruments' => 'MedicalInstruments',
        'monitoring_devices' => 'MonitoringDevices',
        'emergency_equipment' => 'EmergencyEquipment',
        'infusion_systems' => 'InfusionSystems',
        'laboratory_equipment' => 'LaboratoryEquipment',
    ];

    protected function prepareForValidation(): void
    {
        if ($this->has('Category') && isset(self::$categoryMapping[strtolower($this->Category)])) {
            $this->merge([
                'Category' => self::$categoryMapping[strtolower($this->Category)],
            ]);
        }
    }
}
