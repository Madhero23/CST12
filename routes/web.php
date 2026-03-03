<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// ============================================================================
// Public Routes
// ============================================================================

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home.index');

Route::get('/index', function () {
    return redirect()->route('home.index');
});

Route::get('/about', [\App\Http\Controllers\HomeController::class, 'about'])->name('about');

// ============================================================================
// Public Product Routes
// ============================================================================

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// ============================================================================
// Contact Routes
// ============================================================================

Route::get('/contact', [\App\Http\Controllers\HomeController::class, 'contact'])->name('contact.index');

Route::post('/contact/inquiry', [ProductController::class, 'storeInquiry'])
    ->middleware('throttle:5,1')
    ->name('contact.inquiry');

// ============================================================================
// Admin Routes
// ============================================================================

Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Product Management
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit')->whereNumber('id');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update')->whereNumber('id');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->whereNumber('id');

    // Inventory Management
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventory/stock-in', [InventoryController::class, 'stockIn'])->name('inventory.stock-in');
    Route::post('/inventory/stock-out', [InventoryController::class, 'stockOut'])->name('inventory.stock-out');
    Route::post('/inventory/update-location', [InventoryController::class, 'updateLocation'])->name('inventory.update-location');
    Route::post('/inventory/transfer', [InventoryController::class, 'createTransfer'])->name('inventory.transfer');
    Route::post('/inventory/transfer/{id}/complete', [InventoryController::class, 'completeTransfer'])->name('inventory.transfer.complete');
    Route::get('/inventory/scan-logs', [InventoryController::class, 'getScanLogs'])->name('inventory.scan-logs');
    Route::post('/inventory/scan', [InventoryController::class, 'recordScan'])->name('inventory.scan');

    // Customer Management
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::post('/customers/quotation', [CustomerController::class, 'createQuotation'])->name('customers.quotation');
    Route::post('/customers/interaction', [CustomerController::class, 'addInteractionLog'])->name('customers.interaction');
    Route::get('/customers/{id}/interactions', [CustomerController::class, 'getInteractionLogs'])->name('customers.interactions');
    Route::get('/customers/reminders', [CustomerController::class, 'reminders'])->name('customers.reminders');
    Route::put('/customers/quotation/{id}/status', [CustomerController::class, 'updateQuotationStatus'])->name('customers.quotation.status');  // FR-CRM-08

    // Finance Management
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance');
    Route::post('/finance/sale', [FinanceController::class, 'createSale'])->name('finance.sale');
    Route::post('/finance/payment-plan', [FinanceController::class, 'createPaymentPlan'])->name('finance.payment-plan');
    Route::get('/finance/payment-plan/{id}', [FinanceController::class, 'getPaymentPlan'])->name('finance.payment-plan.get');
    Route::post('/finance/installment/{id}/pay', [FinanceController::class, 'payInstallment'])->name('finance.installment.pay');
    Route::post('/finance/sale/{id}/payment', [FinanceController::class, 'recordPayment'])->name('finance.payment');
    Route::delete('/finance/sale/{id}', [FinanceController::class, 'destroy'])->name('finance.sale.delete');

    // Document Management
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents');
    Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');
    Route::get('/documents/{id}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{id}', [DocumentController::class, 'delete'])->name('documents.delete');
    Route::post('/quotations/{id}/revise', [DocumentController::class, 'reviseQuotation'])->name('quotations.revise');
    Route::post('/quotations/{id}/status', [DocumentController::class, 'updateStatus'])->name('quotations.status');

    // Quotation Templates
    Route::post('/quotation-templates/save', [DocumentController::class, 'saveTemplate'])->name('quotation-templates.save');
    Route::delete('/quotation-templates/{id}', [DocumentController::class, 'deleteTemplate'])->name('quotation-templates.delete');
});