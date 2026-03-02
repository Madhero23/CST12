# RozMed Enterprises Inc. — Master Functional Specification
**Laravel Modular Monolith Management System**
> Combined from all test case documents | CS12L Software Engineering | February 2026
> Authors: Mantua, Gabriel T. · Picardal, Liea Maegan C. · Pintor, Tristhan Alfie

---

## System Overview

RozMed Enterprises Inc. Management System is a **Laravel-based modular monolith** platform built for a medical and laboratory equipment supplier. It replaces fully manual operations with a digital, integrated system.

**Architecture:** Modular Monolith — 7 modules deployed as a single application with a shared SQLite database.

**Tech Stack:** Laravel 10+, SQLite, PHP, Blade/JavaScript (modals, AJAX), standard MVC patterns.

---

## Module Summary

| # | Module | Black Box TCs | White Box TCs | Total |
|---|--------|:---:|:---:|:---:|
| 0 | User Authentication & Access Control | 12 | 10 | 22 |
| 1 | Product Catalog Management | 18 | 15 | 33 |
| 2 | Inventory Management | 18 | 15 | 33 |
| 3 | Customer Management (CRM) | 18 | 15 | 33 |
| 4 | Financial Management & Payment | 16 | 15 | 31 |
| 5 | Document Management | 16 | 15 | 31 |
| 6 | Integration & Cross-Module Flows | 6 | 6 | 12 |
| **TOTAL** | | **104** | **91** | **195** |

---

## Module 0 — User Authentication & Access Control

**Laravel Components:** `AuthController.php`, `AuthMiddleware`, `SessionManager`, `User` model with `Role` enum.

**Roles:** `Admin`, `SalesStaff`, `FinanceStaff`, `InventoryManager`, `SystemAdmin`

### Functional Requirements

| FR-ID | Requirement |
|-------|-------------|
| FR-AUTH-01 | System must authenticate users via username + hashed password (Hash::check) |
| FR-AUTH-02 | Failed login must show generic "Invalid credentials" without revealing if username exists |
| FR-AUTH-03 | All required fields (username, password) must be validated before form submission |
| FR-AUTH-04 | Successful login must start a session and regenerate the session ID (prevents session fixation) |
| FR-AUTH-05 | Logout must invalidate session, regenerate CSRF token, and redirect to /login |
| FR-AUTH-06 | Role-based menus: each role sees only its permitted navigation items |
| FR-AUTH-07 | Admin-only routes must return HTTP 403 when accessed by non-Admin roles |
| FR-AUTH-08 | Unauthenticated access to protected routes must redirect to /login, preserving the intended URL |
| FR-AUTH-09 | New user passwords must be at least 8 characters; hashed before DB insert |
| FR-AUTH-10 | User email must be unique (unique:users,Email constraint enforced) |
| FR-AUTH-11 | User role must be one of the defined enum values (validated on creation) |

### Black Box Test Cases — Module 0

| TC ID | Scenario | Input | Expected Output | Technique | Status |
|-------|----------|-------|-----------------|-----------|--------|
| BBT-AUTH-001 | Login with valid credentials | Username='admin', Password='Admin1234!' | Authenticated; redirected to Admin Dashboard | EP Valid | Pass |
| BBT-AUTH-002 | Login with wrong password | Username='admin', Password='WrongPass!' | "Invalid credentials. Please try again." | EP Invalid | Pass |
| BBT-AUTH-003 | Login with empty username | Username='', Password='Admin1234!' | "Username is required" validation error | Boundary | Pass |
| BBT-AUTH-004 | Login with empty password | Username='admin', Password='' | "Password is required" validation error | Boundary | Pass |
| BBT-AUTH-005 | Login with both fields empty | Username='', Password='' | Validation errors on both fields | Boundary/Error Guessing | Pass |
| BBT-AUTH-006 | Login with non-existent username | Username='ghost_user', Password='Test1234!' | Generic "Invalid credentials" (no user enumeration) | Security/EP Invalid | Pass |
| BBT-AUTH-007 | SalesStaff login — role-limited dashboard | Username='salesstaff01', Password='Pass1234!' | Dashboard shows Sales menu only; Admin menu hidden | Role-Based/EP Valid | Pass |
| BBT-AUTH-008 | Logout from active session | Active session; click Logout | Session cleared; redirected to /login; protected routes inaccessible | Workflow/State Transition | Pass |
| BBT-AUTH-009 | Access admin-only route as SalesStaff | GET /admin/users while logged in as SalesStaff | HTTP 403 — "Unauthorized Action" | Negative/Authorization | Pass |
| BBT-AUTH-010 | Access protected route with no session | Navigate to /inventory with no session | Redirected to /login; original URL preserved | Boundary/Security | Pass |
| BBT-AUTH-011 | Create user with password < 8 chars | Password='abc12' (5 chars) | "Password must be at least 8 characters long" | Boundary Value | Pass |
| BBT-AUTH-012 | Create user with duplicate email | Email='existing@rozmed.com' (already in DB) | "Email address already exists"; user NOT created | EP Invalid/Uniqueness | Pass |

### White Box Test Cases — Module 0

| TC ID | Feature | Code Path / Branch Tested | Expected Output | Status |
|-------|---------|--------------------------|-----------------|--------|
| WBT-AUTH-001 | User Login — Credential Check | `Auth::attempt()` → `Hash::check($pass, $storedHash)` if true → `Auth::login()` + `session->regenerate()` | Hash::check true → session started; redirect to dashboard | Pass |
| WBT-AUTH-002 | Login — Wrong Password Branch | `Hash::check()` returns false → error response (no user info leaked) | error message returned; no session started | Pass |
| WBT-AUTH-003 | Login — Non-Existent User Branch | `User::where('Username',$input)->first()` returns null → same error path as wrong password | Generic error shown; timing-safe comparison prevents enumeration | Pass |
| WBT-AUTH-004 | Auth Middleware — Unauthenticated Access | `Authenticate::handle()` → `if(!Auth::check())` → `redirect('/login')` | Redirect to /login; intended URL stored in session | Pass |
| WBT-AUTH-005 | Role-Based Access — Admin Check | `hasRole('Admin')` → `$this->Role === 'Admin'`; if false → `abort(403)` | hasRole==false → 403 thrown; AuthorizationException rendered | Pass |
| WBT-AUTH-006 | Logout — Session Invalidation | `Auth::logout()` → `session->invalidate()` → `session->regenerateToken()` → `redirect('/login')` | All three methods called; session cleared; CSRF regenerated | Pass |
| WBT-AUTH-007 | User Creation — Password Strength | `validatePasswordStrength($pass, minLength=8)`: if strlen < 8 → return invalid; Hash::make NOT called | returns invalid; Hash::make not called; user NOT inserted | Pass |
| WBT-AUTH-008 | User Creation — Unique Email | `validate(['Email'=>'required\|email\|unique:users,Email'])` if duplicate → ValidationException | HTTP 422; {errors:{Email:['already taken']}}; no DB insert | Pass |
| WBT-AUTH-009 | Session Regeneration After Login | `Auth::login($user)` → `session()->regenerate()` | New session ID assigned; old session invalidated; prevents session fixation | Pass |
| WBT-AUTH-010 | Role Enum Validation on User Creation | `validate(['Role'=>'required\|in:Admin,SalesStaff,FinanceStaff,InventoryManager,SystemAdmin'])` | If invalid role → HTTP 422; {error:'Role must be one of: ...'}; no insert | Pass |

