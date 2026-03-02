# RozMed — Module-by-Module Implementation Guide
**Step-by-step instructions for applying each functional requirement in Laravel**

> Use this guide alongside `RozMed_Master_Functional_Specification.md`.
> Each section gives you the exact files to create/edit, the code patterns to apply, and a checklist to tick off.

---

## How to Use This Guide

1. Pick a module (start with **Module 0 — Auth**, it's required by all others)
2. Follow the steps in order — each step has a **What**, **Where**, and **How**
3. After implementing, run the listed test cases from the spec to verify
4. Check off the ✅ checklist items before moving to the next module

---

## Module 0 — User Authentication & Access Control

### Step 0.1 — Set Up the Users Table Migration

**What:** Create the `users` table with all required fields and constraints.

**Where:** `database/migrations/xxxx_create_users_table.php`

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('Username')->unique();
    $table->string('Email')->unique();     // FR-AUTH-10: unique email
    $table->string('Password');
    $table->enum('Role', ['Admin','SalesStaff','FinanceStaff','InventoryManager','SystemAdmin']);
    $table->softDeletes();
    $table->timestamps();
});
```

**Test Cases to verify:** BBT-AUTH-011, BBT-AUTH-012, WBT-AUTH-008, WBT-AUTH-010

---

### Step 0.2 — Implement the Login Controller

**What:** `AuthController.php` with `login()` and `logout()` methods.

**Where:** `app/Http/Controllers/AuthController.php`

```php
public function login(Request $request) {
    $request->validate([
        'Username' => 'required',
        'Password' => 'required',
    ]);

    $user = User::where('Username', $request->Username)->first();

    // FR-AUTH-02: same error for wrong password AND non-existent user (no enumeration)
    if (!$user || !Hash::check($request->Password, $user->Password)) {
        return back()->withErrors(['login' => 'Invalid credentials. Please try again.']);
    }

    Auth::login($user);
    $request->session()->regenerate();  // FR-AUTH-04: prevent session fixation
    return redirect()->intended('/dashboard');
}

