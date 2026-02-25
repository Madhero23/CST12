<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Inventory Model
 * 
 * Represents inventory tracking for products at different locations.
 * 
 * @property int $Inventory_ID
 * @property int $Product_ID
 * @property int $Location_ID
 * @property int $Quantity_On_Hand
 * @property int $Quantity_Reserved
 * @property int $Quantity_Available
 * @property \Carbon\Carbon $Last_Stock_Check_Date
 */
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The primary key for the model
     *
     * @var string
     */
    protected $primaryKey = 'Inventory_ID';

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'inventories';

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Product_ID',
        'Location_ID',
        'Quantity_On_Hand',
        'Quantity_Reserved',
        'Quantity_Available',
        'Last_Stock_Check_Date',
        'Manufacturing_Date',
        'Received_Date',
        'Shelf',
        'Rack',
        'Area',
        'Batch_Number',
    ];

    protected $casts = [
        'Quantity_On_Hand' => 'integer',
        'Quantity_Reserved' => 'integer',
        'Quantity_Available' => 'integer',
        'Last_Stock_Check_Date' => 'datetime',
        'Manufacturing_Date' => 'date',
        'Received_Date' => 'date',
    ];

    public static function validationRules(): array
    {
        return [
            'Product_ID' => 'required|exists:products,Product_ID',
            'Location_ID' => 'required|exists:locations,Location_ID',
            'Quantity_On_Hand' => 'required|integer|min:0',
            'Quantity_Reserved' => 'required|integer|min:0',
            'Quantity_Available' => 'required|integer|min:0',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'Product_ID', 'Product_ID');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'Location_ID', 'Location_ID');
    }

    public function scopeLowStock($query)
    {
        return $query->where('Quantity_Available', '<=', 10)
                     ->where('Quantity_Available', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('Quantity_Available', '<=', 0);
    }

    public function isLowStock(): bool
    {
        return $this->Quantity_Available > 0 && $this->Quantity_Available <= 10;
    }

    public function isOutOfStock(): bool
    {
        return $this->Quantity_Available <= 0;
    }
}

