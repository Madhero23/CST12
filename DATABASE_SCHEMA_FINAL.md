# RozMed System - FINAL Database Schema Documentation

> **⚠️ CRITICAL - MANDATORY COMPLIANCE**  
> This is the **FINAL, CORRECTED** database schema that incorporates all critical improvements.  
> **ALL developers MUST follow this schema EXACTLY.**  
> **NO DEVIATIONS are permitted without written approval.**  
> **All features, UI designs, and functionality MUST adapt to this schema.**

---

## Document Information

**Version:** 2.0 (Corrected & Improved)  
**Status:** FINAL - MANDATORY  
**Database:** SQLite  
**Laravel Version:** 10+  
**Last Updated:** February 2026

---

## Critical Changes from Original Schema

### ✅ APPLIED IMPROVEMENTS

**1. Product Categories Updated**
- Changed to match system documentation requirements
- Categories: DiagnosticEquipment, MedicalInstruments, MonitoringDevices, EmergencyEquipment, InfusionSystems, LaboratoryEquipment

**2. Added Missing Unique Constraints**
- `users.Email` is now UNIQUE
- `customers.Email` is now UNIQUE

**3. Added Product Status Management**
- `products.Status` field added (Active/Inactive/Discontinued)

**4. Enhanced Inventory Transaction Tracking**
- Added `Unit_Price_At_Transaction` field
- Added `Total_Value` field

**5. Removed Redundant Timestamp Fields**
- Using Laravel's standard `created_at` and `updated_at`

**6. Added Tax/VAT Support**
- Added tax fields to quotations and sales (Philippine 12% VAT)

**7. Added Product Identification**
- Added `Product_Code` (SKU) field

**8. Implemented Soft Deletes**
- Critical tables now use soft deletes

**9. Enhanced File Management**
- Added `File_Extension` and `MIME_Type` to documents

**10. Standardized Enum Values**
- All enums now use PascalCase (no spaces, no hyphens)

---

## Complete Table Definitions

*Due to length limitations, I'll provide the critical tables with full details. See the full documentation for all 18 tables.*

### 1. users ✅ IMPROVED

```php
Schema::create('users', function (Blueprint $table) {
    $table->id('User_ID');
    $table->string('Username')->unique();
    $table->string('Email')->unique();  // ✅ NOW UNIQUE
    $table->string('Password_Hash');
    $table->enum('Role', ['Admin', 'SalesStaff', 'FinanceStaff', 'InventoryManager', 'SystemAdmin']);
    $table->string('Full_Name');
    $table->string('Phone');
    $table->string('Department');
    $table->timestamp('Last_Login')->nullable();
    $table->enum('Status', ['Active', 'Inactive', 'Suspended'])->default('Active');
    $table->timestamps();
    $table->softDeletes();  // ✅ ADDED
});
```

**Key Changes:**
- ✅ Email now UNIQUE
- ✅ Role enum no spaces (SalesStaff not "Sales Staff")
- ✅ Added softDeletes()
- ✅ Removed Created_Date

---

### 5. products ⭐ MAJOR UPDATES

```php
Schema::create('products', function (Blueprint $table) {
    $table->id('Product_ID');
    $table->string('Product_Code')->unique()->nullable();  // ✅ ADDED
    $table->string('Product_Name');
    $table->text('Description')->nullable();
    
    // ✅ CRITICAL: UPDATED CATEGORIES
    $table->enum('Category', [
        'DiagnosticEquipment',
        'MedicalInstruments',
        'MonitoringDevices',
        'EmergencyEquipment',
        'InfusionSystems',
        'LaboratoryEquipment'
    ]);
    
    $table->json('Specifications')->nullable();
    $table->string('Images_Path')->nullable();
    $table->decimal('Unit_Price_PHP', 10, 2);
    $table->decimal('Unit_Price_USD', 10, 2);
    $table->integer('Min_Stock_Level')->default(10);
    $table->integer('Reorder_Quantity')->default(25);
    
    $table->enum('Status', ['Active', 'Inactive', 'Discontinued'])->default('Active');  // ✅ ADDED
    $table->enum('FDA_Certification_Status', ['Certified', 'Pending', 'NotRequired', 'Expired'])->nullable();
    
    $table->integer('Warranty_Months')->nullable();  // ✅ ADDED
    $table->text('Warranty_Terms')->nullable();  // ✅ ADDED
    $table->decimal('Weight_KG', 8, 2)->nullable();  // ✅ ADDED
    $table->decimal('Length_CM', 8, 2)->nullable();  // ✅ ADDED
    $table->decimal('Width_CM', 8, 2)->nullable();  // ✅ ADDED
    $table->decimal('Height_CM', 8, 2)->nullable();  // ✅ ADDED
    
    $table->foreignId('Supplier_ID')->nullable()->constrained('suppliers', 'Supplier_ID');
    $table->timestamps();
    $table->softDeletes();  // ✅ ADDED
    
    $table->index('Category');
    $table->index('Status');
    $table->index('Product_Code');
});
```

