# RozMed Database Schema - Issues & Recommendations

## Critical Issues Found

After thorough analysis of the database schema, I've identified several **critical issues**, **design problems**, and **potential improvements** that need to be addressed.

---

## 🔴 CRITICAL ISSUES

### 1. **Missing Product Status/Active Field**

**Problem:**  
The `products` table lacks a `Status` or `Is_Active` field to indicate whether a product is currently available for sale.

**Impact:**
- Cannot distinguish between active and discontinued products
- Cannot hide products from catalog without deleting them
- No way to temporarily disable products

**Recommendation:**
```php
// Add to products table migration
$table->enum('Status', ['Active', 'Inactive', 'Discontinued'])->default('Active');
// OR
$table->boolean('Is_Active')->default(true);
```

**Current Workaround:**
- Use `Supplier_ID` = null to indicate inactive products (not recommended)
- Delete products entirely (loses historical data)

---

### 2. **Users Table Missing Email Uniqueness**

**Problem:**  
The `users` table has `Email` field but it's NOT marked as unique, only `Username` is unique.

**Impact:**
- Multiple users could register with the same email
- Potential security issue for password resets
- Confusion in user management

**Current Schema:**
```php
$table->string('Username')->unique();  // ✓ Unique
$table->string('Email');                // ✗ NOT unique
```

**Recommendation:**
```php
$table->string('Email')->unique();
```

**Temporary Solution:**
Add validation in controller to check email uniqueness before creating users.

---

### 3. **Missing Unique Constraint on Customer Email**

**Problem:**  
The `customers` table has `Email` indexed but NOT unique.

**Impact:**
- Could create duplicate customer records with same email
- Data integrity issues
- Confusion in customer management

**Current Schema:**
```php
$table->index('Email');  // Indexed for performance only
```

**Recommendation:**
```php
$table->string('Email')->unique();
```

---

### 4. **Inventory Transactions Missing Unit Price**

**Problem:**  
The `inventory_transactions` table tracks quantity movements but doesn't store the `Unit_Price` at the time of transaction.

**Impact:**
- Cannot calculate accurate inventory valuation over time
- Cannot generate historical cost reports
- Cannot track profit margins accurately

**Current Schema:**
```php
$table->integer('Quantity');  // Only quantity, no price
```

**Recommendation:**
```php
$table->integer('Quantity');
$table->decimal('Unit_Price_At_Transaction', 10, 2);  // Add this
$table->decimal('Total_Value', 12, 2);  // Add this
```

---

### 5. **Product Categories Mismatch with Documentation**

**Problem:**  
Database categories don't match the system requirements documentation.

**Database Categories:**
- Hospital Equipment
- Pharmacy Supplies
- Nursing Items
- EMS Equipment
- Laboratory Equipment
- Dental Equipment

**Documentation Requirements (Milestone 2):**
- Diagnostic Equipment
- Medical Instruments
- Monitoring Devices
- Emergency Equipment
- Infusion Systems

**Impact:**
- UI/UX design won't align with database
- Confusion for developers
- Need category mapping logic

**Recommendation:**
Either:
1. Update migration to match documentation categories, OR
2. Create category mapping in application layer

---

## ⚠️ DESIGN ISSUES

### 6. **Redundant Timestamp Fields**

**Problem:**  
Several tables have both custom date fields AND Laravel's `timestamps()`.

**Examples:**
```php
// products table
$table->date('Created_Date')->useCurrent();
$table->timestamp('Last_Updated')->useCurrent();
$table->timestamps(); // Creates created_at & updated_at

// inventories table
$table->date('Created_Date')->useCurrent();
$table->timestamp('Updated_Date')->useCurrent();
$table->timestamps(); // Creates created_at & updated_at

// alert_logs table
$table->timestamp('Generated_Date')->useCurrent();
$table->timestamp('Created_Date')->useCurrent();
$table->timestamps(); // Creates created_at & updated_at
```

**Impact:**
- Confusing which timestamp to use
- Wasted storage space
- Data synchronization issues
- Inconsistent datetime tracking

**Recommendation:**
Choose ONE approach:
1. Use Laravel's `timestamps()` ONLY (recommended), OR
2. Use custom fields ONLY (not recommended)

**Preferred Solution:**
Remove custom date fields and use Laravel's `created_at` and `updated_at`:
```php
// Instead of:
$table->date('Created_Date')->useCurrent();
$table->timestamp('Last_Updated')->useCurrent();
$table->timestamps();

// Just use:
$table->timestamps();
```

---

### 7. **Missing Index on Quotation Number Search**

**Problem:**  
`Quotation_Number` is marked as unique but users will likely search by partial quotation numbers.

**Current Schema:**
```php
$table->string('Quotation_Number')->unique();
```

**Impact:**
- Slow searches when filtering by quotation number prefix
- Poor performance with large datasets

