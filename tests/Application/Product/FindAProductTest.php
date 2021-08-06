<?php declare(strict_types=1);

namespace App\Tests\Application\Product;

use App\Application\Product\ProductFinder;
use App\Entity\Producto;
use App\Repository\ProductRepositoryInterface;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class FindAProductTest extends TestCase
{
    /**
     * @var ProductRepositoryInterface|MockInterface
     */
    private $productRepository;

    public function testItShouldFindACategory(): void
    {
        $id = 1;
        $searchedProduct = new Producto();

        $this->productRepository
            ->shouldReceive('one')
            ->with($id)
            ->once()
            ->andReturn($searchedProduct);

        $product = (new ProductFinder($this->productRepository))($id);

        self::assertInstanceOf(Producto::class, $product);
        self::assertEquals($searchedProduct, $product);
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
