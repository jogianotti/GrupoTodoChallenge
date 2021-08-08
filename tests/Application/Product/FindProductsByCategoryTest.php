<?php declare(strict_types=1);

namespace App\Tests\Application\Product;

use App\Application\Product\ProductsByCategoryFinder;
use App\Entity\Producto;
use App\Repository\ProductCategoryRepositoryInterface;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class FindProductsByCategoryTest extends TestCase
{
    /**
     * @var ProductCategoryRepositoryInterface|MockInterface
     */
    private $productCategoryRepository;

    public function testItShouldFindAllProductsByCategory(): void
    {
        $category_id = 1;
        $product = new Producto();

        $this->productCategoryRepository
            ->shouldReceive('byCategory')
            ->with($category_id)
            ->once()
            ->andReturn([$product]);

        $products = (new ProductsByCategoryFinder($this->productCategoryRepository))($category_id);

        self::assertInstanceOf(Producto::class, $products[0]);
        self::assertEquals($products[0], $product);
    }

    protected function setUp(): void
    {
        $this->productCategoryRepository = Mockery::mock(ProductCategoryRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
