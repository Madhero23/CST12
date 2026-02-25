<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExchangeRate extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'Rate_ID';

    protected $fillable = [
        'Currency_Pair',
        'Rate_Value',
        'Effective_Date',
        'Source',
    ];

    protected $casts = [
        'Rate_Value' => 'decimal:4',
        'Effective_Date' => 'date',
    ];
}
