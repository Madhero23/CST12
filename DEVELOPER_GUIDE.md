# RozMed System - Developer Coding Standards

## Table of Contents
1. [Architecture Standards](#architecture-standards)
2. [Security Practices](#security-practices)
3. [Coding Standards](#coding-standards)
4. [Code Quality Requirements](#code-quality-requirements)
5. [Implementation Checklist](#implementation-checklist)

---

## Architecture Standards

### Modular Monolith Architecture

The RozMed system follows **Modular Monolith Architecture** principles:

**Structure:**
- Organized into 5 core subsystems (modules)
- Deployed as a single application
- Clear separation between modules
- Shared database with proper schema organization

**Five Core Subsystems:**
1. Product Catalog Management
2. Inventory Management
3. Customer Management
4. Financial Management & Payment Tracking
5. Document Management

**Key Principles:**
- Each subsystem is self-contained with its own controllers, models, and views
- Shared logic extracted into service classes
- Cross-module communication through well-defined interfaces
- Clear boundaries between business logic and presentation layer
- Reusable components across modules

---

## Security Practices

### 1. Input Validation

**Check Required Fields:**
All user inputs must be validated before processing.

```php
// Example: Product creation validation
$request->validate([
    'product_name' => 'required|string|max:255',
    'category' => 'required|in:diagnostic_equipment,medical_instruments,monitoring_devices,emergency_equipment,infusion_systems',
    'price' => 'required|numeric|min:0',
    'quantity' => 'required|integer|min:0',
    'email' => 'nullable|email',
]);
```

**Validate Formats:**
- **Email:** Use `email` validation rule
- **Passwords:** Minimum 8 characters, must be hashed
- **Numeric inputs:** Use `numeric` or `integer` with `min`/`max` constraints
- **Dates:** Use `date` or `date_format:Y-m-d`
- **File uploads:** Validate with `mimes`, `max` size

**Prevent Empty/Invalid Values:**
- Use `required` for mandatory fields
- Use `nullable` explicitly for optional fields
- Implement custom validation rules for complex business logic
- Never save empty or invalid values to the database

### 2. Error Handling

**Add Try-Catch Blocks:**
Implement comprehensive exception handling for all operations.

```php
public function store(Request $request)
{
    try {
        // Validate input
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        
        // Process data
        $product = Product::create($validated);
        
        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ]);
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle validation errors
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
        
    } catch (\Exception $e) {
        // Log system errors for debugging
        \Log::error('Product creation failed: ' . $e->getMessage(), [
            'user_id' => auth()->id(),
            'request' => $request->all(),
        ]);
        
        // Display user-friendly error message
        return response()->json([
            'success' => false,
            'message' => 'An error occurred. Please try again later.'
        ], 500);
    }
}
```

**Display User-Friendly Error Messages:**
- Never expose technical details or stack traces to users
- Use clear, actionable error messages
- Provide guidance on how to fix the error
- Return appropriate HTTP status codes

**Log System Errors for Debugging:**
- Log all exceptions with context (user ID, request data)
- Use Laravel's logging system (`\Log::error()`)
- Include error trace for debugging
- Monitor logs regularly for patterns

### 3. Security Checks

**Password Masking and Secure Storage:**

```php
// When creating/updating users
$user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password), // Always hash passwords
]);

// Never log or display passwords
\Log::info('User created', [
    'user_id' => $user->id,
    // DO NOT include password here
]);
```

**Password Requirements:**
- Minimum 8 characters
- Hash using `Hash::make()`
- Never store passwords in plain text
- Never display passwords in forms (use `type="password"`)
- Use password confirmation for critical operations

**Access Control (Basic Role Restrictions / Session Checks):**

```php
// Middleware for route protection
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/products', [ProductController::class, 'index']);
});

// Role-based access control in controllers
public function destroy($id)
{
    // Check if user has admin role
    if (!auth()->user()->hasRole('admin')) {
        abort(403, 'Unauthorized action');
    }
    
    // Proceed with deletion
    $product = Product::findOrFail($id);
    $product->delete();
    
    return response()->json(['success' => true]);
}
```

**Prevention of Unauthorized Feature Access:**

```php
// Check ownership before allowing edits
public function update(Request $request, $id)
{
    $quotation = Quotation::findOrFail($id);
    
    // Verify user owns this quotation or is admin
    if ($quotation->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
        abort(403, 'You do not have permission to edit this quotation');
    }
    
    // Proceed with update
    $quotation->update($request->validated());
}
```

**Session Management:**
- Use Laravel's built-in session handling
- Implement CSRF protection (enabled by default)
- Set appropriate session timeouts
- Regenerate session IDs after authentication
- Clear sessions on logout

---

## Coding Standards

### 1. Naming Conventions

**Variables - Use camelCase:**
```php
$productName = 'X-Ray Machine';
$totalAmount = 15000;
$isActive = true;
$customerEmail = 'client@hospital.com';
```

**Functions/Methods - Use camelCase, descriptive names:**
```php
public function getActiveProducts() { }
public function calculateTotalPrice() { }
public function sendQuotationEmail() { }
public function validateInventoryLevel() { }
```

**Classes - Use PascalCase:**
```php
class ProductController { }
class InventoryService { }
class QuotationRepository { }
class PaymentPlanManager { }
```

**Database Tables - Use snake_case, plural:**
```php
products
inventory_movements
customer_quotations
payment_plans
user_roles
```

**Files - Follow Laravel conventions:**
- Controllers: `ProductController.php`
- Models: `Product.php`
- Views: `product-catalog.blade.php`
- Migrations: `2024_01_01_create_products_table.php`
- Services: `ProductService.php`

### 2. Code Organization

**Organize into Reusable Components/Modules:**

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ProductController.php
│   │   ├── InventoryController.php
│   │   └── CustomerController.php
│   └── Middleware/
├── Services/
│   ├── ProductService.php
│   ├── InventoryService.php
│   └── QuotationService.php
├── Repositories/
│   ├── ProductRepository.php
│   └── CustomerRepository.php
└── Models/
    ├── Product.php
    ├── Inventory.php
    └── Customer.php
```

**Controller Structure - Standard Resource Methods:**
```php
class ProductController extends Controller
{
    public function index() { }      // List all products
    public function create() { }     // Show create form
    public function store() { }      // Save new product
    public function show($id) { }    // Show single product
    public function edit($id) { }    // Show edit form
    public function update($id) { } // Update existing product
    public function destroy($id) { } // Delete product
}
```

**Service Classes for Business Logic:**
```php
// app/Services/ProductService.php
class ProductService
{
    /**
     * Create a new product with validation and business rules
     */
    public function createProduct(array $data)
    {
        // Complex business logic here
        // Validation, calculations, multiple model interactions
        
        return Product::create($data);
    }
    
    /**
     * Update inventory levels after product creation
     */
    public function updateInventory($productId, $quantity)
    {
        // Inventory management logic
    }
}
```

**Repository Pattern for Data Access:**
```php
// app/Repositories/ProductRepository.php
class ProductRepository
{
    public function findByCategory($category)
    {
        return Product::where('category', $category)
                     ->where('is_active', true)
                     ->get();
    }
    
    public function searchProducts($query)
    {
        return Product::where('name', 'like', "%{$query}%")
                     ->orWhere('description', 'like', "%{$query}%")
                     ->get();
    }
}
```

### 3. Documentation and Comments

**Add Comments Where Needed:**

**Document complex functions with PHPDoc:**
```php
/**
 * Create a new product in the catalog
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 * @throws \Illuminate\Validation\ValidationException
 */
public function store(Request $request)
{
    // Implementation
}
```

**Inline comments for business logic:**
```php
// Calculate discount based on customer tier and order amount
if ($customer->tier === 'premium' && $orderAmount > 50000) {
    // Premium customers get 15% discount on large orders
    $discount = $orderAmount * 0.15;
} else {
    // Standard 5% discount for all other customers
    $discount = $orderAmount * 0.05;
}
```

**Comment complex algorithms:**
```php
/**
 * Calculate aging inventory based on first-in-first-out (FIFO) method
 * Products older than 180 days are flagged as critical
 */
public function calculateAgingInventory()
{
    // Implementation
}
```

**Avoid obvious comments:**
```php
// BAD - States the obvious
$total = $price * $quantity; // Multiply price by quantity

// GOOD - Explains why
$total = $price * $quantity * $exchangeRate; // Convert to PHP from USD
```

### 4. Clean Code Practices

**Follow Clean Code Principles to Improve Readability:**

**Keep functions small and focused:**
```php
// GOOD - Single responsibility
public function calculateTotalPrice($items)
{
    return array_sum(array_column($items, 'price'));
}

// BAD - Doing too much
public function processOrder($request)
{
    // Validates, creates order, updates inventory, 
    // sends email, generates invoice all in one function
}
```

**Use meaningful variable names:**
```php
// GOOD
$activeCustomers = Customer::where('status', 'active')->get();
$totalRevenue = $this->calculateMonthlyRevenue();

// BAD
$data = Customer::where('status', 'active')->get();
$x = $this->calc();
```

**Avoid magic numbers - use constants:**
```php
// BAD
if ($stockLevel < 10) { }

// GOOD
class Product extends Model
{
    const LOW_STOCK_THRESHOLD = 10;
    
    public function isLowStock()
    {
        return $this->quantity < self::LOW_STOCK_THRESHOLD;
    }
}
```

**Extract complex conditions:**
```php
// BAD
if ($user->role === 'admin' || ($user->role === 'manager' && $user->department === 'sales')) {
    // Do something
}

// GOOD
public function canApproveQuotation($user)
{
    return $user->role === 'admin' || 
           ($user->role === 'manager' && $user->department === 'sales');
}

if ($this->canApproveQuotation($user)) {
    // Do something
}
```

---

## Code Quality Requirements

### Core Functionalities Must Work

**All core features must function correctly with proper outputs:**

1. **Product Catalog Management**
   - Browse and search products
   - Filter by categories
   - CRUD operations (Create, Read, Update, Delete)
   - Modal-based forms

2. **Inventory Management**
   - Stock in/out recording
   - Transfer between locations
   - Aging reports
   - Real-time stock level updates

3. **Customer Management**
   - Customer profile creation
   - Quotation pipeline management
   - Interaction logging
   - Follow-up scheduling

4. **Financial Management**
   - Payment plan creation
   - Invoice generation
   - Payment recording
   - Due date monitoring

5. **Document Management**
   - Template management
   - Quotation generation
   - Version control
   - Document repository

### Prototype Integration Requirements

**Connect UI Screens with Backend Logic:**

```php
// Controller handles the backend logic
public function index()
{
    $products = Product::where('is_active', true)
                      ->orderBy('created_at', 'desc')
                      ->paginate(20);
                      
    return view('products.index', compact('products'));
}
```

```php
// Blade template displays the data
@foreach($products as $product)
<div class="product-card">
    <h3>{{ $product->name }}</h3>
    <p>{{ $product->category }}</p>
    <p class="price">₱{{ number_format($product->price, 2) }}</p>
</div>
@endforeach
```

**Ensure Main User Flow Works End-to-End:**

Example: Product Creation Flow
1. User clicks "Add Product" button → Modal opens
2. User fills form → Frontend validation checks
3. User submits → AJAX request to backend
4. Backend validates → Saves to database
5. Success response → Modal closes, table refreshes
6. Error response → Display error messages

**Test Prototype on Sample Inputs:**

```php
// Test with valid input
$product = [
    'name' => 'Digital Thermometer',
    'category' => 'monitoring_devices',
    'price' => 2500,
    'quantity' => 50
];
// Expected: Product created successfully

// Test with invalid input
$product = [
    'name' => '',  // Empty name
    'price' => -100,  // Negative price
];
// Expected: Validation errors displayed
```

---

## Implementation Checklist

### For Each Subsystem

**Before marking a feature as complete, verify:**

- [ ] **Input Validation Implemented**
  - Required fields checked
  - Formats validated (email, numeric, dates)
  - Empty/invalid values prevented

- [ ] **Error Handling Added**
  - Try-catch blocks implemented
  - User-friendly error messages displayed
  - System errors logged for debugging

- [ ] **Security Checks Applied**
  - Authentication required
  - Authorization verified (role-based access)
  - Passwords hashed
  - Unauthorized access prevented

- [ ] **Coding Standards Followed**
  - Naming conventions used
  - Code organized into modules/components
  - Comments added where needed
  - Clean code practices applied

- [ ] **Backend Integration Complete**
  - Controller methods implemented
  - Database models configured
  - Routes defined
  - Services/Repositories created (if needed)

- [ ] **UI Integration Working**
  - Frontend connected to backend
  - AJAX requests functional
  - Forms validate and submit correctly
  - Modals open/close properly

- [ ] **Testing Completed**
  - Tested with valid inputs
  - Tested with invalid inputs
  - Tested edge cases
  - End-to-end flow verified

### Quality Standards Checklist

**Code must meet these standards:**

- [ ] **Clean and Readable**
  - Consistent formatting
  - Logical structure
  - No redundant code
  - No commented-out code blocks

- [ ] **Well Organized**
  - Files in correct directories
  - Clear separation of concerns
  - Reusable components extracted
  - Similar functionality grouped

- [ ] **Properly Documented**
  - Complex functions have PHPDoc
  - Business logic explained
  - No obvious/redundant comments
  - README updated if needed

- [ ] **Secure**
  - No SQL injection vulnerabilities
  - No XSS vulnerabilities
  - CSRF protection enabled
  - Sensitive data not exposed

- [ ] **Performance Optimized**
  - No N+1 query problems
  - Proper database indexing
  - Caching used where appropriate
  - Large datasets paginated

---

## Common Implementation Patterns

### AJAX Form Submission

```javascript
function submitProductForm(formData) {
    fetch('/api/products', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            hideModal('addProductModal');
            showToast('Product created successfully', 'success');
            refreshProductTable();
        } else {
            displayErrors(data.errors);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred. Please try again.', 'error');
    });
}
```

### Modal Management

```javascript
// Show modal
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('hidden');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

// Hide modal
function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.add('hidden');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}
```

### Database Query Optimization

```php
// BAD - N+1 query problem
$products = Product::all();
foreach ($products as $product) {
    echo $product->category->name; // New query for each product
}

// GOOD - Eager loading
$products = Product::with('category')->get();
foreach ($products as $product) {
    echo $product->category->name; // No additional queries
}
```

### Form Validation Pattern

```php
public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:customers',
        'phone' => 'required|regex:/^[0-9]{10,11}$/',
    ]);
    
    try {
        $customer = Customer::create($validated);
        
        return response()->json([
            'success' => true,
            'data' => $customer
        ]);
    } catch (\Exception $e) {
        \Log::error('Customer creation failed: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to create customer'
        ], 500);
    }
}
```

---

## System Requirements Summary

### 5 Subsystems Must Be Implemented

1. **Product Catalog Management** - Fully functional with search, filters, CRUD
2. **Inventory Management** - Stock tracking, transfers, aging reports
3. **Customer Management** - CRM with quotations and interactions
4. **Financial Management** - Payment plans, invoicing, tracking
5. **Document Management** - Templates, quotations, version control

### Core Features Must Work

- All CRUD operations functional
- Search and filter capabilities working
- Modals open/close correctly
- Forms validate and submit properly
- Data displays correctly from database
- Navigation between sections works
- User feedback (success/error messages) shown

### Security Must Be Applied

- Input validation on all forms
- Error handling throughout
- Authentication required for protected routes
- Authorization checks for sensitive operations
- Passwords hashed and secure
- Session management properly configured

### Code Must Be Clean

- Follows naming conventions
- Organized into logical modules
- Comments explain complex logic
- No redundant or dead code
- Readable and maintainable
- Follows Laravel best practices

---

**Last Updated:** February 2026  
**Maintainers:** RozMed Development Team
