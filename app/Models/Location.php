<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'Location_ID';

    protected $fillable = [
        'Location_Name',
        'Address',
        'Contact_Number',
        'Status',
        'Manager_ID',
    ];

    protected $casts = [
        'Status' => 'string',
    ];
}