public function logout(Request $request) {
    Auth::logout();
    $request->session()->invalidate();      // FR-AUTH-05
    $request->session()->regenerateToken(); // FR-AUTH-05
    return redirect('/login');
}
```

**Test Cases to verify:** BBT-AUTH-001 through BBT-AUTH-008, WBT-AUTH-001 through WBT-AUTH-006

---

### Step 0.3 — Implement Role-Based Access Middleware

**What:** Middleware that checks role and blocks unauthorized routes.

**Where:** `app/Http/Middleware/CheckRole.php`

```php
public function handle(Request $request, Closure $next, ...$roles) {
    if (!Auth::check()) return redirect('/login');

    if (!in_array(Auth::user()->Role, $roles)) {
        abort(403, 'Unauthorized Action');  // FR-AUTH-07
    }

    return $next($request);
}
```

**Register in:** `app/Http/Kernel.php` under `$routeMiddleware`:
```php
'role' => \App\Http\Middleware\CheckRole::class,
```

**Use in routes:**
```php
Route::middleware(['auth', 'role:Admin'])->group(function() {
    Route::get('/admin/users', [UserController::class, 'index']);
});
```

**Test Cases to verify:** BBT-AUTH-007, BBT-AUTH-009, WBT-AUTH-004, WBT-AUTH-005

---

### Step 0.4 — Implement User Creation (Admin Only)

**What:** Admin can create new users with password hashing and validation.

**Where:** `app/Http/Controllers/UserController.php`

```php
public function store(Request $request) {
    $request->validate([
        'Username'  => 'required|string|max:255|unique:users',
        'Email'     => 'required|email|unique:users,Email',  // FR-AUTH-10
        'Password'  => 'required|string|min:8',              // FR-AUTH-09
        'Role'      => 'required|in:Admin,SalesStaff,FinanceStaff,InventoryManager,SystemAdmin', // FR-AUTH-11
    ]);

    User::create([
        'Username' => $request->Username,
        'Email'    => $request->Email,
        'Password' => Hash::make($request->Password),  // FR-AUTH-09: hash before storing
        'Role'     => $request->Role,
    ]);

    return redirect()->back()->with('success', 'User created successfully.');
}
```

**Test Cases to verify:** BBT-AUTH-011, BBT-AUTH-012, WBT-AUTH-007, WBT-AUTH-008, WBT-AUTH-010

---

### ✅ Module 0 Checklist

- [ ] `users` migration created and run (`php artisan migrate`)
- [ ] `AuthController::login()` with Hash::check and session regeneration
- [ ] `AuthController::logout()` with session invalidation + token regeneration
- [ ] `CheckRole` middleware registered and applied to protected routes
- [ ] `UserController::store()` with min:8 password and unique email validation
- [ ] Login form at `resources/views/auth/login.blade.php` with error display
- [ ] Role-based dashboard menu rendering (show/hide nav items per role)

---

## Module 1 — Product Catalog Management

### Step 1.1 — Products Table Migration

**Where:** `database/migrations/xxxx_create_products_table.php`

```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('Product_Code')->unique();  // FR-PC-08
    $table->string('Product_Name');
    $table->enum('Category', [
        'DiagnosticEquipment','MedicalInstruments','MonitoringDevices',
        'EmergencyEquipment','InfusionSystems','LaboratoryEquipment'
    ]);
    $table->decimal('Unit_Price_PHP', 12, 2);
    $table->decimal('Unit_Price_USD', 10, 2)->nullable();
    $table->text('Description')->nullable();
    $table->string('product_image')->nullable();
    $table->enum('Status', ['Active','Inactive','Discontinued'])->default('Active'); // FR-PC-12
    $table->integer('Current_Stock')->default(0);
    $table->softDeletes();  // FR-PC-10
    $table->timestamps();
});
```

---

### Step 1.2 — Product Model with Active Scope

**Where:** `app/Models/Product.php`

```php
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
    use SoftDeletes;

    // FR-PC-12: only show Active products to clients
    public function scopeActive($query) {
        return $query->where('Status', 'Active');
    }
}
```

---

### Step 1.3 — ProductController CRUD

**Where:** `app/Http/Controllers/ProductController.php`

```php
// INDEX — client-facing catalog (Active only + search)
public function index(Request $request) {
    $query = Product::active();
    if ($request->search) {
        $query->where('Product_Name', 'like', "%{$request->search}%");  // FR-PC-02
    }
    $products = $query->paginate(12);  // FR-PC-01
    return view('products.index', compact('products'));
}

// STORE — admin adds product
public function store(Request $request) {
    $request->validate([
        'Product_Name'    => 'required|string|max:255',
        'Product_Code'    => 'required|string|unique:products,Product_Code',  // FR-PC-08
        'Category'        => 'required|in:DiagnosticEquipment,MedicalInstruments,MonitoringDevices,EmergencyEquipment,InfusionSystems,LaboratoryEquipment',
        'Unit_Price_PHP'  => 'required|numeric|min:0',  // FR-PC-11
        'product_image'   => 'required|image|mimes:jpg,png,jpeg|max:2048',  // FR-PC-07
        'Status'          => 'required|in:Active,Inactive,Discontinued',
    ]);

    // FR-PC-13: category mapping (if UI sends lowercase)
    $categoryMap = [
        'diagnostic_equipment' => 'DiagnosticEquipment',
        'medical_instruments'  => 'MedicalInstruments',
        // ... etc
    ];
    $category = $categoryMap[$request->Category] ?? $request->Category;

    $imagePath = $request->file('product_image')->store('products', 'public');

    Product::create(array_merge($request->validated(), [
        'Category'      => $category,
        'product_image' => $imagePath,
    ]));

    return back()->with('success', 'Product added successfully.');
}