---

## Module 1 — Product Catalog Management

**Laravel Components:** `ProductController.php`, `ProductService.php`, `ProductRepository.php`, `InquiryRequest`, `Product` model (SoftDeletes).

**DB Table:** `products` — fields: Product_Code (SKU, unique), Product_Name, Category (enum), Unit_Price_PHP, Unit_Price_USD, Status (Active/Inactive/Discontinued), deleted_at.

**Categories (enum):** `DiagnosticEquipment`, `MedicalInstruments`, `MonitoringDevices`, `EmergencyEquipment`, `InfusionSystems`, `LaboratoryEquipment`

### Functional Requirements

| FR-ID | Requirement |
|-------|-------------|
| FR-PC-01 | Guests/clients can browse all Active products with images, names, and stock badges |
| FR-PC-02 | Search by keyword returns only matching products; empty search returns all |
| FR-PC-03 | "No results found" message displayed for unmatched searches (no crash) |
| FR-PC-04 | Clients can view product detail page (full specs, price, availability) |
| FR-PC-05 | Inquiry form requires Name, Email (valid format), Phone, Message — empty fields rejected |
| FR-PC-06 | Valid inquiry submission saves record and shows confirmation with reference number |
| FR-PC-07 | Admin can add products with all required fields including image; missing image → rejected |
| FR-PC-08 | Product_Code (SKU) must be unique; duplicate rejected with error |
| FR-PC-09 | Admin can edit product details; changes reflected immediately in catalog |
| FR-PC-10 | Admin can delete products (soft delete — deleted_at set, row preserved in DB) |
| FR-PC-11 | Product price cannot be negative (min:0 validation) |
| FR-PC-12 | Only Active-status products appear in client-facing catalog (scope filter) |
| FR-PC-13 | Category input from UI (lowercase with underscores) is mapped to DB enum (PascalCase) |

### Black Box Test Cases — Module 1

| TC ID | Scenario | Input | Expected Output | Technique | Status |
|-------|----------|-------|-----------------|-----------|--------|
| BBT-PC-001 | Add product with all valid fields | Product_Name='Digital X-Ray', Category='DiagnosticEquipment', Price_PHP=150000, Status='Active' | Toast: 'Product added successfully'; product appears in catalog | EP Valid | Pass |
| BBT-PC-002 | Add product with empty required fields | Product_Name='', Category='', Price_PHP='', Status='Active' | Validation error; empty fields highlighted in red | Boundary/Error Guessing | Pass |
| BBT-PC-003 | Add product with duplicate SKU | Product_Code='MED-001' (already exists) | Error: 'Product Code already exists'; NOT saved | EP Invalid | Pass |
| BBT-PC-004 | Search product by keyword | Search input: 'Ultrasound' | Table filters to products with 'Ultrasound' in name | Boundary/Workflow | Pass |
| BBT-PC-005 | Update product price to negative value | Unit_Price_PHP = -500 | Validation error: 'Price must be a positive number'; update rejected | Error Guessing/BVA | Pass |
| BBT-PC-006 | Client submits inquiry with all fields filled | Name, Email, Phone, Message all valid | Confirmation with reference number (e.g., INQ-2024-0048); staff notified | Positive Testing | Pass |
| BBT-PC-007 | Inquiry submission with empty required fields | Name='', Email='', Phone='' | 3 fields highlighted; 'This field is required' per field; submit blocked | BVA/Error Guessing | Pass |
| BBT-PC-008 | Inquiry rejected with invalid email format | Email='not-an-email' | 'Please enter a valid email address' shown; submit blocked | BVA | Pass |
| BBT-PC-009 | Admin adds new product with valid data | All fields + image | Product appears in catalog immediately with all details | EP Valid | Pass |
| BBT-PC-010 | Admin adds product without image | All fields except image | 'Product image is required'; product NOT saved | Error Guessing | Pass |
| BBT-PC-011 | Admin edits existing product price | Change unit price → Save | Updated price reflected immediately in client-facing catalog | Positive | Pass |
| BBT-PC-012 | Admin deletes product | Click delete → confirm | Product removed from active list; soft-deleted (row preserved) | State Transition | Pass |
| BBT-PC-013 | Browse product catalog as guest | Open Product Catalog page | All active products display with images, names, stock badges | EP Valid | Pass |
| BBT-PC-014 | Search with valid keyword | Type 'ultrasound' → Search | Only matching products returned with correct names, specs, availability | EP Valid | Pass |
| BBT-PC-015 | Search with unknown keyword | Type 'xyz999' → Search | 'No results found'; no crash | EP Invalid | Pass |
| BBT-PC-016 | Empty search displays all products | Leave search empty → Search | All available products displayed without filter | BVA | Pass |
| BBT-PC-017 | Client views product detail page | Click on 'Portable Ultrasound Machine' | Detail page shows image, full specs, price range, availability | Workflow | Pass |
| BBT-PC-018 | Admin cancels product deletion | Click delete → Cancel | No changes made; product remains in catalog | Negative | Pass |

### White Box Test Cases — Module 1

