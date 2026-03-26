<?php

/**
 * AdminRouteTest — Tests admin routes with authentication.
 *
 * Updated: All admin routes now require 'auth' middleware.
 * Tests authenticate as Admin user before accessing routes.
 */

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;

class AdminRouteTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user for authentication
        $this->adminUser = User::create([
            'Username'      => 'admin',
            'Email'         => 'admin@test.com',
            'Password_Hash' => Hash::make('Admin1234!'),
            'Role'          => 'Admin',
            'Full_Name'     => 'Test Admin',
            'Phone'         => '09170000000',
            'Department'    => 'IT',
            'Status'        => 'Active',
        ]);

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

    // ---- Auth Routes ----

    public function test_login_page_returns_200(): void
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_redirected_to_login(): void
    {
        // FR-AUTH-08: Unauthenticated users should be redirected to /login
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect('/');
    }

    public function test_login_with_valid_credentials(): void
    {
        // FR-AUTH-01: Authenticate via Username + hashed password
        $response = $this->post(route('login.submit'), [
            'Username' => 'admin',
            'Password' => 'Admin1234!',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($this->adminUser);
    }

    public function test_login_with_invalid_password(): void
    {
        // FR-AUTH-02: Generic error for wrong password
        $response = $this->post(route('login.submit'), [
            'Username' => 'admin',
            'Password' => 'WrongPassword!',
        ]);

        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_login_with_nonexistent_username(): void
    {
        // FR-AUTH-02: Same generic error for non-existent user
        $response = $this->post(route('login.submit'), [
            'Username' => 'ghost_user',
            'Password' => 'Test1234!',
        ]);

        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_login_with_empty_fields(): void
    {
        // FR-AUTH-03: Validation errors for empty fields
        $response = $this->post(route('login.submit'), [
            'Username' => '',
            'Password' => '',
        ]);

        $response->assertSessionHasErrors(['Username', 'Password']);
        $this->assertGuest();
    }

    public function test_logout(): void
    {
        // FR-AUTH-05: Full logout flow
        $response = $this->actingAs($this->adminUser)
            ->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    // ---- Dashboard ----

    public function test_admin_dashboard_returns_200(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    // ---- Products ----

    public function test_admin_products_returns_200(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.products'));
        $response->assertStatus(200);
    }

    // ---- Inventory ----

    public function test_admin_inventory_returns_200(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.inventory'));
        $response->assertStatus(200);
    }

    // ---- Customers ----

    public function test_admin_customers_returns_200(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.customers'));
        $response->assertStatus(200);
    }

    public function test_admin_store_customer(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->postJson(route('admin.customers.store'), [
                'Institution_Name' => 'Test Hospital',
                'Customer_Type' => 'Hospital',
                'Segment_Type' => 'HighValue',
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
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.finance'));
        $response->assertStatus(200);
    }

    // ---- Documents ----

    public function test_admin_documents_returns_200(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.documents'));
        $response->assertStatus(200);
    }

    // ---- Role-Based Access Control ----

    public function test_non_admin_cannot_access_user_management(): void
    {
        // FR-AUTH-07: Non-Admin authenticated user gets 403
        $salesUser = User::create([
            'Username'      => 'salestest',
            'Email'         => 'sales@test.com',
            'Password_Hash' => Hash::make('Test1234!'),
            'Role'          => 'SalesStaff',
            'Full_Name'     => 'Sales Test',
            'Phone'         => '09170000001',
            'Department'    => 'Sales',
            'Status'        => 'Active',
        ]);

        $response = $this->actingAs($salesUser)
            ->get(route('admin.users'));

        $response->assertStatus(403);
    }
}