// DESTROY — soft delete
public function destroy($id) {
    Product::findOrFail($id)->delete();  // FR-PC-10: soft delete
    return back()->with('success', 'Product deleted.');
}
```

**Test Cases to verify:** BBT-PC-001 through BBT-PC-018, all WBT-PC cases

---

### Step 1.4 — Inquiry Controller

**Where:** `app/Http/Controllers/InquiryController.php`

```php
public function store(Request $request) {
    $request->validate([
        'Name'    => 'required|string|max:255',
        'Email'   => 'required|email',           // FR-PC-05
        'Phone'   => 'required|string',
        'Message' => 'required|string',
    ]);

    $inquiry = Inquiry::create($request->validated());
    $refNumber = 'INQ-' . date('Y') . '-' . str_pad($inquiry->id, 4, '0', STR_PAD_LEFT);
    $inquiry->update(['Reference_Number' => $refNumber]);

    return back()->with('success', "Inquiry submitted. Reference: {$refNumber}");
}
```

---

### ✅ Module 1 Checklist

- [ ] `products` table migration with unique Product_Code, Status enum, softDeletes
- [ ] `Product` model with `SoftDeletes` trait and `scopeActive()` method
- [ ] `ProductController::index()` with search and Active scope filter
- [ ] `ProductController::store()` with all validations including image required
- [ ] `ProductController::destroy()` using soft delete
- [ ] Category mapping layer (UI input → DB enum)
- [ ] `InquiryController::store()` with email validation and reference number
- [ ] Client-facing product catalog view with search bar
- [ ] Admin panel for product CRUD
- [ ] "No results found" message on empty search results

---

## Module 2 — Inventory Management

### Step 2.1 — Inventory Transactions Table Migration

**Where:** `database/migrations/xxxx_create_inventory_transactions_table.php`

```php
Schema::create('inventory_transactions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('Product_ID')->constrained('products');
    $table->enum('Transaction_Type', ['StockIn','StockOut','Transfer','Adjustment','Return']);
    $table->integer('Quantity');
    $table->decimal('Unit_Price_At_Transaction', 12, 2)->nullable();
    $table->decimal('Total_Value', 14, 2)->nullable();  // FR-INV-08: auto-calculated
    $table->text('Reason');
    $table->string('Source_Location')->nullable();
    $table->string('Destination_Location')->nullable();
    $table->timestamps();
});
```

---

### Step 2.2 — InventoryController with Business Rules

**Where:** `app/Http/Controllers/InventoryController.php`

```php
public function store(Request $request) {
    $request->validate([
        'Product_ID'       => 'required|exists:products,id',
        'Transaction_Type' => 'required|in:StockIn,StockOut,Transfer,Adjustment,Return',
        'Quantity'         => 'required|integer|min:1',          // FR-INV-04 (quantity)
        'Reason'           => 'required|string|min:3',           // FR-INV-04 (reason)
        'Unit_Price_At_Transaction' => 'nullable|numeric|min:0',
    ]);

    $product = Product::findOrFail($request->Product_ID);
    $qty     = $request->Quantity;
    $type    = $request->Transaction_Type;

    // FR-INV-02: Zero-stock guard
    if ($type === 'StockOut' && $product->Current_Stock <= 0) {
        return response()->json(['error' => "Invalid action: product [{$product->Product_Name}] has 0 stocks."], 422);
    }

    // FR-INV-03: Insufficient stock guard
    if ($type === 'StockOut' && $qty > $product->Current_Stock) {
        return response()->json(['error' => "Insufficient stock. Available: {$product->Current_Stock}"], 422);
    }

    // FR-INV-06: Transfer same-location guard
    if ($type === 'Transfer' && $request->Source_Location === $request->Destination_Location) {
        return response()->json(['error' => 'Source and destination cannot be the same.'], 422);
    }

    // FR-INV-08: Auto-calculate Total_Value
    $unitPrice  = $request->Unit_Price_At_Transaction ?? $product->Unit_Price_PHP;
    $totalValue = $qty * $unitPrice;

    // Record transaction
    InventoryTransaction::create(array_merge($request->validated(), [
        'Unit_Price_At_Transaction' => $unitPrice,
        'Total_Value'               => $totalValue,
    ]));

    // Update Current_Stock
    if (in_array($type, ['StockIn', 'Return']))    $product->Current_Stock += $qty;
    if ($type === 'StockOut')                       $product->Current_Stock -= $qty;
    if ($type === 'Adjustment')                     $product->Current_Stock  = $qty;
    $product->save();

    // FR-INV-07: Replenishment alert
    if ($product->Current_Stock < ($product->Min_Stock_Level ?? 5)) {
        Alert::create(['Product_ID' => $product->id, 'Type' => 'Replenishment', 'Message' => "Low stock: {$product->Product_Name}"]);
    }

    return response()->json(['success' => 'Stock transaction recorded successfully.']);
}
```

**Test Cases to verify:** BBT-INV-001 through BBT-INV-018, all WBT-INV cases

---

### ✅ Module 2 Checklist

- [ ] `inventory_transactions` migration with Transaction_Type enum, Total_Value field
- [ ] Add `Current_Stock` and `Min_Stock_Level` to `products` table
- [ ] `InventoryController::store()` with zero-stock guard
- [ ] Insufficient stock guard (StockOut qty > Current_Stock)
- [ ] Total_Value auto-calculation (Qty × Unit_Price)
- [ ] Current_Stock update after each transaction type
- [ ] Replenishment alert auto-generation when stock < minimum
- [ ] Transfer same-location guard
- [ ] Aging inventory report query (by last_received_at threshold)
- [ ] Cancel button closes modal without saving

---

## Module 3 — Customer Management (CRM)

### Step 3.1 — Customers Table Migration

**Where:** `database/migrations/xxxx_create_customers_table.php`

```php
Schema::create('customers', function (Blueprint $table) {
    $table->id();
    $table->string('Institution_Name');
    $table->enum('Customer_Type', ['Hospital','Clinic','Laboratory','Government','Private']);
    $table->string('Email')->unique();           // FR-CRM-02
    $table->string('Phone');
    $table->enum('Segment_Type', ['HighValue','Regular','Occasional']);
    $table->softDeletes();
    $table->timestamps();
});
```

---

### Step 3.2 — CustomerController with Validation

**Where:** `app/Http/Controllers/CustomerController.php`

```php
public function store(Request $request) {
    $request->validate([
        'Institution_Name' => 'required|string|max:255',
        'Customer_Type'    => 'required|in:Hospital,Clinic,Laboratory,Government,Private',
        'Email'            => 'required|email|unique:customers,Email',  // FR-CRM-02
        'Phone'            => ['required', 'regex:/^[0-9]{10,11}$/'],   // FR-CRM-03
        'Segment_Type'     => 'required|in:HighValue,Regular,Occasional',
    ]);

    Customer::create($request->validated());
    return back()->with('success', 'Customer added successfully.');
}

