<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlertLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'Alert_ID';

    protected $fillable = [
        'Alert_Type',
        'Subject',
        'Message',
        'Severity',
        'Is_Read',
        'Read_By',
        'Read_Date',
        'Resolution_Status',
        'Related_Entity_Type',
        'Related_Entity_ID',
    ];

    protected $casts = [
        'Is_Read' => 'boolean',
        'Read_Date' => 'datetime',
        'Related_Entity_ID' => 'integer',
        'Resolution_Status' => 'string',
    ];

    public function reader()
    {
        return $this->belongsTo(User::class, 'Read_By', 'User_ID');
    }
}
