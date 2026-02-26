<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'Quotation_ID';

    protected $fillable = [
        'Title',
        'Quotation_Number',
        'Customer_ID',
        'Created_By',
        'Expiration_Date',
        'Status',
        'Version_Number',
        'Parent_Quotation_ID',
        'Template_ID',
        'Template_Used',
        'Subtotal_Amount_PHP',
        'Subtotal_Amount_USD',
        'Tax_Rate',
        'Tax_Amount_PHP',
        'Tax_Amount_USD',
        'Total_Amount_PHP',
        'Total_Amount_USD',
        'Is_Tax_Inclusive',
        'Conversion_Date',
        'Reason_For_Loss',
        'Follow_Up_Date',
        'Additional_Notes',
        'Status_Notes',
    ];

    protected $casts = [
        'Expiration_Date' => 'date',
        'Follow_Up_Date' => 'date',
        'Conversion_Date' => 'date',
        'Subtotal_Amount_PHP' => 'decimal:2',
        'Subtotal_Amount_USD' => 'decimal:2',
        'Tax_Rate' => 'decimal:2',
        'Tax_Amount_PHP' => 'decimal:2',
        'Tax_Amount_USD' => 'decimal:2',
        'Total_Amount_PHP' => 'decimal:2',
        'Total_Amount_USD' => 'decimal:2',
        'Is_Tax_Inclusive' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'Customer_ID', 'Customer_ID');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'Created_By', 'User_ID');
    }

    public function lineItems()
    {
        return $this->hasMany(\App\Models\QuotationLineItem::class, 'Quotation_ID', 'Quotation_ID');
    }
}
