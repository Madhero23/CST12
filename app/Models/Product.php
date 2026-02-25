<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Product Model
 * 
 * Represents a medical equipment product in the system.
 * 
 * @property int $Product_ID
 * @property string|null $Product_Code
 * @property string $Product_Name
 * @property string|null $Description
 * @property string $Category
 * @property array|null $Specifications
 * @property string|null $Images_Path
 * @property float $Unit_Price_PHP
 * @property float $Unit_Price_USD
 * @property int $Min_Stock_Level
 * @property int $Reorder_Quantity
 * @property string $Status
 * @property string|null $FDA_Certification_Status
 * @property int|null $Warranty_Months
 * @property string|null $Warranty_Terms
 * @property float|null $Weight_KG
 * @property float|null $Length_CM
 * @property float|null $Width_CM
 * @property float|null $Height_CM
 * @property int|null $Supplier_ID
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The primary key for the model
     *
     * @var string
     */
    protected $primaryKey = 'Product_ID';

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Product_Code',
        'Product_Name',
        'Description',
        'Category',
        'Specifications',
        'Images_Path',
        'Unit_Price_PHP',
        'Unit_Price_USD',
        'Min_Stock_Level',
        'Reorder_Quantity',
        'Status',
        'FDA_Certification_Status',
        'Warranty_Months',
        'Warranty_Terms',
        'Weight_KG',
        'Length_CM',
        'Width_CM',
        'Height_CM',
        'Supplier_ID',
    ];

    /**
     * The attributes that should be cast
     *
     * @var array<string, string>
     */
    protected $casts = [
        'Specifications' => 'array',
        'Unit_Price_PHP' => 'decimal:2',
        'Unit_Price_USD' => 'decimal:2',
        'Min_Stock_Level' => 'integer',
        'Reorder_Quantity' => 'integer',
        'Warranty_Months' => 'integer',
        'Weight_KG' => 'decimal:2',
        'Length_CM' => 'decimal:2',
        'Width_CM' => 'decimal:2',
        'Height_CM' => 'decimal:2',
    ];

    /**
     * Validation rules for product data
     *
     * @return array<string, mixed>
     */
    public static function validationRules(): array
    {
        return [
            'Product_Code' => 'nullable|string|max:255|unique:products,Product_Code',
            'Product_Name' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'Category' => 'required|in:DiagnosticEquipment,MedicalInstruments,MonitoringDevices,EmergencyEquipment,InfusionSystems,LaboratoryEquipment',
            'Specifications' => 'nullable|array',
            'Images_Path' => 'nullable|string|max:255',
            'Unit_Price_PHP' => 'required|numeric|min:0',
            'Unit_Price_USD' => 'required|numeric|min:0',
            'Min_Stock_Level' => 'required|integer|min:0',
            'Reorder_Quantity' => 'required|integer|min:0',
            'Status' => 'required|in:Active,Inactive,Discontinued',
            'FDA_Certification_Status' => 'nullable|in:Certified,Pending,NotRequired,Expired',
            'Supplier_ID' => 'nullable|exists:suppliers,Supplier_ID',
        ];
    }

    /**
     * Get the supplier that owns the product
     *
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'Supplier_ID', 'Supplier_ID');
    }

    /**
     * Get the inventory for this product.
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'Product_ID', 'Product_ID');
    }

    /**
     * Scope a query to only include active products
     */
    public function scopeActive($query)
    {
        return $query->where('Status', 'Active');
    }

    /**
     * Scope a query to filter by category
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('Category', $category);
    }

    /**
     * Get formatted price in PHP
     *
     * @return string
     */
    public function getFormattedPricePHPAttribute(): string
    {
        return '₱' . number_format($this->Unit_Price_PHP, 2);
    }

    /**
     * Get formatted price in USD
     *
     * @return string
     */
    public function getFormattedPriceUSDAttribute(): string
    {
        return '$' . number_format($this->Unit_Price_USD, 2);
    }
}