public function update(Request $request, $id) {
    $customer = Customer::findOrFail($id);

    $request->validate([
        'Email' => 'required|email|unique:customers,Email,' . $id,  // exclude self
        'Phone' => ['required', 'regex:/^[0-9]{10,11}$/'],
    ]);

    $customer->fill($request->validated());

    if (!$customer->isDirty()) {               // FR-CRM-04
        return back()->with('info', 'No changes were made.');
    }

    $customer->save();
    return back()->with('success', 'Customer updated.');
}

public function destroy($id) {
    Customer::findOrFail($id)->delete();        // FR-CRM-05: soft delete
    return back()->with('success', 'Customer deleted successfully.');
}
```

---

### Step 3.3 — Quotation Controller with Status Guard

**Where:** `app/Http/Controllers/QuotationController.php`

```php
// FR-CRM-08: Define allowed status transitions
private array $transitions = [
    'Draft'   => ['Sent', 'Pending'],
    'Sent'    => ['Pending', 'Won', 'Lost'],
    'Pending' => ['Won', 'Lost'],
];

public function updateStatus(Request $request, $id) {
    $quotation  = Quotation::findOrFail($id);
    $newStatus  = $request->Status;
    $current    = $quotation->Status;

    if (!in_array($newStatus, $this->transitions[$current] ?? [])) {
        return response()->json(['error' => 'Invalid status transition.'], 422);
    }

    $quotation->update(['Status' => $newStatus]);
    return response()->json(['success' => 'Status updated.']);
}
```

---

### Step 3.4 — VAT Calculation Service

**Where:** `app/Modules/Customer/Services/QuotationService.php`

```php
public function calculateTotals(float $subtotal, float $taxRate = 12, bool $inclusive = false): array {
    if ($inclusive) {
        // FR-CRM-09: Inclusive — extract base from total
        $base      = $subtotal / (1 + $taxRate / 100);
        $taxAmount = $subtotal - $base;
        return ['subtotal' => round($base, 2), 'tax' => round($taxAmount, 2), 'total' => $subtotal];
    } else {
        // FR-CRM-09: Exclusive — add tax to base
        $tax   = $subtotal * ($taxRate / 100);
        $total = $subtotal + $tax;
        return ['subtotal' => $subtotal, 'tax' => round($tax, 2), 'total' => round($total, 2)];
    }
}
```

---

### ✅ Module 3 Checklist

- [ ] `customers` migration with unique Email and softDeletes
- [ ] `quotations` migration with Status enum and Quotation_Number
- [ ] `customer_interactions` table (Interaction_Type, Notes, timestamps)
- [ ] `follow_ups` table (Follow_Up_Date, Notes, Customer_ID)
- [ ] `CustomerController::store()` with unique email + phone regex
- [ ] `CustomerController::update()` with isDirty() guard and self-exclude email unique
- [ ] `CustomerController::destroy()` soft delete
- [ ] `QuotationController::updateStatus()` with transition guard map
- [ ] `QuotationService::calculateTotals()` for both inclusive and exclusive VAT
- [ ] Quotation auto-number generation (QUO-YYYY-NNNN)
- [ ] Future date validation on follow-ups (`after:today`)
- [ ] Notes required on interaction logging

---

## Module 4 — Financial Management & Payment Tracking

### Step 4.1 — Tables Migration

**Where:** Create separate migrations for `sales`, `invoices`, `payment_plans`, `payment_transactions`

```php
// invoices table key fields:
$table->decimal('Subtotal', 12, 2);
$table->decimal('VAT_Amount', 10, 2);
$table->decimal('Total_Amount', 12, 2);
$table->decimal('Outstanding_Balance', 12, 2);
$table->enum('Status', ['Unpaid', 'Partial', 'Paid']);
$table->date('Due_Date');
$table->string('Invoice_Number')->unique();
```

---

### Step 4.2 — PaymentController with Guards

**Where:** `app/Http/Controllers/PaymentController.php`

```php
public function store(Request $request, $invoiceId) {
    $request->validate([
        'Amount'         => 'required|numeric|min:0.01',            // FR-FIN-10
        'Payment_Date'   => 'required|date',
        'Payment_Method' => 'required|in:Cash,BankTransfer,Cheque,OnlinePayment',
    ]);

    $invoice = Invoice::findOrFail($invoiceId);

    // FR-FIN-06: Over-payment guard
    if ($request->Amount > $invoice->Outstanding_Balance) {
        return back()->withErrors(['Amount' => 'Amount exceeds outstanding balance.']);
    }

    // Record payment
    PaymentTransaction::create([
        'Invoice_ID'     => $invoiceId,
        'Amount'         => $request->Amount,
        'Payment_Date'   => $request->Payment_Date,
        'Payment_Method' => $request->Payment_Method,
    ]);

    // FR-FIN-07: Auto-update invoice status
    $totalPaid  = $invoice->transactions()->sum('Amount');
    $newBalance = $invoice->Total_Amount - $totalPaid;

    $status = 'Unpaid';
    if ($totalPaid >= $invoice->Total_Amount) $status = 'Paid';
    elseif ($totalPaid > 0)                   $status = 'Partial';

    $invoice->update(['Outstanding_Balance' => $newBalance, 'Status' => $status]);

    return back()->with('success', 'Payment recorded.');
}
```

---

### Step 4.3 — Invoice Auto-Number & VAT

```php
// InvoiceService.php
public function createFromSale(Sale $sale): Invoice {
    $number = 'INV-' . date('Y') . '-' . str_pad(Invoice::count() + 1, 4, '0', STR_PAD_LEFT);
    $vat    = $sale->Subtotal * 0.12;                      // FR-FIN-03: 12% VAT
    $total  = $sale->Subtotal + $vat;

    return Invoice::create([
        'Sale_ID'         => $sale->id,
        'Invoice_Number'  => $number,                      // FR-FIN-02
        'Subtotal'        => $sale->Subtotal,
        'VAT_Amount'      => $vat,
        'Total_Amount'    => $total,
        'Outstanding_Balance' => $total,
        'Status'          => 'Unpaid',
        'Due_Date'        => now()->addDays(30),
    ]);
}
```

---

### ✅ Module 4 Checklist

- [ ] `sales`, `invoices`, `payment_plans`, `payment_transactions` migrations
- [ ] `PaymentController::store()` with over-payment guard
- [ ] Auto-update invoice Status (Unpaid → Partial → Paid) after each payment
- [ ] Outstanding_Balance recalculated after each payment
- [ ] Invoice auto-number generation (INV-YYYY-NNNN)
- [ ] VAT calculation at 12% (Philippine standard)
- [ ] `Sale::createFromQuotation()` with status guard (must be Approved)
- [ ] Overdue invoice query for dashboard widget
- [ ] Payment plan installment schedule generation
- [ ] Financial report with date range filter

---

## Module 5 — Document Management

### Step 5.1 — Documents & Templates Tables

```php
// document_templates table
$table->string('Template_Name');
$table->enum('Document_Type', ['Quotation','DeliveryReceipt','PurchaseOrder','Letterhead']);
$table->text('Body');
$table->integer('Version')->default(1);       // FR-DOC-010
$table->unique(['Template_Name', 'Document_Type']); // FR-DOC-05