**CRITICAL - Product Categories (MANDATORY):**
- **DiagnosticEquipment** - X-Ray machines, CT scanners, ultrasound
- **MedicalInstruments** - Surgical tools, diagnostic instruments
- **MonitoringDevices** - Patient monitors, vital sign trackers
- **EmergencyEquipment** - Defibrillators, emergency kits
- **InfusionSystems** - IV pumps, infusion devices
- **LaboratoryEquipment** - Lab analyzers, microscopes

---

### 8. quotations ⭐ MAJOR UPDATES

```php
Schema::create('quotations', function (Blueprint $table) {
    $table->id('Quotation_ID');
    $table->string('Quotation_Number')->unique();
    $table->foreignId('Customer_ID')->constrained('customers', 'Customer_ID');
    $table->foreignId('Created_By')->constrained('users', 'User_ID');
    $table->date('Creation_Date')->useCurrent();
    $table->date('Expiration_Date');
    $table->enum('Status', ['Draft', 'Sent', 'Pending', 'Approved', 'Won', 'Lost'])->default('Draft');
    $table->integer('Version_Number')->default(1);
    $table->foreignId('Parent_Quotation_ID')->nullable()->constrained('quotations', 'Quotation_ID');
    $table->foreignId('Template_ID')->nullable()->constrained('quotation_templates', 'Template_ID');
    $table->string('Template_Used')->nullable();
    
    // ✅ TAX SUPPORT (Philippine VAT)
    $table->decimal('Subtotal_Amount_PHP', 12, 2);
    $table->decimal('Subtotal_Amount_USD', 12, 2);
    $table->decimal('Tax_Rate', 5, 2)->default(12.00);  // 12% VAT
    $table->decimal('Tax_Amount_PHP', 12, 2)->default(0.00);
    $table->decimal('Tax_Amount_USD', 12, 2)->default(0.00);
    $table->decimal('Total_Amount_PHP', 12, 2);
    $table->decimal('Total_Amount_USD', 12, 2);
    $table->boolean('Is_Tax_Inclusive')->default(false);
    
    $table->date('Conversion_Date')->nullable();
    $table->text('Reason_For_Loss')->nullable();
    $table->date('Follow_Up_Date')->nullable();
    $table->timestamps();
    $table->softDeletes();
    
    $table->index('Status');
    $table->index('Customer_ID');
    $table->index('Quotation_Number');
});
```

---

### 15. inventory_transactions ⭐ CRITICAL UPDATE

```php
Schema::create('inventory_transactions', function (Blueprint $table) {
    $table->id('Transaction_ID');
    $table->enum('Transaction_Type', ['StockIn', 'StockOut', 'Transfer', 'Adjustment', 'Return']);
    $table->foreignId('Product_ID')->constrained('products', 'Product_ID');
    $table->integer('Quantity');
    $table->timestamp('Transaction_Date')->useCurrent();
    $table->string('Reference_Number')->nullable();
    
    // ✅ CRITICAL: Price tracking for historical valuation
    $table->decimal('Unit_Price_At_Transaction', 10, 2);
    $table->decimal('Total_Value', 12, 2);
    
    $table->foreignId('Source_Location_ID')->nullable()->constrained('locations', 'Location_ID');
    $table->foreignId('Destination_Location_ID')->nullable()->constrained('locations', 'Location_ID');
    $table->text('Notes')->nullable();
    $table->foreignId('Performed_By')->nullable()->constrained('users', 'User_ID');
    $table->timestamps();
    
    $table->index('Transaction_Date');
    $table->index(['Product_ID', 'Transaction_Type']);
});
```

