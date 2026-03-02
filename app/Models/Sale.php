<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'Sale_ID';

    protected $fillable = [
        'Invoice_Number',
        'Quotation_ID',
        'Customer_ID',
        'Processed_By',
        'Sale_Date',
        'Subtotal_Amount_PHP',
        'Subtotal_Amount_USD',
        'Tax_Rate',
        'Tax_Amount_PHP',
        'Tax_Amount_USD',
        'Total_Amount_PHP',
        'Total_Amount_USD',
        'Is_Tax_Inclusive',
        'Currency_Type',
        'Exchange_Rate_At_Sale',
        'Status',
        'Payment_Term_Months',
        'Notes',
        'Due_Date',
        'Payment_Terms',
        'Amount_Paid',
        'Payment_Method',
        'Last_Payment_Date',
        'Payment_Reference',
    ];

    protected $casts = [
        'Sale_Date' => 'date',
        'Due_Date' => 'date',
        'Last_Payment_Date' => 'date',
        'Subtotal_Amount_PHP' => 'decimal:2',
        'Subtotal_Amount_USD' => 'decimal:2',
        'Tax_Rate' => 'decimal:2',
        'Tax_Amount_PHP' => 'decimal:2',
        'Tax_Amount_USD' => 'decimal:2',
        'Total_Amount_PHP' => 'decimal:2',
        'Total_Amount_USD' => 'decimal:2',
        'Amount_Paid' => 'decimal:2',
        'Is_Tax_Inclusive' => 'boolean',
        'Exchange_Rate_At_Sale' => 'decimal:4',
    ];

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'Customer_ID', 'Customer_ID');
    }

    public function processedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'Processed_By', 'User_ID');
    }

    public function quotation()
    {
        return $this->belongsTo(\App\Models\Quotation::class, 'Quotation_ID', 'Quotation_ID');
    }

    public function paymentPlan()
    {
        return $this->hasOne(\App\Models\PaymentPlan::class, 'Sale_ID', 'Sale_ID');
    }
}