// documents table
$table->string('File_Name');
$table->string('File_Path');
$table->string('File_Extension');             // FR-DOC-03
$table->string('MIME_Type');                  // FR-DOC-03
$table->unsignedBigInteger('Customer_ID')->nullable();
$table->softDeletes();                        // FR-DOC-09
```

---

### Step 5.2 — DocumentController

**Where:** `app/Http/Controllers/DocumentController.php`

```php
public function upload(Request $request) {
    $request->validate([
        'file'          => 'required|mimes:pdf,docx,jpg,png,jpeg|max:10240', // FR-DOC-06, FR-DOC-07
        'Document_Type' => 'required|in:Quotation,DeliveryReceipt,PurchaseOrder,Letterhead',
    ]);

    $file = $request->file('file');
    $path = $file->store('documents', 'local');

    Document::create([
        'File_Name'      => $file->getClientOriginalName(),
        'File_Path'      => $path,
        'File_Extension' => $file->getClientOriginalExtension(),  // FR-DOC-03
        'MIME_Type'      => $file->getClientMimeType(),           // FR-DOC-03
        'Document_Type'  => $request->Document_Type,
    ]);

    return back()->with('success', 'Document uploaded.');
}

public function download($id) {
    $doc = Document::findOrFail($id);
    return response()->download(
        storage_path('app/' . $doc->File_Path),
        $doc->File_Name,
        ['Content-Type' => $doc->MIME_Type]
    );
}
```

---

### Step 5.3 — Template Versioning

```php
// DocumentTemplateController.php
public function update(Request $request, $id) {
    $template = DocumentTemplate::findOrFail($id);
    $template->fill($request->validated());
    $template->Version = $template->Version + 1;   // FR-DOC-010
    $template->save();
    return back()->with('success', 'Template updated. Version: ' . $template->Version);
}
```

---

### ✅ Module 5 Checklist

- [ ] `document_templates` migration with unique(Template_Name, Document_Type) compound constraint
- [ ] `documents` migration with File_Extension, MIME_Type, softDeletes
- [ ] `DocumentController::upload()` with mimes and max:10240 validation
- [ ] `DocumentController::download()` returning file as HTTP download
- [ ] Template duplicate name+type guard
- [ ] Template version auto-increment on edit
- [ ] Variable substitution in document generation (`str_replace`)
- [ ] Document-Quotation/Sale/Customer association via pivot table
- [ ] Search documents by filename
- [ ] Soft delete for documents

---

## Module 6 — Integration & Cross-Module Flows

### Step 6.1 — Inventory Decrement on Sale Creation

**In `SaleController::store()` or via an Observer:**

```php
// After creating a sale line item, decrement inventory
foreach ($saleItems as $item) {
    $product = Product::find($item->Product_ID);
    $product->Current_Stock -= $item->Quantity;
    $product->save();

    InventoryTransaction::create([
        'Product_ID'       => $item->Product_ID,
        'Transaction_Type' => 'StockOut',
        'Quantity'         => $item->Quantity,
        'Reason'           => "Sale #{$sale->id}",
        'Unit_Price_At_Transaction' => $product->Unit_Price_PHP,
        'Total_Value'      => $item->Quantity * $product->Unit_Price_PHP,
    ]);
}
```

---

### Step 6.2 — End-to-End Flow Wiring

Ensure these controller chains are implemented in order:

```
1. InquiryController::store()
       ↓ (inquiry saved)
