<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'Document_ID';

    protected $fillable = [
        'Document_Type',
        'File_Path',
        'File_Name',
        'File_Extension',
        'MIME_Type',
        'File_Size',
        'Related_Entity_Type',
        'Related_Entity_ID',
        'Uploaded_By',
        'Expiry_Date',
        'Status',
        'Version_Number',
        'Additional_Notes',
    ];

    protected $casts = [
        'File_Size' => 'integer',
        'Expiry_Date' => 'date',
        'Version_Number' => 'integer',
        'Related_Entity_ID' => 'integer',
    ];

    public function uploader()
    {
        return $this->belongsTo(\App\Models\User::class, 'Uploaded_By', 'User_ID');
    }

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'Related_Entity_ID', 'Customer_ID')
            ->where('Related_Entity_Type', 'Customer');
    }

    public function quotation()
    {
        return $this->belongsTo(\App\Models\Quotation::class, 'Related_Entity_ID', 'Quotation_ID');
    }

    public function sale()
    {
        return $this->belongsTo(\App\Models\Sale::class, 'Related_Entity_ID', 'Sale_ID');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'Related_Entity_ID', 'Product_ID');
    }

    public function relatedRecord()
    {
        if ($this->Related_Entity_Type === 'Customer') return $this->customer();
        if ($this->Related_Entity_Type === 'Quotation') return $this->quotation();
        if ($this->Related_Entity_Type === 'Sale') return $this->sale();
        if ($this->Related_Entity_Type === 'Product') return $this->product();
        return null;
    }
}