**Recommendation:**
```php
$table->string('Quotation_Number')->unique()->index();
// OR if using full-text search:
$table->fullText('Quotation_Number');  // Laravel 9+
```

---

### 8. **Exchange Rates Table Missing Currency Validation**

**Problem:**  
`Currency_Pair` defaults to 'USD-PHP' but there's no constraint preventing other currency pairs.

**Current Schema:**
```php
$table->string('Currency_Pair')->default('USD-PHP');
```

**Impact:**
- Could accidentally insert EUR-PHP, JPY-PHP, etc.
- System only designed for USD-PHP conversion
- Data integrity issues

**Recommendation:**
```php
$table->enum('Currency_Pair', ['USD-PHP'])->default('USD-PHP');
// OR if planning to support multiple currencies:
$table->enum('Currency_Pair', ['USD-PHP', 'EUR-PHP', 'JPY-PHP'])->default('USD-PHP');
```

---

### 9. **No Product SKU/Code Field**

**Problem:**  
Products don't have a SKU (Stock Keeping Unit) or product code field.

**Impact:**
- Difficult to identify products uniquely across systems
- Cannot import/export products easily
- No barcode/QR code support
- Harder to integrate with external systems

**Recommendation:**
```php
// Add to products table
$table->string('Product_Code')->unique()->nullable();
// OR
$table->string('SKU')->unique()->nullable();
```

---

### 10. **Quotation Line Items Missing Currency**

**Problem:**  
`quotation_line_items` has `Unit_Price` but doesn't specify if it's PHP or USD.

**Current Schema:**
```php
$table->decimal('Unit_Price', 10, 2);
```

**Impact:**
- Ambiguous pricing in quotations
- Cannot mix currencies in same quotation
- Relies on parent quotation for currency context

**Recommendation:**
```php
$table->decimal('Unit_Price', 10, 2);
$table->enum('Currency', ['PHP', 'USD'])->default('PHP');  // Add this
```

---

## 🟡 MODERATE ISSUES

### 11. **Missing Soft Deletes**

**Problem:**  
No tables implement soft deletes, yet business requirements suggest data should be archived, not deleted.

**Tables That Should Have Soft Deletes:**
- `products` - Discontinued products need history
- `customers` - Cannot delete customers with sales history
- `quotations` - Need audit trail
- `sales` - Critical financial data
- `users` - Need to preserve who created records

**Recommendation:**
```php
use Illuminate\Database\Eloquent\SoftDeletes;

// In migration
$table->softDeletes();

// In model
class Product extends Model
{
    use SoftDeletes;
}
```

---

### 12. **Suppliers Missing Country/Region**

**Problem:**  
Suppliers table lacks country/region information.

**Current Schema:**
```php
$table->text('Address');
```

**Impact:**
- Cannot filter suppliers by country
- Difficult to track import sources
- Cannot calculate shipping/customs by region

**Recommendation:**
```php
$table->string('Country')->default('Philippines');
$table->string('Region')->nullable();
```

---

### 13. **No Audit Trail for Price Changes**

**Problem:**  
When product prices change in `products` table, historical prices are lost.

**Impact:**
- Cannot track price history
- Cannot explain why old quotations had different prices
- Difficult to analyze pricing strategies

**Recommendation:**
Create a `product_price_history` table:
```php
Schema::create('product_price_history', function (Blueprint $table) {
    $table->id();
    $table->foreignId('Product_ID')->constrained('products', 'Product_ID');
    $table->decimal('Old_Price_PHP', 10, 2);
    $table->decimal('New_Price_PHP', 10, 2);
    $table->decimal('Old_Price_USD', 10, 2);
    $table->decimal('New_Price_USD', 10, 2);
    $table->foreignId('Changed_By')->constrained('users', 'User_ID');
    $table->timestamp('Changed_Date');
    $table->text('Reason')->nullable();
});
```

---

### 14. **Payment Installments Missing Late Fee Support**

**Problem:**  
No way to track or add late fees to overdue installments.

**Current Schema:**
```php
$table->decimal('Amount_Due', 10, 2);
$table->decimal('Amount_Paid', 10, 2)->default(0.00);
```

**Impact:**
- Cannot charge late fees
- No penalty for late payments
- Lost revenue opportunity

**Recommendation:**
```php
$table->decimal('Amount_Due', 10, 2);
$table->decimal('Late_Fee', 10, 2)->default(0.00);  // Add this
$table->decimal('Amount_Paid', 10, 2)->default(0.00);
$table->decimal('Total_Due', 10, 2);  // Amount_Due + Late_Fee
```

---

### 15. **Documents Table Missing File Type/Extension**

**Problem:**  
`File_Path` and `File_Name` are stored but no validation on file types.

**Current Schema:**
```php
$table->string('File_Path');
$table->string('File_Name');
$table->integer('File_Size')->nullable();
```

**Impact:**
- Cannot filter documents by file type
- Security risk (could upload executable files)
- Difficult to validate uploads