2. QuotationController::store()   ← uses Inquiry data
       ↓ (quotation approved)
3. SaleController::store()        ← uses Quotation data + decrements inventory
       ↓ (sale created)
4. InvoiceService::createFromSale()
       ↓ (invoice generated)
5. PaymentController::store()     ← records payment, updates status
```

---

### ✅ Module 6 Checklist

- [ ] Sale creation triggers `InventoryTransaction` (StockOut) automatically
- [ ] Sale creation triggers `Invoice` creation automatically
- [ ] All module-to-module data transfers preserve foreign key relationships
- [ ] Admin dashboard reads from all modules: stock alerts, pending quotations, overdue invoices, upcoming follow-ups
- [ ] Test end-to-end flow with BBT-INT-001 (Inquiry → Payment)
- [ ] Verify real-time stock sync with BBT-INT-002

---

## Global Implementation Notes

### Error Response Format (consistent across all modules)
```php
// Success
return response()->json(['success' => 'Action completed.'], 200);

// Validation failure (let Laravel handle automatically via validate())
// Returns HTTP 422 with {errors: {field: ['message']}}

// Business rule failure (manual)
return response()->json(['error' => 'Descriptive error message.'], 422);

// Authorization failure
abort(403, 'Unauthorized Action');
```

### Modal Cancel Pattern (JavaScript)
```javascript
// All modals must NOT submit on Cancel — just close
function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.getElementById(modalId + '-form').reset();  // clear form inputs
}
```

### Soft Delete Pattern (all applicable models)
```php
// Add to model:
use Illuminate\Database\Eloquent\SoftDeletes;
class MyModel extends Model {
    use SoftDeletes;
}

