<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationLineItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'Line_Item_ID';

    protected $fillable = [
        'Quotation_ID',
        'Product_ID',
        'Quantity',
        'Unit_Price',
        'Line_Total',
        'Discount_Percentage',
        'PHP_Conversion_Rate',
        'Currency',
        'Notes',
    ];

    protected $casts = [
        'Quantity' => 'integer',
        'Unit_Price' => 'decimal:2',
        'Line_Total' => 'decimal:2',
        'Discount_Percentage' => 'decimal:2',
        'PHP_Conversion_Rate' => 'decimal:4',
    ];

    public function quotation()
    {
        return $this->belongsTo(\App\Models\Quotation::class, 'Quotation_ID', 'Quotation_ID');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'Product_ID', 'Product_ID');
    }
}
