<?php declare(strict_types=1);

namespace App\Tests\Application\Product;

use App\Application\Product\AllProductsFinder;
use App\Repository\ProductRepositoryInterface;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class FindAllProductsTest extends TestCase
{

    /**
     * @var ProductRepositoryInterface|MockInterface
     */
    private $productRepository;

    public function testItShouldFindAllProducts(): void
    {
        $this->productRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn([]);

        $products = (new AllProductsFinder($this->productRepository))();

        self::assertIsArray($products);
    }

    protected function setUp(): void
    {
        $this->productRepository = Mockery::mock(ProductRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
