<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Modules\Product\Services\ProductService;
use App\Modules\Product\Repositories\ProductRepository;
use App\Modules\Shared\Services\LoggingService;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Mockery\MockInterface;

class ProductServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    private function createService(MockInterface $repoMock): ProductService
    {
        $loggerMock = Mockery::mock(LoggingService::class);
        $loggerMock->shouldIgnoreMissing();
        return new ProductService($repoMock, $loggerMock);
    }

    public function test_get_all_products_returns_collection(): void
    {
        $products = new Collection([
            new Product(['Product_Name' => 'Test Product']),
        ]);

        $repoMock = Mockery::mock(ProductRepository::class);
        $repoMock->shouldReceive('getAll')
            ->once()
            ->andReturn($products);

        $service = $this->createService($repoMock);
        $result = $service->getAllProducts();

        $this->assertCount(1, $result);
        $this->assertEquals('Test Product', $result->first()->Product_Name);
    }

    public function test_get_product_by_id_returns_product(): void
    {
        $product = new Product(['Product_Name' => 'Test Product']);

        $repoMock = Mockery::mock(ProductRepository::class);
        $repoMock->shouldReceive('findOrFail')
            ->once()
            ->with(1)
            ->andReturn($product);

        $service = $this->createService($repoMock);
        $result = $service->getProductById(1);

        $this->assertEquals('Test Product', $result->Product_Name);
    }

    public function test_get_all_products_throws_database_exception_on_failure(): void
    {
        $repoMock = Mockery::mock(ProductRepository::class);
        $repoMock->shouldReceive('getAll')
            ->once()
            ->andThrow(new \RuntimeException('DB error'));

        $service = $this->createService($repoMock);

        $this->expectException(\App\Modules\Shared\Exceptions\DatabaseException::class);
        $service->getAllProducts();
    }
}
