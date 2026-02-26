<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentInstallment extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'Installment_ID';

    protected $fillable = [
        'Payment_Plan_ID',
        'Installment_Number',
        'Due_Date',
        'Amount_Due',
        'Amount_Paid',
        'Late_Fee',
        'Total_Due',
        'Payment_Date',
        'Payment_Method',
        'Payment_Status',
        'Transaction_Reference',
        'Receipt_Path',
        'Exchange_Rate_Used',
    ];

    protected $casts = [
        'Due_Date' => 'date',
        'Payment_Date' => 'date',
        'Amount_Due' => 'decimal:2',
        'Amount_Paid' => 'decimal:2',
        'Late_Fee' => 'decimal:2',
        'Total_Due' => 'decimal:2',
        'Exchange_Rate_Used' => 'decimal:4',
    ];

    public function paymentPlan()
    {
        return $this->belongsTo(\App\Models\PaymentPlan::class, 'Payment_Plan_ID', 'Payment_Plan_ID');
    }
}