// Querying (softDeletes automatically excluded):
MyModel::all();           // excludes soft-deleted
MyModel::withTrashed();   // includes soft-deleted
MyModel::onlyTrashed();   // only soft-deleted
$model->restore();        // recover soft-deleted record
```

### Route Structure Pattern
```php
// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('inventory', InventoryController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('quotations', QuotationController::class);
    Route::resource('invoices', InvoiceController::class);

    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('documents/templates', DocumentTemplateController::class);
    });
});

Route::get('/products', [ProductController::class, 'index'])->name('catalog'); // public
Route::post('/inquiries', [InquiryController::class, 'store'])->name('inquiry.store'); // public
```

---

## Implementation Order (Recommended)

Follow this sequence to avoid dependency issues:

```
Phase 1 — Foundation
  ✅ Module 0: Auth (login, logout, roles, session)
  ✅ Run all migrations

Phase 2 — Core Data
  ✅ Module 1: Product Catalog (products, search, inquiry)
  ✅ Module 2: Inventory Management (stock in/out, alerts)

Phase 3 — CRM & Sales
  ✅ Module 3: Customer Management (customers, quotations, interactions)
  ✅ Module 4: Financial Management (sales, invoices, payments)

Phase 4 — Documents & Integration
  ✅ Module 5: Document Management (templates, uploads, PDFs)
  ✅ Module 6: Integration flows (end-to-end wiring)

Phase 5 — Testing
  ✅ Run Black Box test cases for each module
  ✅ Run White Box test cases for each module
  ✅ Run Integration test cases (Module 6)
```

---

*Implementation Guide for RozMed Enterprises Inc. Management System | CS12L Software Engineering*
