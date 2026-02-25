<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Location;
use App\Models\Inventory;
use App\Models\InventoryTransaction;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $product;
    protected $locationA;
    protected $locationB;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create user manually
        $this->user = User::create([
            'Username' => 'testadmin',
            'Full_Name' => 'Test Admin',
            'Email' => 'admin@example.com',
            'Password_Hash' => bcrypt('password'),
            'Role' => 'Admin',
            'Status' => 'Active',
            'Phone' => '1234567890',
            'Department' => 'IT'
        ]);
        
        // Create product manually
        $this->product = Product::create([
            'Product_Name' => 'Test Product',
            'Category' => 'DiagnosticEquipment', // Using valid enum value
            'Unit_Price_PHP' => 100,
            'Unit_Price_USD' => 2,
            'Status' => 'Active'
        ]);
        
        // Create locations manually
        $this->locationA = Location::create([
            'Location_Name' => 'Location A',
            'Address' => 'Address A',
            'Contact_Number' => '1234567890',
            'Status' => 'Active'
        ]);

        $this->locationB = Location::create([
            'Location_Name' => 'Location B',
            'Address' => 'Address B',
            'Contact_Number' => '0987654321',
            'Status' => 'Active'
        ]);
    }

    public function test_stock_in_increases_inventory_and_logs_transaction()
    {
        $response = $this->actingAs($this->user)->postJson(route('admin.inventory.stock-in'), [
            'product_id' => $this->product->Product_ID,
            'location_id' => $this->locationA->Location_ID,
            'quantity' => 10,
            'notes' => 'Initial Stock'
        ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        // Check Inventory
        $this->assertDatabaseHas('inventories', [
            'Product_ID' => $this->product->Product_ID,
            'Location_ID' => $this->locationA->Location_ID,
            'Quantity_On_Hand' => 10
        ]);

        // Check Transaction Log
        $this->assertDatabaseHas('inventory_transactions', [
            'Product_ID' => $this->product->Product_ID,
            'Transaction_Type' => 'StockIn',
            'Quantity' => 10,
            'Destination_Location_ID' => $this->locationA->Location_ID
        ]);
    }

    public function test_stock_out_decreases_inventory_and_logs_transaction()
    {
        // Initial Stock In (Manually create inventory to avoid dependency on previous test)
        Inventory::create([
            'Product_ID' => $this->product->Product_ID,
            'Location_ID' => $this->locationA->Location_ID,
            'Quantity_On_Hand' => 20,
            'Quantity_Reserved' => 0,
            'Quantity_Available' => 20
        ]);

        // Stock Out
        $response = $this->actingAs($this->user)->postJson(route('admin.inventory.stock-out'), [
            'product_id' => $this->product->Product_ID,
            'location_id' => $this->locationA->Location_ID,
            'quantity' => 5,
            'notes' => 'Sold'
        ]);

        $response->assertStatus(200);

        // Check Inventory (Fresh from DB)
        $this->assertDatabaseHas('inventories', [
            'Product_ID' => $this->product->Product_ID,
            'Location_ID' => $this->locationA->Location_ID,
            'Quantity_On_Hand' => 15 // 20 - 5
        ]);

        // Check Transaction Log
        $this->assertDatabaseHas('inventory_transactions', [
            'Product_ID' => $this->product->Product_ID,
            'Transaction_Type' => 'StockOut',
            'Quantity' => 5,
            'Source_Location_ID' => $this->locationA->Location_ID
        ]);
    }

    public function test_stock_transfer_moves_inventory_correctly()
    {
        // Initial Stock In at Location A
        Inventory::create([
            'Product_ID' => $this->product->Product_ID,
            'Location_ID' => $this->locationA->Location_ID,
            'Quantity_On_Hand' => 50,
            'Quantity_Reserved' => 0,
            'Quantity_Available' => 50
        ]);

        // Transfer 20 to Location B
        $response = $this->actingAs($this->user)->postJson(route('admin.inventory.transfer'), [
            'product_id' => $this->product->Product_ID,
            'from_location_id' => $this->locationA->Location_ID,
            'to_location_id' => $this->locationB->Location_ID,
            'quantity' => 20,
            'notes' => 'Transferring stock'
        ]);

        $response->assertStatus(201);

        // Check Source Inventory (A)
        $this->assertDatabaseHas('inventories', [
            'Product_ID' => $this->product->Product_ID,
            'Location_ID' => $this->locationA->Location_ID,
            'Quantity_On_Hand' => 30 // 50 - 20
        ]);

        // Check Destination Inventory (B)
        // Note: Destination inventory might be created by the transfer if it doesn't exist
        $this->assertDatabaseHas('inventories', [
            'Product_ID' => $this->product->Product_ID,
            'Location_ID' => $this->locationB->Location_ID,
            'Quantity_On_Hand' => 20 // 0 + 20
        ]);

        // Check Transaction Log
        $this->assertDatabaseHas('inventory_transactions', [
            'Product_ID' => $this->product->Product_ID,
            'Transaction_Type' => 'Transfer',
            'Quantity' => 20,
            'Source_Location_ID' => $this->locationA->Location_ID,
            'Destination_Location_ID' => $this->locationB->Location_ID
        ]);
    }

    public function test_insufficient_stock_prevents_stock_out_and_transfer()
    {
        // Stock Out more than available (0 stock initially)
        $responseOut = $this->actingAs($this->user)->postJson(route('admin.inventory.stock-out'), [
            'product_id' => $this->product->Product_ID,
            'location_id' => $this->locationA->Location_ID,
            'quantity' => 100 
        ]);

        $responseOut->assertStatus(400);

        // Transfer more than available
        $responseTransfer = $this->actingAs($this->user)->postJson(route('admin.inventory.transfer'), [
            'product_id' => $this->product->Product_ID,
            'from_location_id' => $this->locationA->Location_ID,
            'to_location_id' => $this->locationB->Location_ID,
            'quantity' => 100
        ]);

        $responseTransfer->assertStatus(400);
    }
}