| TC ID | Feature | Code Path / Branch | Expected Output | Status |
|-------|---------|-------------------|-----------------|--------|
| WBT-PC-001 | Product Creation — Validation Branch | `store()`: `$request->validate(['Product_Name'=>'required', 'Category'=>'required\|in:...', 'Unit_Price_PHP'=>'required\|numeric\|min:0'])` → ValidationException if fails | HTTP 422; {success:false, errors:{Product_Name:['required']}} | Pass |
| WBT-PC-002 | Product Creation — Unique SKU Branch | `store()`: `if(Product::where('Product_Code',$code)->exists())` → abort with error `else` → `Product::create($validated)` | exists()==true → JSON error; Product NOT inserted | Pass |
| WBT-PC-003 | Product Status Scope — Active Filter | `index()`: `Product::active()->get()` scope: `where('Status','Active')` | Query executes WHERE Status='Active'; returns only Active products | Pass |
| WBT-PC-004 | Product Delete — Soft Delete Branch | `destroy($id)`: `Product::findOrFail($id)->delete()` SoftDeletes trait: sets `deleted_at` timestamp, does NOT remove row | deleted_at column set; product hidden from index(); row preserved in DB | Pass |
| WBT-PC-005 | Category Mapping Layer Branch | `store()`: `$categoryMapping=['diagnostic_equipment'=>'DiagnosticEquipment',...]`; if no match → validation error | Mapped to 'DiagnosticEquipment'; saved correctly to DB enum column | Pass |
| WBT-PC-006 | Inquiry Email Validation Branch | `InquiryRequest::rules()`: `'Email'=>'required\|email'`; if format invalid → reject | HTTP 422; {error:'Invalid email address'} | Pass |
| WBT-PC-007 | Inquiry Save — All Valid Fields | All fields valid → `Inquiry::create($validated)` → reference number generated | Inquiry saved; reference number returned; confirmation shown | Pass |
| WBT-PC-008 | Product Search — DB Query Branch | `index()`: `Product::where('Product_Name','like',"%{$search}%")->get()` | Filtered product list returned matching keyword | Pass |
| WBT-PC-009 | Price Negative Validation | `'Unit_Price_PHP'=>'required\|numeric\|min:0'`; input=-500 → ValidationException | HTTP 422; {errors:{Unit_Price_PHP:['min.0']}} | Pass |
| WBT-PC-010 | Image Required Validation | `'product_image'=>'required\|image\|mimes:jpg,png\|max:2048'`; no image → error | Validation error; product NOT saved | Pass |
| WBT-PC-011 | Product Restore — Soft Delete Recovery | `Product::withTrashed()->find($id)->restore()` → `deleted_at = null` | Product reappears in active catalog | Pass |
| WBT-PC-012 | Duplicate Email Inquiry Block | `Inquiry::where('Email',$email)->where('Product_ID',$pid)->exists()` | If recent duplicate → error response | Pass |
| WBT-PC-013 | Product Index — Pagination Branch | `Product::active()->paginate(12)` | Returns paginated result set; correct page links | Pass |
| WBT-PC-014 | Admin Authorization on Store | `auth()->user()->hasRole('Admin')` check in `store()` | If not Admin → 403 abort; product NOT saved | Pass |
| WBT-PC-015 | Product Update — Dirty Check | `if(!$product->isDirty()) return response('No changes')` else → `$product->save()` | No DB write if no changes; write occurs if dirty | Pass |

---

## Module 2 — Inventory Management

**Laravel Components:** `InventoryController.php`, `InventoryTransactionController.php`, `InventoryService`, `InventoryTransaction` model.

**DB Tables:** `inventory_transactions` — fields: Transaction_Type (enum: StockIn, StockOut, Transfer, Adjustment, Return), Product_ID, Quantity, Reason, Unit_Price_At_Transaction, Total_Value, Source_Location, Destination_Location.

### Functional Requirements

| FR-ID | Requirement |
|-------|-------------|
| FR-INV-01 | Staff can record Stock In; Current_Stock increments by quantity entered |
| FR-INV-02 | Stock Out is blocked when Current_Stock = 0 (zero-stock guard) |
| FR-INV-03 | Stock Out quantity cannot exceed available stock (insufficient stock guard) |
| FR-INV-04 | All inventory transactions require a non-empty Reason field |
| FR-INV-05 | Cancel action closes modal without saving any data |
| FR-INV-06 | Transfer: Source and Destination locations cannot be the same |
| FR-INV-07 | Stock level falling below minimum threshold automatically generates Replenishment Alert |
| FR-INV-08 | Total_Value is auto-calculated: Quantity × Unit_Price_At_Transaction |
| FR-INV-09 | Transaction_Type must match the enum list; invalid types rejected |
| FR-INV-010 | Aging inventory report shows products older than threshold with days count and recommendations |

### Black Box Test Cases — Module 2

| TC ID | Scenario | Input | Expected Output | Technique | Status |
|-------|----------|-------|-----------------|-----------|--------|
| BBT-INV-001 | Stock In with valid quantity and reason | Transaction_Type='StockIn', Product_ID=3, Qty=50, Reason='Restocking', Unit_Price=2500 | 'Stock in recorded successfully'; Current_Stock +50 | EP Valid | Pass |
| BBT-INV-002 | Stock Out when product has 0 stock | Transaction_Type='StockOut', Product_ID=7 (Current_Stock=0), Qty=5 | Error: 'Invalid action: product has 0 stocks'; NOT saved | Error Guessing/Boundary | Pass |
| BBT-INV-003 | Stock In with empty Reason field | Transaction_Type='StockIn', Product_ID=2, Qty=20, Reason='' | Warning: 'Please fill up this form'; Reason field highlighted | BVA/EP Invalid | Pass |
| BBT-INV-004 | Stock Out quantity greater than available | Product_ID=4 (Stock=10), Qty=25 | Error: 'Insufficient stock. Available: 10'; transaction rejected | BVA | Pass |
| BBT-INV-005 | Cancel Stock In before saving | Fill form → click CANCEL | Modal closes; no data saved; inventory unchanged | Workflow/Negative | Pass |
| BBT-INV-006 | Stock Out with valid quantity | Product_ID=2 (Stock=15), Qty=5 | Current_Stock decreases to 10; 'Stock out recorded' | EP Valid | Pass |
| BBT-INV-007 | Transfer between two different locations | Source='Warehouse A', Destination='Warehouse B', Qty=10 | Transfer recorded; source decrements, destination increments | Workflow | Pass |
| BBT-INV-008 | Transfer with same source and destination | Source='Warehouse A', Destination='Warehouse A' | Error: 'Source and destination cannot be the same' | Decision Table | Pass |
| BBT-INV-009 | Stock level triggers replenishment alert | Stock Out brings item below minimum threshold | Replenishment Alert auto-generated; item flagged | State Transition | Pass |
| BBT-INV-010 | Stock Out with quantity = 0 | Qty=0 | Validation error: 'Quantity must be at least 1'; submit disabled | BVA | Pass |
| BBT-INV-011 | Open Aging Inventory Report | Items older than threshold exist | Modal opens; aging products listed with days count; recommendations shown | Workflow | Pass |
| BBT-INV-012 | Stock In — quantity at maximum boundary | Qty=9999 (max allowed) | Stock In recorded; Current_Stock updated correctly | BVA | Pass |
| BBT-INV-013 | Edit inventory record — valid update | Change Reason, Unit_Price → Save | Record updated; Total_Value recalculated | EP Valid | Pass |
| BBT-INV-014 | Delete inventory transaction | Click delete → confirm | Transaction soft-deleted; removed from active list | State Transition | Pass |
| BBT-INV-015 | Adjustment transaction type | Transaction_Type='Adjustment', Qty=3 | Adjustment recorded; Current_Stock corrected | EP Valid | Pass |
| BBT-INV-016 | Return transaction type | Transaction_Type='Return', Product_ID=5, Qty=2 | Return recorded; Current_Stock increments by 2 | EP Valid | Pass |
| BBT-INV-017 | View inventory transaction history | Filter by Product_ID=3 | All transactions for Product_ID=3 listed chronologically | Workflow | Pass |
| BBT-INV-018 | Filter inventory by Transaction_Type | Filter: 'StockIn' | Only StockIn transactions displayed | Workflow | Pass |

