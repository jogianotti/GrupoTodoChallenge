<?php declare(strict_types=1);

namespace App\Tests\Application\Product;

use App\Application\Product\ProductRemover;
use App\Entity\ProductoCategoria;
use App\Repository\ProductCategoryRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class RemoveProductTest extends TestCase
{
    /**
     * @var ProductRepositoryInterface|MockInterface
     */
    private $productRepository;
    /**
     * @var ProductCategoryRepositoryInterface|MockInterface
     */
    private $productCategoryRepository;

    /** @doesNotPerformAssertions */
    public function testItShouldRemoveAProduct(): void
    {
        $id = 1;
        $product = ProductMother::create();
        $productCategory = new ProductoCategoria();
        $productCategory->setProduct($product);

        $this->productRepository
            ->shouldReceive('one')
            ->with($id)
            ->once()
            ->andReturn($product);

        $this->productCategoryRepository
            ->shouldReceive('oneByProduct')
            ->with($product)
            ->once()
            ->andReturn($productCategory);

        $this->productCategoryRepository
            ->shouldReceive('remove')
            ->with($productCategory)
            ->once();

        $this->productRepository
            ->shouldReceive('remove')
            ->with($product)
            ->once();

        (new ProductRemover($this->productRepository, $this->productCategoryRepository))($id);
    }

    protected function setUp(): void
    {
        $this->productRepository = Mockery::mock(ProductRepositoryInterface::class);
        $this->productCategoryRepository = Mockery::mock(ProductCategoryRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
