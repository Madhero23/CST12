<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationTemplate extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $primaryKey = 'Template_ID';

    protected $fillable = [
        'Template_Name',
        'Template_Type',
        'Customer_Segment',
        'File_Path',
        'Header_Text',
        'Footer_Text',
        'Terms_Conditions',
        'Branding_Color',
        'Created_By',
        'Is_Active',
    ];
}