### White Box Test Cases — Module 2

| TC ID | Feature | Code Path / Branch | Expected Output | Status |
|-------|---------|-------------------|-----------------|--------|
| WBT-INV-001 | Zero-Stock Guard Branch | `store()`: `if($product->Current_Stock <= 0 && $type=='StockOut')` → abort with error | Error response; transaction NOT saved; Current_Stock unchanged | Pass |
| WBT-INV-002 | Total_Value Auto-Calculation | `store()`: `$total = $quantity * $unit_price`; written to `Total_Value` column | Total_Value = Qty × Unit_Price persisted to DB | Pass |
| WBT-INV-003 | Insufficient Stock Branch | `store()`: `if($qty > $product->Current_Stock && $type=='StockOut')` → error | Error: 'Insufficient stock. Available: {n}'; NOT saved | Pass |
| WBT-INV-004 | Transaction Type Enum Validation | `validate(['Transaction_Type'=>'required\|in:StockIn,StockOut,Transfer,Adjustment,Return'])` | Invalid type → HTTP 422; {errors:{Transaction_Type:['in validation']}} | Pass |
| WBT-INV-005 | Replenishment Alert Auto-Generation | After StockOut: `if($product->Current_Stock < $product->Min_Stock_Level)` → `Alert::create(...)` | Alert record created; product flagged in dashboard | Pass |
| WBT-INV-006 | Transfer Same-Location Guard | `if($source === $destination)` → abort with error | Error: 'Source and destination cannot be the same'; NOT saved | Pass |
| WBT-INV-007 | Cancel Modal — No DB Write | Cancel button calls `closeModal()` without form submission; no POST request sent | No DB record created; Current_Stock unchanged | Pass |
| WBT-INV-008 | Stock In — Current_Stock Increment | `$product->Current_Stock += $qty; $product->save()` | Current_Stock updated in products table after StockIn | Pass |
| WBT-INV-009 | Stock Out — Current_Stock Decrement | `$product->Current_Stock -= $qty; $product->save()` | Current_Stock decremented correctly after StockOut | Pass |
| WBT-INV-010 | Reason Required Validation | `validate(['Reason'=>'required\|string\|min:3'])` | If empty → HTTP 422; reason field highlighted | Pass |
| WBT-INV-011 | Aging Report Query | `Product::where('last_received_at','<',Carbon::now()->subDays($threshold))->get()` | Returns products older than threshold with days calculation | Pass |
| WBT-INV-012 | Loop — Batch Stock Update | `foreach($items as $item) { $item->update(); }` zero, one, and many iterations tested | Loop handles 0, 1, and n items without failure | Pass |
| WBT-INV-013 | Adjustment — Absolute Value Set | `Adjustment` type sets `Current_Stock = $qty` (not += or -=) | Current_Stock overwritten with entered value | Pass |
| WBT-INV-014 | Return — Stock Increment Branch | `Return` type: `$product->Current_Stock += $qty` | Current_Stock incremented; Return transaction recorded | Pass |
| WBT-INV-015 | Quantity Min Validation | `validate(['Quantity'=>'required\|integer\|min:1'])` | Qty=0 → HTTP 422; min validation error | Pass |

---

## Module 3 — Customer Management (CRM)

**Laravel Components:** `CustomerController.php`, `QuotationController.php`, `QuotationService.php`, `ValidationService.php`, `Customer` model (SoftDeletes), `Quotation` model.

**DB Tables:** `customers`, `quotations`, `customer_interactions`, `follow_ups`

**Quotation Status Flow:** `Draft` → `Sent` → `Pending` → `Won` / `Lost`

### Functional Requirements

| FR-ID | Requirement |
|-------|-------------|
| FR-CRM-01 | Staff can create customers with Institution_Name, Customer_Type, Email (unique), Phone (numeric 10-11 digits), Segment_Type |
| FR-CRM-02 | Duplicate email address on customer creation must be blocked with error |
| FR-CRM-03 | Phone number must match regex `/^[0-9]{10,11}$/`; letters rejected |
| FR-CRM-04 | Edit customer with no field changes returns "No changes were made" without a DB write |
| FR-CRM-05 | Customer deletion is a soft delete; record preserved with deleted_at set |
| FR-CRM-06 | Quotation creation requires: Customer, Template, at least one line item, Expiration_Date |
| FR-CRM-07 | Quotation numbers are auto-assigned (e.g., QUO-2026-0015) |
| FR-CRM-08 | Quotation status transitions must follow allowed pipeline: Draft→Sent, Sent→Pending/Won/Lost; invalid jumps rejected |
| FR-CRM-09 | VAT calculation: Exclusive = Subtotal × 1.12; Inclusive = Total / 1.12 to extract base |
| FR-CRM-10 | Customer interactions (calls, emails, visits) must be logged with Interaction_Type and non-empty Notes |
| FR-CRM-11 | Follow-up date must be a future date; past dates rejected |
| FR-CRM-12 | Customer search filters table in real-time by Institution_Name |
| FR-CRM-13 | Interaction timeline is displayed chronologically (newest first) |

### Black Box Test Cases — Module 3