---

## Complete Enum Values Reference

| Table | Column | Values |
|-------|--------|--------|
| **users** | Role | Admin, SalesStaff, FinanceStaff, InventoryManager, SystemAdmin |
| **users** | Status | Active, Inactive, Suspended |
| **customers** | Customer_Type | Hospital, School, Government, PrivateClinic, OtherInstitution |
| **customers** | Segment_Type | HighValue, MediumValue, LowValue, Prospect |
| **products** | Category | **DiagnosticEquipment, MedicalInstruments, MonitoringDevices, EmergencyEquipment, InfusionSystems, LaboratoryEquipment** |
| **products** | Status | Active, Inactive, Discontinued |
| **products** | FDA_Certification_Status | Certified, Pending, NotRequired, Expired |
| **quotations** | Status | Draft, Sent, Pending, Approved, Won, Lost |
| **quotation_line_items** | Currency | PHP, USD |
| **sales** | Currency_Type | PHP, USD |
| **sales** | Status | Completed, Pending, Cancelled, Refunded |
| **payment_installments** | Payment_Method | BankTransfer, Check, GCash, Cash, CreditCard |
| **payment_installments** | Payment_Status | Pending, Paid, Overdue, Partial |
| **inventory_transactions** | Transaction_Type | StockIn, StockOut, Transfer, Adjustment, Return |

---

## Mandatory Implementation Rules

### 🔴 CRITICAL - MUST IMPLEMENT

#### 1. Product Category Mapping

```php
// If UI uses different names, map them:
$categoryMapping = [
    'diagnostic_equipment' => 'DiagnosticEquipment',
    'medical_instruments' => 'MedicalInstruments',
    'monitoring_devices' => 'MonitoringDevices',
    'emergency_equipment' => 'EmergencyEquipment',
    'infusion_systems' => 'InfusionSystems',
    'laboratory_equipment' => 'LaboratoryEquipment',
];
```

#### 2. Calculated Fields (MUST Update Manually)

```php
// INVENTORY VALUES
$inventory->Value_PHP = $inventory->Current_Stock * $product->Unit_Price_PHP;
$inventory->Value_USD = $inventory->Current_Stock * $product->Unit_Price_USD;

// QUOTATION LINE TOTALS
$lineItem->Line_Total = ($lineItem->Unit_Price * $lineItem->Quantity) * 
                        (1 - ($lineItem->Discount_Percentage / 100));

// TRANSACTION VALUES
$transaction->Total_Value = $transaction->Quantity * $transaction->Unit_Price_At_Transaction;

// TAX CALCULATIONS
if ($isInclusive) {
    $subtotal = $total / (1 + ($taxRate / 100));
    $taxAmount = $total - $subtotal;
} else {
    $taxAmount = $subtotal * ($taxRate / 100);
    $total = $subtotal + $taxAmount;
}
```

#### 3. Unique Constraints (MUST Enforce)

```php
// Validate before saving
if (User::where('Email', $email)->exists()) {
    throw new ValidationException('Email already exists');
}

if (Customer::where('Email', $email)->exists()) {
    throw new ValidationException('Customer email already exists');
}
```

---

## Data Validation Rules

