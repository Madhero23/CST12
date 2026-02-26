<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'Payment_Plan_ID';

    protected $fillable = [
        'Sale_ID',
        'Total_Amount',
        'Currency',
        'Payment_Term_Months',
        'Start_Date',
        'End_Date',
        'Status',
    ];

    protected $casts = [
        'Total_Amount' => 'decimal:2',
        'Start_Date' => 'date',
        'End_Date' => 'date',
    ];

    public function sale()
    {
        return $this->belongsTo(\App\Models\Sale::class, 'Sale_ID', 'Sale_ID');
    }

    public function installments()
    {
        return $this->hasMany(\App\Models\PaymentInstallment::class, 'Payment_Plan_ID', 'Payment_Plan_ID');
    }
}
