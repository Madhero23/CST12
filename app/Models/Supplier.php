<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Supplier Model
 * 
 * Manages supplier information and relationships
 */
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'suppliers';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'Supplier_ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Supplier_Name',
        'Contact_Person',
        'Email',
        'Phone',
        'Address',
        'Country',
        'Specialization',
        'Years_In_Service',
        'Status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'Years_In_Service' => 'integer',
    ];

    /**
     * Get the products for the supplier.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'Supplier_ID', 'Supplier_ID');
    }

    /**
     * Scope a query to only include active suppliers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('Status', 'Active');
    }
}