| TC ID | Scenario | Input | Expected Output | Technique | Status |
|-------|----------|-------|-----------------|-----------|--------|
| BBT-CRM-001 | Add customer with all valid fields | Institution_Name='St. Luke's Medical Center', Email='stlukes@hospital.ph', Phone='09171234567', Segment_Type='HighValue' | Toast: 'Customer added successfully'; appears in customer list | EP Valid | Pass |
| BBT-CRM-002 | Add customer with invalid email format | Email='not-an-email' (no @ symbol) | Error: 'Invalid email address'; field highlighted; NOT saved | EP Invalid | Pass |
| BBT-CRM-003 | Add customer with duplicate email | Email='existing@hospital.ph' (already in DB) | Error: 'Email already exists!'; NOT inserted; form stays open | EP Invalid/Uniqueness | Pass |
| BBT-CRM-004 | Add customer with invalid phone (letters) | Phone='09AB-5678-XX' | Error: 'Invalid phone number'; field highlighted; NOT saved | Error Guessing | Pass |
| BBT-CRM-005 | Add customer with all required fields empty | Institution_Name='', Email='', Phone='' | Validation errors on all required fields; submit blocked | BVA | Pass |
| BBT-CRM-006 | Edit customer — no changes made | Open Edit for Customer_ID=5; change nothing → Update | Response: 'No changes were made'; DB unchanged | Boundary | Pass |
| BBT-CRM-007 | Edit customer — change to another customer's email | Email='taken@other.ph' (belongs to Customer_ID=3) | Error: 'Email already exists!'; update rejected; original preserved | EP Invalid | Pass |
| BBT-CRM-008 | Delete customer — OK clicked | Customer_ID=4 has no active quotations; confirm delete | Toast: 'Customer deleted'; soft-deleted; removed from active list | State Transition | Pass |
| BBT-CRM-009 | Delete customer — CANCEL clicked | Click delete → click Cancel | No changes; customer remains in list | Negative | Pass |
| BBT-CRM-010 | Search customer by institution name | Type 'Metro Clinic' in search bar | Table filters to only 'Metro Clinic'; others hidden | Workflow | Pass |
| BBT-CRM-011 | Create quotation with valid data | Template selected, 2 line items, Expiration_Date='2026-06-30', Status='Draft' | Quotation saved as Draft; auto-numbered 'QUO-2026-0015'; in pipeline | EP Valid | Pass |
| BBT-CRM-012 | Create quotation without selecting a customer | Customer field blank | Error: 'Customer is required'; Quotation NOT created | Boundary | Pass |
| BBT-CRM-013 | Update quotation status Draft → Sent | Status dropdown → 'Sent' → Update | Status updated to 'Sent'; pipeline stage advances; follow-up date visible | State Transition | Pass |
| BBT-CRM-014 | Log customer interaction (call) with valid data | Interaction_Type='Call', Notes='Discussed X-Ray pricing' | Interaction logged with timestamp; visible in timeline; toast shown | EP Valid | Pass |
| BBT-CRM-015 | Log interaction with empty Notes | Interaction_Type='Call', Notes='' | Validation error: 'Notes field is required'; interaction NOT saved | BVA | Pass |
| BBT-CRM-016 | Schedule follow-up with valid future date | Follow_Up_Date='2026-03-15', Notes='Send revised quote' | Follow-up created; visible in dashboard reminders widget; toast shown | EP Valid | Pass |
| BBT-CRM-017 | Schedule follow-up with past date | Follow_Up_Date='2025-01-01' | Error: 'Follow-up date must be in the future'; NOT saved | BVA/Error Guessing | Pass |
| BBT-CRM-018 | View customer interaction timeline | Customer_ID=7 has multiple interactions | All interactions listed chronologically; each shows timestamp, type, notes | Workflow | Pass |

### White Box Test Cases — Module 3

| TC ID | Feature | File / Code Path | Expected Output | Status |
|-------|---------|-----------------|-----------------|--------|
| WBT-CRM-001 | Customer Email Unique Constraint | `CustomerController::store()`: `if(Customer::where('Email',$email)->exists())` → throw ValidationException | exists()==true → HTTP 422; {error:'Email already exists'}; create NOT called | Pass |
| WBT-CRM-002 | ValidationService::isValidPhone() Regex | `ValidationService.php`: `return (bool)preg_match('/^[0-9]{10,11}$/', $phone)` | preg_match returns 0 → isValidPhone==false → HTTP 422; {error:'Invalid phone number'} | Pass |
| WBT-CRM-003 | Quotation Tax — Exclusive Calculation | `QuotationService::calculateTotals($subtotal,$taxRate,$inclusive)`: `if(!$inclusive){ $tax = $subtotal * ($taxRate/100); $total = $subtotal + $tax; }` | Subtotal=100000 → Tax=12000; Total=112000; both written to DB | Pass |
| WBT-CRM-004 | Quotation Tax — Inclusive Calculation | `if($inclusive){ $subtotal = $total / (1 + $taxRate/100); $taxAmount = $total - $subtotal; }` | Total=112000 → Subtotal=100000; TaxAmount=12000; consistent with inclusive VAT | Pass |
| WBT-CRM-005 | Quotation Status Transition Guard | `QuotationController::update()`: `$transitions=['Draft'=>['Sent','Pending'],'Sent'=>['Pending','Won','Lost']]`; `if(!in_array($newStatus,$transitions[$current]))` → return 422 | 'Won' not in Draft transitions → HTTP 422; {error:'Invalid status transition'}; Status unchanged | Pass |
| WBT-CRM-006 | Customer isDirty() — No-Change Guard | `CustomerController::update($id)`: `if(!$customer->isDirty()) return response('No changes were made.')` else → `$customer->save()` | isDirty()==false → 'No changes' returned; no DB write | Pass |
| WBT-CRM-007 | Interaction Notes Required | `validate(['Notes'=>'required\|string\|min:3'])` | Empty notes → HTTP 422; {errors:{Notes:['required']}} | Pass |
| WBT-CRM-008 | Follow-up Future Date Validation | `validate(['Follow_Up_Date'=>'required\|date\|after:today'])` | Past date → HTTP 422; {errors:{Follow_Up_Date:['after.today']}} | Pass |
| WBT-CRM-009 | Customer Soft Delete | `CustomerController::destroy($id)`: `$customer->delete()` (SoftDeletes trait) | deleted_at set; customer hidden from `Customer::all()`; row preserved | Pass |
| WBT-CRM-010 | Quotation Auto-Number Generation | `QuotationService::generateNumber()`: `'QUO-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT)` | Quotation_Number = 'QUO-2026-0015' assigned automatically | Pass |
| WBT-CRM-011 | Customer Type Enum Validation | `validate(['Customer_Type'=>'required\|in:Hospital,Clinic,Laboratory,Government,Private'])` | Invalid type → HTTP 422 | Pass |
| WBT-CRM-012 | Segment Type Enum Validation | `validate(['Segment_Type'=>'required\|in:HighValue,Regular,Occasional'])` | Invalid segment → HTTP 422 | Pass |
| WBT-CRM-013 | Edit — Unique Email Excluding Self | `validate(['Email'=>'required\|email\|unique:customers,Email,'.$id])` | Same email → passes; another customer's email → 422 | Pass |
| WBT-CRM-014 | Interaction Type Enum | `validate(['Interaction_Type'=>'required\|in:Call,Email,Visit,Meeting'])` | Invalid type → HTTP 422 | Pass |
| WBT-CRM-015 | Quotation Required Customer | `validate(['Customer_ID'=>'required\|exists:customers,id'])` | Missing customer → HTTP 422; {error:'Customer is required'} | Pass |