**Recommendation:**
```php
$table->string('File_Path');
$table->string('File_Name');
$table->string('File_Extension');  // Add this
$table->string('MIME_Type');       // Add this
$table->integer('File_Size')->nullable();
```

---

### 16. **No Tax/VAT Support**

**Problem:**  
No fields for tax/VAT in quotations, sales, or line items.

**Impact:**
- Cannot generate compliant invoices (Philippines requires VAT)
- Cannot track tax liability
- Manual tax calculation required

**Recommendation:**
Add to `quotations` and `sales`:
```php
$table->decimal('Subtotal_Amount', 12, 2);
$table->decimal('Tax_Rate', 5, 2)->default(12.00);  // 12% VAT in PH
$table->decimal('Tax_Amount', 12, 2)->default(0.00);
$table->decimal('Total_Amount', 12, 2);  // Subtotal + Tax
$table->boolean('Is_Tax_Inclusive')->default(false);
```

---

## 🟢 MINOR ISSUES / SUGGESTIONS

### 17. **Inconsistent Enum Naming**

**Problem:**  
Some enums use spaces, some use PascalCase, some use camelCase.

**Examples:**
```php
'Stock In'          // Spaces
'LowStock'          // PascalCase
'High-Value'        // Hyphenated
'Other Institution' // Spaces
```

**Recommendation:**
Choose ONE standard:
- `stock_in` (snake_case) - Recommended
- `StockIn` (PascalCase)
- `Stock In` (Spaces) - Current mix

---

### 18. **Missing Product Weight/Dimensions**

**Problem:**  
Medical equipment often needs shipping calculations, but no weight/dimensions.

**Recommendation:**
```php
// Add to products table
$table->decimal('Weight_KG', 8, 2)->nullable();
$table->decimal('Length_CM', 8, 2)->nullable();
$table->decimal('Width_CM', 8, 2)->nullable();
$table->decimal('Height_CM', 8, 2)->nullable();
```

---

### 19. **No Customer Credit Limit**

**Problem:**  
System supports payment plans but no credit limit field for customers.

**Recommendation:**
```php
// Add to customers table
$table->decimal('Credit_Limit', 12, 2)->nullable();
$table->decimal('Available_Credit', 12, 2)->nullable();
```

---

### 20. **Missing Product Warranty Information**

**Problem:**  
Medical equipment typically has warranty periods.

**Recommendation:**
```php
// Add to products table
$table->integer('Warranty_Months')->nullable();
$table->text('Warranty_Terms')->nullable();
```

---

## 📊 SUMMARY OF CRITICAL ACTIONS NEEDED

### Must Fix Before Production:

1. ✅ Add `Status` or `Is_Active` to `products` table
2. ✅ Make `users.Email` unique
3. ✅ Make `customers.Email` unique
4. ✅ Add `Unit_Price_At_Transaction` to `inventory_transactions`
5. ✅ Resolve product category mismatch
6. ✅ Remove redundant timestamp fields
7. ✅ Add proper indexing for search operations
8. ✅ Add soft deletes to critical tables
9. ✅ Add tax/VAT support for Philippine compliance

### Should Fix for Better Design:

10. Add Product SKU/Code field
11. Add currency to quotation line items
12. Add supplier country information
13. Add product price history tracking
14. Add late fee support to payment installments
15. Add file type validation to documents
16. Standardize enum naming conventions

### Nice to Have:

17. Add product weight/dimensions
18. Add customer credit limit
19. Add product warranty information

---

## 🔧 Migration Strategy

To fix these issues without breaking existing system:

### Option 1: Create New Migration Files (Recommended)
```bash
php artisan make:migration add_missing_fields_to_products_table
php artisan make:migration add_unique_constraint_to_users_email
php artisan make:migration add_unit_price_to_inventory_transactions
```

### Option 2: Modify Existing Migrations
⚠️ **Only if database hasn't been deployed to production yet**

---

## 📝 Implementation Priority

**CRITICAL (Week 1):**
- Product status field
- Email uniqueness constraints
- Category alignment with documentation

**HIGH (Week 2):**
- Inventory transaction pricing
- Soft deletes implementation
- Tax/VAT support

**MEDIUM (Week 3-4):**
- Product SKU/Code
- Audit trails
- Late fee support

**LOW (Future Enhancement):**
- Weight/dimensions
- Credit limits
- Warranty tracking

---

## Conclusion

While the database schema is **functional and covers core requirements**, these issues could cause significant problems in production:

- **Data integrity issues** (missing unique constraints)
- **Missing business-critical fields** (product status, transaction prices, tax)
- **Poor audit trail** (no soft deletes, no price history)
- **Scalability concerns** (missing indexes, redundant timestamps)

**Recommendation:** Address CRITICAL issues before deployment, HIGH issues during development, and MEDIUM/LOW issues as enhancements.

---

**Prepared by:** Database Review Team  
**Date:** February 2026  
**Version:** 1.0
