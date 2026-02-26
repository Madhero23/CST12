<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inventory_transactions';
    protected $primaryKey = 'Transaction_ID';

    protected $fillable = [
        'Product_ID',
        'Transaction_Type',
        'Quantity',
        'Unit_Price_At_Transaction',
        'Total_Value',
        'Reference_Number',
        'Source_Location_ID',
        'Destination_Location_ID',
        'Transaction_Date',
        'Shelf',
        'Rack',
        'Area',
        'Batch_Number',
        'Receiving_Department',
        'Supplier_ID',
        'Notes',
        'Performed_By',
    ];

    protected $casts = [
        'Quantity' => 'integer',
        'Unit_Price_At_Transaction' => 'decimal:2',
        'Total_Value' => 'decimal:2',
        'Transaction_Date' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'Product_ID', 'Product_ID');
    }

    public function sourceLocation()
    {
        return $this->belongsTo(Location::class, 'Source_Location_ID', 'Location_ID');
    }

    public function destinationLocation()
    {
        return $this->belongsTo(Location::class, 'Destination_Location_ID', 'Location_ID');
    }

    public function performedBy()
    {
        return $this->belongsTo(User::class, 'Performed_By', 'User_ID');
    }
}