---

## Module 4 — Financial Management & Payment Tracking

**Laravel Components:** `FinancialController.php`, `PaymentController.php`, `InvoiceService.php`, `PaymentPlanService.php`, `Sale` model, `Invoice` model, `PaymentPlan` model.

**DB Tables:** `sales`, `invoices`, `payment_plans`, `payment_transactions`

### Functional Requirements

| FR-ID | Requirement |
|-------|-------------|
| FR-FIN-01 | Sales can be created from approved quotations; data pre-populated from quotation |
| FR-FIN-02 | Invoices are auto-generated from sales with unique invoice numbers |
| FR-FIN-03 | 12% VAT (Philippine standard) is applied to all invoices |
| FR-FIN-04 | Payment plans can be created for a sale with installment schedule |
| FR-FIN-05 | Payment recording requires Amount, Payment_Date, Payment_Method |
| FR-FIN-06 | Over-payment is blocked; amount cannot exceed outstanding balance |
| FR-FIN-07 | Payment status transitions: Unpaid → Partial → Paid (auto-calculated based on total paid) |
| FR-FIN-08 | Overdue invoices are flagged on dashboard based on due date comparison with today |
| FR-FIN-09 | Financial reports show total revenue, pending payments, overdue amounts |
| FR-FIN-010 | Payment amount must be positive numeric; zero or negative rejected |

### Black Box Test Cases — Module 4

| TC ID | Scenario | Input | Expected Output | Technique | Status |
|-------|----------|-------|-----------------|-----------|--------|
| BBT-FIN-001 | Create sale from approved quotation | Quotation_ID=5 (Status='Approved') → Convert to Sale | Sale created; Invoice auto-generated; status 'Unpaid' | EP Valid | Pass |
| BBT-FIN-002 | Record full payment for invoice | Amount = Total Invoice Amount | Invoice status → 'Paid'; receipt generated; balance = 0 | EP Valid | Pass |
| BBT-FIN-003 | Record partial payment | Amount < Total Invoice Amount | Status → 'Partial'; remaining balance updated | EP Valid | Pass |
| BBT-FIN-004 | Record over-payment | Amount > Outstanding Balance | Error: 'Amount exceeds outstanding balance'; NOT saved | BVA/Error Guessing | Pass |
| BBT-FIN-005 | Record payment with zero amount | Amount = 0 | Validation error: 'Amount must be greater than 0'; submit blocked | BVA | Pass |
| BBT-FIN-006 | Create payment plan with installments | 3 installments over 3 months | Payment plan created; schedule generated; due dates set | Workflow | Pass |
| BBT-FIN-007 | View overdue invoices on dashboard | Due date < today; status != 'Paid' | Overdue invoices flagged in red on dashboard widget | State Transition | Pass |
| BBT-FIN-008 | Generate financial summary report | Date range: Jan–Dec 2025 | Report shows total revenue, pending, overdue for period | Workflow | Pass |
| BBT-FIN-009 | Record payment with negative amount | Amount = -500 | Validation error: 'Invalid amount'; submit blocked | Error Guessing | Pass |
| BBT-FIN-010 | Invoice VAT calculation | Subtotal = 100000, VAT = 12% | VAT Amount = 12000; Total = 112000 displayed correctly | Equivalence | Pass |
| BBT-FIN-011 | Cancel payment recording | Fill form → click Cancel | Modal closes; no payment saved; balance unchanged | Negative | Pass |
| BBT-FIN-012 | Record payment without payment method | Payment_Method = '' | Validation error: 'Payment method is required'; submit blocked | BVA | Pass |
| BBT-FIN-013 | View payment history for invoice | Invoice_ID=7 | All payments listed with date, method, amount, running balance | Workflow | Pass |
| BBT-FIN-014 | Edit payment plan — change due date | Update installment due date | Updated due date saved; schedule refreshed | EP Valid | Pass |
| BBT-FIN-015 | Delete unpaid invoice | Invoice with no payments | Invoice soft-deleted; removed from active list | State Transition | Pass |
| BBT-FIN-016 | Auto-generate invoice number | New sale created | Invoice number auto-assigned: 'INV-2026-0023' | EP Valid | Pass |

### White Box Test Cases — Module 4

