<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerInteraction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customer_interactions';
    protected $primaryKey = 'Interaction_ID';

    protected $fillable = [
        'Customer_ID',
        'User_ID',
        'Interaction_Type',
        'Interaction_Date',
        'Subject',
        'Details',
        'Related_Quotation_ID',
        'Follow_Up_Date',
        'Status',
        'Duration_Minutes',
    ];

    protected $casts = [
        'Interaction_Date' => 'datetime',
        'Follow_Up_Date' => 'date',
        'Duration_Minutes' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'Customer_ID', 'Customer_ID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'Related_Quotation_ID', 'Quotation_ID');
    }
}
