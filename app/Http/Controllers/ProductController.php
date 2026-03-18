<?php

namespace App\Http\Controllers;

use App\Modules\Product\Services\ProductService;
use App\Modules\Product\Requests\InquiryRequest;
use App\Modules\Shared\Services\LoggingService;
use App\Modules\Shared\Exceptions\NotFoundException;
use App\Modules\Shared\Exceptions\DatabaseException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Throwable;

/**
 * Product Controller - Handles product-related HTTP requests
 * 
 * This controller manages product display, search, and inquiry submissions
 * with proper error handling and security measures.
 */
class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    protected ProductService $productService;

    /**
     * @var LoggingService
     */
    protected LoggingService $logger;

    /**
     * Create a new ProductController instance
     *
     * @param ProductService $productService
     * @param LoggingService $logger
     */
    public function __construct(ProductService $productService, LoggingService $logger)
    {
        $this->productService = $productService;
        $this->logger = $logger;
    }

    /**
     * Display the specified product
     *
     * @param int $id Product ID
     * @return View
     */
    public function show(int $id): View
    {
        try {
            // Get product from service
            $product = $this->productService->getProductById($id);
            
            // Load total stock from inventories for accurate stock display
            $product->total_stock = $product->inventories()->sum('Current_Stock');

            return view('components.viewproduct', compact('product'));

        } catch (NotFoundException $e) {
            $this->logger->logWarning('Product not found', ['product_id' => $id]);
            
            // Redirect to products page with error message
            return view('components.viewproduct', [
                'product' => null,
                'error' => 'Product not found. It may have been removed or is no longer available.',
            ]);

        } catch (DatabaseException $e) {
            $this->logger->logError($e, 'Failed to load product details', ['product_id' => $id]);
            
            return view('components.viewproduct', [
                'product' => null,
                'error' => 'Unable to load product details. Please try again later.',
            ]);

        } catch (Throwable $e) {
            $this->logger->logError($e, 'Unexpected error in product show', ['product_id' => $id]);
            
            return view('components.viewproduct', [
                'product' => null,
                'error' => 'An unexpected error occurred. Please try again later.',
            ]);
        }
    }

    /**
     * Store a product inquiry
     *
     * @param InquiryRequest $request Validated request
     * @return JsonResponse
     */
    public function storeInquiry(InquiryRequest $request): JsonResponse
    {
        try {
            // Get validated and sanitized data
            $validated = $request->validated();
            
            // Add IP address and user agent for tracking
            $validated['ip_address'] = $request->ip();
            $validated['user_agent'] = $request->userAgent();
            
            // Create the inquiry in database
            $inquiry = \App\Models\Inquiry::create($validated);

            // FR-PC-06: Generate reference number (INQ-YYYY-NNNN)
            $refNumber = 'INQ-' . date('Y') . '-' . str_pad($inquiry->id, 4, '0', STR_PAD_LEFT);
            $inquiry->update(['reference_number' => $refNumber]);
            
            // Send email notification to admin
            try {
                \Illuminate\Support\Facades\Mail::to(config('mail.admin_email', 'admin@rozmed.com'))
                    ->send(new \App\Mail\InquiryReceived($inquiry));
                    
                $this->logger->logInfo('Admin notification email sent', [
                    'inquiry_id' => $inquiry->id,
                ]);
            } catch (Throwable $emailError) {
                // Log email error but don't fail the request
                $this->logger->logError($emailError, 'Failed to send admin notification email', [
                    'inquiry_id' => $inquiry->id,
                ]);
            }
            
            // Send confirmation email to customer
            try {
                \Illuminate\Support\Facades\Mail::to($inquiry->email)
                    ->send(new \App\Mail\InquiryConfirmation($inquiry));
                    
                $this->logger->logInfo('Customer confirmation email sent', [
                    'inquiry_id' => $inquiry->id,
                    'customer_email' => $inquiry->email,
                ]);
            } catch (Throwable $emailError) {
                // Log email error but don't fail the request
                $this->logger->logError($emailError, 'Failed to send customer confirmation email', [
                    'inquiry_id' => $inquiry->id,
                    'customer_email' => $inquiry->email,
                ]);
            }

            // Log the successful inquiry submission
            $this->logger->logActivity('Product inquiry submitted', null, [
                'inquiry_id' => $inquiry->id,
                'reference_number' => $refNumber,
                'product_id' => $validated['product_id'] ?? null,
                'email' => $validated['email'],
                'subject' => $validated['subject'],
            ]);

            return response()->json([
                'success' => true,
                'message' => "Thank you for your inquiry! Reference: {$refNumber}. We will get back to you shortly.",
                'inquiry_id' => $inquiry->id,
                'reference_number' => $refNumber,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors are automatically handled by Laravel
            // This catch block is for logging purposes
            $this->logger->logWarning('Inquiry validation failed', [
                'errors' => $e->errors(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Please check your input and try again.',
                'errors' => $e->errors(),
            ], 422);

        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to submit inquiry');

            return response()->json([
                'success' => false,
                'message' => 'Failed to submit your inquiry. Please try again later or contact us directly.',
            ], 500);
        }
    }

    /**
     * Search products (AJAX endpoint)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $searchTerm = $request->input('q', '');

            if (empty(trim($searchTerm))) {
                return response()->json([
                    'success' => true,
                    'products' => [],
                ]);
            }

            $products = $this->productService->searchProducts($searchTerm);

            return response()->json([
                'success' => true,
                'products' => $products,
            ]);

        } catch (Throwable $e) {
            $this->logger->logError($e, 'Product search failed', [
                'search_term' => $request->input('q'),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Search failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Admin: Display products for management
     */
    public function adminIndex(Request $request): View
    {
        try {
            $filters = array_filter([
                'category' => $request->input('category'),
                'search' => $request->input('search'),
                'status' => $request->input('status'),
            ]);

            $categories = [
                'DiagnosticEquipment' => 'Diagnostic Equipment',
                'MedicalInstruments' => 'Medical Instruments',
                'MonitoringDevices' => 'Monitoring Devices',
                'EmergencyEquipment' => 'Emergency Equipment',
                'InfusionSystems' => 'Infusion Systems',
                'LaboratoryEquipment' => 'Laboratory Equipment',
            ];

            $products = $this->productService->getAllProducts($filters);

            // Eager-load inventories so the Blade template can show real stock levels
            $products->load('inventories');

            return view('productdetails.PDetails', compact('products', 'categories'));

        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to load admin products');
            return view('productdetails.PDetails', [
                'products' => collect([]),
                'categories' => [],
                'error' => 'Unable to load products.',
            ]);
        }
    }

    /**
     * Display a listing of products (public)
     */
    public function index(Request $request): View
    {
        try {
            $filters = array_filter([
                'category' => $request->input('category'),
                'search' => $request->input('search'),
                'status' => $request->input('status'),
            ]);

            $categories = [
                'DiagnosticEquipment' => 'Diagnostic Equipment',
                'MedicalInstruments' => 'Medical Instruments',
                'MonitoringDevices' => 'Monitoring Devices',
                'EmergencyEquipment' => 'Emergency Equipment',
                'InfusionSystems' => 'Infusion Systems',
                'LaboratoryEquipment' => 'Laboratory Equipment',
            ];

            $products = $this->productService->getAllProducts($filters);
            
            // Return appropriate view based on route
            if ($request->is('admin/*')) {
                return view('productdetails.PDetails', compact('products', 'categories'));
            }
            
            return view('products.products', compact('products', 'categories'));

        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to load products');
            return view('products.products', [
                'products' => collect([]),
                'categories' => [],
                'error' => 'Unable to load products.',
            ]);
        }
    }

    /**
     * Admin: Store a new product
     */
    public function store(\App\Http\Requests\StoreProductRequest $request): JsonResponse
    {
        try {
            $product = $this->productService->createProduct($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
                'product' => $product,
            ], 201);

        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to create product');
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product. ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Admin: Update product
     */
    public function update(\App\Http\Requests\UpdateProductRequest $request, int $id): JsonResponse
    {
        try {
            $product = $this->productService->updateProduct($id, $request->validated());

            if (!$product) {
                return response()->json([
                    'success' => true,
                    'message' => 'No changes were made.',
                    'no_changes' => true,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
                'product' => $product,
            ]);

        } catch (NotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to update product', ['product_id' => $id]);
            return response()->json(['success' => false, 'message' => 'Failed to update product. ' . $e->getMessage()], 500);
        }
    }

    /**
     * Admin: Delete product
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->productService->deleteProduct($id);
            $this->logger->logActivity('Product deleted', null, ['product_id' => $id]);

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully',
            ]);

        } catch (NotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to delete product', ['product_id' => $id]);
            return response()->json(['success' => false, 'message' => 'Failed to delete product.'], 500);
        }
    }

    /**
     * Admin: Get product for editing (AJAX)
     */
    public function edit(int $id): JsonResponse
    {
        try {
            $product = $this->productService->getProductById($id);
            $product->load('inventories');

            // Include stock quantity from inventories for the Edit modal
            $productData = $product->toArray();
            $productData['Stock_Quantity'] = $product->inventories->sum('Quantity_On_Hand');

            return response()->json($productData);
        } catch (NotFoundException $e) {
            return response()->json(['error' => 'Product not found'], 404);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Failed to fetch product'], 500);
        }
    }
}