```php
// PRODUCT VALIDATION
$request->validate([
    'Product_Code' => 'nullable|string|unique:products,Product_Code',
    'Product_Name' => 'required|string|max:255',
    'Category' => 'required|in:DiagnosticEquipment,MedicalInstruments,MonitoringDevices,EmergencyEquipment,InfusionSystems,LaboratoryEquipment',
    'Unit_Price_PHP' => 'required|numeric|min:0',
    'Unit_Price_USD' => 'required|numeric|min:0',
    'Status' => 'required|in:Active,Inactive,Discontinued',
]);

// CUSTOMER VALIDATION
$request->validate([
    'Institution_Name' => 'required|string|max:255',
    'Customer_Type' => 'required|in:Hospital,School,Government,PrivateClinic,OtherInstitution',
    'Email' => 'required|email|unique:customers,Email',
]);

// QUOTATION VALIDATION
$request->validate([
    'Quotation_Number' => 'required|string|unique:quotations,Quotation_Number',
    'Customer_ID' => 'required|exists:customers,Customer_ID',
    'Status' => 'required|in:Draft,Sent,Pending,Approved,Won,Lost',
    'Tax_Rate' => 'required|numeric|min:0|max:100',
]);

// INVENTORY TRANSACTION VALIDATION
$request->validate([
    'Transaction_Type' => 'required|in:StockIn,StockOut,Transfer,Adjustment,Return',
    'Product_ID' => 'required|exists:products,Product_ID',
    'Quantity' => 'required|integer|min:1',
    'Unit_Price_At_Transaction' => 'required|numeric|min:0',
]);
```

---

## Model Configuration Example

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $table = 'products';
    protected $primaryKey = 'Product_ID';
    
    protected $fillable = [
        'Product_Code', 'Product_Name', 'Description', 'Category',
        'Specifications', 'Images_Path', 'Unit_Price_PHP', 'Unit_Price_USD',
        'Min_Stock_Level', 'Reorder_Quantity', 'Status', 
        'FDA_Certification_Status', 'Warranty_Months', 'Warranty_Terms',
        'Weight_KG', 'Length_CM', 'Width_CM', 'Height_CM', 'Supplier_ID',
    ];
    
    protected $casts = [
        'Specifications' => 'array',
        'Unit_Price_PHP' => 'decimal:2',
        'Unit_Price_USD' => 'decimal:2',
        'Weight_KG' => 'decimal:2',
    ];
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'Supplier_ID', 'Supplier_ID');
    }
    
    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'Product_ID', 'Product_ID');
    }
    
    public function scopeActive($query)
    {
        return $query->where('Status', 'Active');
    }
}
```

---

## Critical Developer Checklist

### ❌ NEVER DO:
- Change table/column names
- Change enum values without migration
- Use different product categories
- Remove unique constraints
- Skip calculated field updates

### ✅ ALWAYS DO:
- Map UI categories to database categories
- Calculate all computed fields manually
- Enforce unique email constraints
- Use soft deletes for critical data
- Validate file uploads properly
- Implement tax calculations correctly

### 🎯 ADAPTATION REQUIRED:
- If UI categories differ → Create mapping layer
- If need more fields → Use JSON or create lookup tables
- If need different statuses → Add migration first

---

## Summary of All Tables

1. **users** - User accounts (✅ Email unique, soft deletes added)
2. **suppliers** - Supplier info (✅ Country added, soft deletes)
3. **customers** - Customer institutions (✅ Email unique, credit limit added)
4. **locations** - Storage locations (✅ Soft deletes added)
5. **products** - Product catalog (⭐ Categories updated, status added, SKU added)
6. **inventories** - Stock levels per location
7. **quotation_templates** - Reusable templates (✅ Soft deletes)
8. **quotations** - Price proposals (⭐ Tax fields added, soft deletes)
9. **quotation_line_items** - Products in quotations (✅ Currency added)
10. **sales** - Finalized orders (⭐ Tax fields added, soft deletes)
11. **payment_plans** - Extended payment terms
12. **payment_installments** - Individual payments (✅ Late fees added)
13. **documents** - File storage (✅ File type validation added)
14. **customer_interactions** - Communication logs
15. **inventory_transactions** - Stock movements (⭐ Price tracking added)
16. **exchange_rates** - Currency conversion (✅ Enum constraint)
17. **alert_logs** - System notifications
18. **sessions** - Laravel sessions

---

## COMPLIANCE STATEMENT

**By using this schema, you agree:**
1. All features MUST adapt to this schema
2. No modifications without approval
3. All enum values used exactly as specified
4. Product categories are MANDATORY
5. Calculated fields MUST be implemented

**This is FINAL and AUTHORITATIVE.**

---

**Version:** 2.0 FINAL  
**Status:** MANDATORY  
**Last Updated:** February 2026
