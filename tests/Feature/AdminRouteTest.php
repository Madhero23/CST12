<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Location;

class AdminRouteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create minimal test data needed for views
        Supplier::create([
            'Supplier_Name' => 'Test Supplier',
            'Contact_Person' => 'John',
            'Email' => 'supplier@test.com',
            'Phone' => '09171234567',
            'Address' => '123 Test St',
        ]);

        Location::create([
            'Location_Name' => 'Warehouse A',
            'Address' => '456 Warehouse Rd',
            'Contact_Number' => '09171234568',
            'Status' => 'Active',
        ]);
    }

    // ---- Dashboard ----

    public function test_admin_dashboard_returns_200(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    // ---- Products ----

    public function test_admin_products_returns_200(): void
    {
        $response = $this->get(route('admin.products'));
        $response->assertStatus(200);
    }

    // ---- Inventory ----

    public function test_admin_inventory_returns_200(): void
    {
        $response = $this->get(route('admin.inventory'));
        $response->assertStatus(200);
    }

    // ---- Customers ----

    public function test_admin_customers_returns_200(): void
    {
        $response = $this->get(route('admin.customers'));
        $response->assertStatus(200);
    }

    public function test_admin_store_customer(): void
    {
        $response = $this->postJson(route('admin.customers.store'), [
            'Institution_Name' => 'Test Hospital',
            'Customer_Type' => 'Hospital',
            'Segment_Type' => 'High-Value',
            'Contact_Person' => 'Dr. Test',
            'Email' => 'test@hospital.com',
            'Phone' => '09171234567',
            'Address' => '123 Test Street',
        ]);

        $response->assertSuccessful();
        $this->assertDatabaseHas('customers', ['Institution_Name' => 'Test Hospital']);
    }

    // ---- Finance ----

    public function test_admin_finance_returns_200(): void
    {
        $response = $this->get(route('admin.finance'));
        $response->assertStatus(200);
    }

    // ---- Documents ----

    public function test_admin_documents_returns_200(): void
    {
        $response = $this->get(route('admin.documents'));
        $response->assertStatus(200);
    }

    // ---- Public Routes ----

    public function test_welcome_returns_200(): void
    {
        $response = $this->get(route('welcome'));
        $response->assertStatus(200);
    }
}