| TC ID | Feature | Code Path / Branch | Expected Output | Status |
|-------|---------|-------------------|-----------------|--------|
| WBT-FIN-001 | Over-payment Guard Branch | `PaymentController::store()`: `if($amount > $invoice->Outstanding_Balance)` → abort with error | Error: 'Amount exceeds balance'; NOT saved | Pass |
| WBT-FIN-002 | Payment Status Auto-Update | After payment: `$total_paid = $invoice->payments->sum('Amount')` → `if($total_paid >= $invoice->Total_Amount)` → Status='Paid' else if `$total_paid > 0` → Status='Partial' | Status transitions correctly based on cumulative payments | Pass |
| WBT-FIN-003 | VAT Exclusive Calculation | `$vat = $subtotal * 0.12; $total = $subtotal + $vat` | VAT and Total written correctly to invoices table | Pass |
| WBT-FIN-004 | Amount Positive Validation | `validate(['Amount'=>'required\|numeric\|min:0.01'])` | Amount=0 or negative → HTTP 422; {errors:{Amount:['min.0.01']}} | Pass |
| WBT-FIN-005 | Invoice Number Auto-Generation | `InvoiceService::generateNumber()`: `'INV-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT)` | Auto-assigned unique invoice number | Pass |
| WBT-FIN-006 | Sale from Quotation — Data Pre-population | `Sale::create(['Customer_ID'=>$quot->Customer_ID, 'Total'=>$quot->Total_Amount, ...])` | All quotation fields mapped correctly to sale record | Pass |
| WBT-FIN-007 | Overdue Flag Query | `Invoice::where('Due_Date','<',Carbon::today())->where('Status','!=','Paid')->get()` | Returns only overdue, unpaid invoices | Pass |
| WBT-FIN-008 | Payment Plan Installment Generation | Loop: `for($i=0;$i<$count;$i++) PaymentInstallment::create(['Due_Date'=>Carbon::now()->addMonths($i+1), ...])` | Correct number of installment records created with sequential due dates | Pass |
| WBT-FIN-009 | Payment Required Field Validation | `validate(['Amount'=>'required\|numeric\|min:0.01', 'Payment_Date'=>'required\|date', 'Payment_Method'=>'required\|string'])` | All three required → HTTP 422 if any missing | Pass |
| WBT-FIN-010 | Outstanding Balance Calculation | `$outstanding = $invoice->Total_Amount - $invoice->payments->sum('Amount')` | Balance updates correctly after each payment | Pass |
| WBT-FIN-011 | Invoice Soft Delete | `Invoice::findOrFail($id)->delete()` (SoftDeletes) | deleted_at set; invoice hidden from active list; row preserved | Pass |
| WBT-FIN-012 | Revenue Report Query | `Sale::whereBetween('created_at',[$start,$end])->sum('Total_Amount')` | Aggregated total for date range returned | Pass |
| WBT-FIN-013 | Payment Method Enum | `validate(['Payment_Method'=>'required\|in:Cash,BankTransfer,Cheque,OnlinePayment'])` | Invalid method → HTTP 422 | Pass |
| WBT-FIN-014 | Quotation Status Guard on Sale | `if($quotation->Status !== 'Approved') abort(422,'Quotation not approved')` | Non-approved quotation cannot be converted to sale | Pass |
| WBT-FIN-015 | Partial Status Branch | `elseif($total_paid > 0 && $total_paid < $invoice->Total_Amount)` → `Status='Partial'` | Status correctly set to 'Partial' for partial payments | Pass |

---

## Module 5 — Document Management

**Laravel Components:** `DocumentController.php`, `TemplateController.php`, `DocumentService.php`, `Document` model, `DocumentTemplate` model.

**DB Tables:** `documents`, `document_templates`

**Supported Types:** Quotation PDFs, Delivery Receipts, Purchase Orders, Company Letterheads

### Functional Requirements

| FR-ID | Requirement |
|-------|-------------|
| FR-DOC-01 | Document templates can be created, edited, and versioned |
| FR-DOC-02 | Documents can be generated from templates with variable substitution |
| FR-DOC-03 | Generated documents are stored with File_Extension and MIME_Type fields |
| FR-DOC-04 | Documents can be downloaded in PDF format |
| FR-DOC-05 | Template names must be unique per document type |
| FR-DOC-06 | Document upload accepts only PDF, DOCX, and image formats |
| FR-DOC-07 | File size limit enforced (max: 10MB) |
| FR-DOC-08 | Documents can be associated with a Customer, Sale, or Quotation |
| FR-DOC-09 | Documents can be soft-deleted (recovered if needed) |
| FR-DOC-010 | Version history is tracked for templates (version number increments on edit) |

### Black Box Test Cases — Module 5

| TC ID | Scenario | Input | Expected Output | Technique | Status |
|-------|----------|-------|-----------------|-----------|--------|
| BBT-DOC-001 | Create document template with valid data | Template_Name='Standard Quotation', Type='Quotation' | Template saved; version 1 assigned; visible in template list | EP Valid | Pass |
| BBT-DOC-002 | Create template with duplicate name + type | Same Template_Name and Document_Type as existing | Error: 'Template name already exists for this type'; NOT saved | EP Invalid | Pass |
| BBT-DOC-003 | Generate document from template | Select Template → Fill variables → Generate | Document generated with correct variable substitution; saved | Workflow | Pass |
| BBT-DOC-004 | Upload document — valid PDF | File: 'delivery_receipt.pdf', size 2MB | File stored; MIME_Type='application/pdf'; visible in documents list | EP Valid | Pass |
| BBT-DOC-005 | Upload document — invalid format | File: 'report.exe' | Error: 'Invalid file type. Accepted: PDF, DOCX, images'; NOT uploaded | Error Guessing | Pass |
| BBT-DOC-006 | Upload document — file too large | File: 25MB PDF | Error: 'File size exceeds 10MB limit'; NOT uploaded | BVA | Pass |
| BBT-DOC-007 | Download document as PDF | Click download for Document_ID=3 | PDF file downloaded; filename and content correct | Workflow | Pass |
| BBT-DOC-008 | Edit template — version increments | Edit template body → Save | Template updated; version number increments (e.g., v1 → v2) | State Transition | Pass |
| BBT-DOC-009 | Associate document with quotation | Attach Document_ID=5 to Quotation_ID=8 | Document linked; visible in quotation's document tab | Workflow | Pass |
| BBT-DOC-010 | Delete document — soft delete | Click delete → confirm | Document soft-deleted; removed from active list; recoverable | State Transition | Pass |
| BBT-DOC-011 | Create template with empty name | Template_Name='' | Validation error: 'Template name is required'; NOT saved | BVA | Pass |
| BBT-DOC-012 | Search documents by filename | Type 'Quotation 2026' in search | Matching documents filtered and displayed | Workflow | Pass |
| BBT-DOC-013 | View document preview | Click preview for Document_ID=6 | Document renders in modal or iframe for quick review | Workflow | Pass |
| BBT-DOC-014 | Cancel document upload | Start upload → click Cancel | Upload cancelled; no file stored; no DB record created | Negative | Pass |
| BBT-DOC-015 | Upload document — exactly 10MB | File exactly 10MB | File accepted and stored (boundary: max allowed) | BVA | Pass |
| BBT-DOC-016 | Upload document — 10.01MB | File 10.01MB | Error: 'File size exceeds 10MB limit' | BVA | Pass |

### White Box Test Cases — Module 5

