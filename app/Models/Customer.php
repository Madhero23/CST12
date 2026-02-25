<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Customer Model
 * 
 * Represents a customer institution in the system.
 * 
 * @property int $Customer_ID
 * @property string $Institution_Name
 * @property string $Customer_Type
 * @property string $Contact_Person
 * @property string $Email
 * @property string $Phone
 * @property string $Address
 * @property string $Segment_Type
 * @property string $Status
 * @property string|null $Payment_Terms_Preference
 * @property float|null $Credit_Limit
 * @property float $Total_Purchase_Value
 * @property \Carbon\Carbon|null $Last_Interaction_Date
 */
class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The primary key for the model
     *
     * @var string
     */
    protected $primaryKey = 'Customer_ID';

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Institution_Name',
        'Customer_Type',
        'Contact_Person',
        'Email',
        'Phone',
        'Address',
        'Segment_Type',
        'Status',
        'Payment_Terms_Preference',
        'Credit_Limit',
        'Total_Purchase_Value',
        'Last_Interaction_Date',
    ];

    /**
     * The attributes that should be cast
     *
     * @var array<string, string>
     */
    protected $casts = [
        'Last_Interaction_Date' => 'date',
        'Total_Purchase_Value' => 'decimal:2',
        'Credit_Limit' => 'decimal:2',
    ];

    /**
     * Validation rules for customer data
     *
     * @return array<string, mixed>
     */
    public static function validationRules(): array
    {
        return [
            'Institution_Name' => 'required|string|max:255',
            'Customer_Type' => 'required|in:Hospital,School,Government,PrivateClinic,OtherInstitution',
            'Contact_Person' => 'required|string|max:255',
            'Email' => 'required|email|max:255|unique:customers,Email',
            'Phone' => 'required|string|max:20',
            'Address' => 'required|string',
            'Segment_Type' => 'required|in:HighValue,MediumValue,LowValue,Prospect',
            'Status' => 'in:Active,Inactive,OnHold',
            'Payment_Terms_Preference' => 'nullable|string|max:255',
            'Credit_Limit' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Scope a query to only include active customers
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('Status', 'Active');
    }

    /**
     * Scope a query to filter by customer type
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('Customer_Type', $type);
    }

    /**
     * Scope a query to filter by segment
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $segment
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySegment($query, string $segment)
    {
        return $query->where('Segment_Type', $segment);
    }

    /**
     * Check if customer is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->Status === 'Active';
    }

    /**
     * Get formatted total purchase value
     *
     * @return string
     */
    public function getFormattedTotalPurchaseAttribute(): string
    {
        return '₱' . number_format($this->Total_Purchase_Value, 2);
    }
}

