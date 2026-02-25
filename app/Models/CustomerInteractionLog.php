<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerInteractionLog extends Model
{
    protected $table = 'customer_interactions';
    protected $primaryKey = 'Interaction_ID';

    protected $fillable = [
        'Customer_ID',
        'User_ID',
        'Interaction_Type',
        'Subject',
        'Details',
        'Follow_Up_Date',
        'Interaction_Date',
        'Status',
        'Duration_Minutes'
    ];

    protected $casts = [
        'Interaction_Date' => 'datetime',
        'Follow_Up_Date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'Customer_ID', 'Customer_ID');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'User_ID', 'User_ID');
    }
}