| TC ID | Feature | Code Path / Branch | Expected Output | Status |
|-------|---------|-------------------|-----------------|--------|
| WBT-DOC-001 | Template Unique Name+Type Check | `store()`: `DocumentTemplate::where('Template_Name',$name)->where('Document_Type',$type)->exists()` → abort if true | exists()==true → HTTP 422; {error:'Template name exists for this type'} | Pass |
| WBT-DOC-002 | File Type Validation | `validate(['file'=>'required\|mimes:pdf,docx,jpg,png,jpeg\|max:10240'])` | Invalid mime → HTTP 422; {errors:{file:['mimes validation']}} | Pass |
| WBT-DOC-003 | File Size Boundary Branch | `'max:10240'` (10MB in KB) → if file > 10240KB → ValidationException | File > 10MB → HTTP 422; {errors:{file:['max.10240']}} | Pass |
| WBT-DOC-004 | MIME_Type Storage | `store()`: `$document->MIME_Type = $file->getClientMimeType(); $document->File_Extension = $file->getClientOriginalExtension()` | MIME_Type='application/pdf'; File_Extension='pdf' stored in DB | Pass |
| WBT-DOC-005 | Template Version Increment | `update()`: `$template->Version = $template->Version + 1; $template->save()` | Version increments by 1 on every edit; stored to DB | Pass |
| WBT-DOC-006 | Variable Substitution in Document Generation | `DocumentService::generate($template, $vars)`: `str_replace(array_keys($vars), array_values($vars), $template->Body)` | All {{placeholders}} replaced with actual values | Pass |
| WBT-DOC-007 | Document Soft Delete | `Document::findOrFail($id)->delete()` (SoftDeletes) | deleted_at set; document hidden; row preserved | Pass |
| WBT-DOC-008 | PDF Download Response | `return response()->download(storage_path('app/'.$doc->File_Path), $doc->File_Name, ['Content-Type'=>'application/pdf'])` | File streamed as attachment download | Pass |
| WBT-DOC-009 | Document-Quotation Association | `DocumentQuotation::create(['Document_ID'=>$docId, 'Quotation_ID'=>$quotId])` | Pivot record created; document appears in quotation's documents tab | Pass |
| WBT-DOC-010 | Template Name Required | `validate(['Template_Name'=>'required\|string\|max:255'])` | Empty name → HTTP 422; {errors:{Template_Name:['required']}} | Pass |
| WBT-DOC-011 | File Storage Path | `$path = $file->store('documents', 'local')` → `$document->File_Path = $path` | File stored in storage/app/documents/; path saved to DB | Pass |
| WBT-DOC-012 | Document Type Enum | `validate(['Document_Type'=>'required\|in:Quotation,DeliveryReceipt,PurchaseOrder,Letterhead'])` | Invalid type → HTTP 422 | Pass |
| WBT-DOC-013 | Search Query Branch | `Document::where('File_Name','like',"%{$search}%")->get()` | Filtered results matching search term returned | Pass |
| WBT-DOC-014 | Cancel Upload — No DB Write | Cancel button triggers JS modal close; no form POST sent | No file saved; no DB record created | Pass |
| WBT-DOC-015 | Exactly 10MB File (Boundary Pass) | File = 10240KB exactly → passes `max:10240` | File accepted; stored successfully | Pass |

---

## Module 6 — Integration & Cross-Module Flows

### Functional Requirements

| FR-ID | Requirement |
|-------|-------------|
| FR-INT-01 | End-to-end flow: Inquiry → Quotation → Sale → Invoice → Payment must preserve data integrity |
| FR-INT-02 | CRM sale creation must trigger real-time inventory decrement |
| FR-INT-03 | Data must sync across modules without lag (real-time, < 2 seconds) |
| FR-INT-04 | Complete audit trail must exist across all module transitions |
| FR-INT-05 | Inventory level must remain consistent when accessed by multiple modules simultaneously |
| FR-INT-06 | System must handle concurrent requests without race conditions on stock updates |

### Integration Test Cases

| TC ID | Scenario | Test Steps | Expected Output | Status |
|-------|----------|-----------|-----------------|--------|
| BBT-INT-001 | End-to-End: Inquiry to Payment | 1. Customer submits inquiry → 2. Create quotation → 3. Convert to sale → 4. Generate invoice → 5. Record payment | Data flows through all systems; no data loss; complete audit trail | Pass |
| BBT-INT-002 | Real-time Stock Sync Between Systems | 1. CRM creates sale → 2. Check inventory levels → 3. Verify real-time update | Sale reduced stock within 1 second; accurate across all modules | Pass |
| BBT-INT-003 | Quotation → Invoice Data Carryover | Convert approved quotation to invoice | All customer, product, and pricing data correctly transferred | Pass |
| BBT-INT-004 | Financial Report Reflects Inventory Changes | Record Stock In → Check financial report | Revenue and inventory values consistent between modules | Pass |
| BBT-INT-005 | Document Generation from CRM Quotation | Create quotation in CRM → Generate PDF document | PDF generated with correct quotation data from CRM | Pass |
| BBT-INT-006 | Multi-Module Dashboard Data Accuracy | Load Admin Dashboard | All widgets (revenue, stock alerts, pending quotations, follow-ups) show accurate real-time data | Pass |

---

## Global Validation Rules (All Modules)

| Field Type | Validation Rule |
|-----------|----------------|
| Required text | `required\|string\|max:255` |
| Email | `required\|email\|unique:table,Email` |
| Phone | `required\|regex:/^[0-9]{10,11}$/` |
| Positive price | `required\|numeric\|min:0` |
| Positive quantity | `required\|integer\|min:1` |
| Future date | `required\|date\|after:today` |
| File upload | `required\|mimes:pdf,docx,jpg,png\|max:10240` |
| Password | `required\|string\|min:8` |
| Enum fields | `required\|in:Value1,Value2,...` |

---

## Database Schema Key Constraints

- All primary tables use `id` (auto-increment, primary key)
- Soft deletes: `users`, `customers`, `products`, `quotations`, `invoices`, `documents`
- Unique constraints: `users.Email`, `customers.Email`, `products.Product_Code`
- All enums use **PascalCase** (no spaces, no hyphens)
- Standard timestamps: `created_at`, `updated_at` (Laravel auto-managed)
- VAT: Philippine standard at **12%** applies to all financial calculations
- Currency: Dual pricing — `Unit_Price_PHP` and `Unit_Price_USD`

---

*Document compiled from: RozMed_Test_Cases_BlackBox_WhiteBox.docx, RozMed_Detailed_BlackBox_WhiteBox_TestCases.docx, RozMed_BlackBox_WhiteBox_TestCases_Final.docx, RozMed_BlackBox_WhiteBox_TestCases_Final_v2.docx, RozMed_Comprehensive_TestCases_v3.docx, RozMed_Comprehensive_TestCases_v4.docx*
