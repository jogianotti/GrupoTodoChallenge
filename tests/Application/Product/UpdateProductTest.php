<?php declare(strict_types=1);

namespace App\Tests\Application\Product;

use App\Application\Category\CategoryFinder;
use App\Application\Product\ProductUpdater;
use App\Entity\ProductoCategoria;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ProductCategoryRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Tests\Application\Category\CategoryMother;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class UpdateProductTest extends TestCase
{
    /**
     * @var ProductRepositoryInterface|MockInterface
     */
    private $productRepository;
    /**
     * @var ProductCategoryRepositoryInterface|MockInterface
     */
    private $productCategoryRepository;
    /**
     * @var CategoryRepositoryInterface|MockInterface
     */
    private $categoryRepository;

    /** @doesNotPerformAssertions */
    public function testItShouldUpdateAProduct(): void
    {
        $id = 1;
        $product = ProductMother::create();
        $category_id = 1;
        $category = CategoryMother::create();
        $productCategory = new ProductoCategoria();
        $productCategory->setProduct($product);
        $productCategory->setCategory($category);

        $this->productRepository
            ->shouldReceive('one')
            ->with($id)
            ->once()
            ->andReturn($product);

        $this->categoryRepository
            ->shouldReceive('one')
            ->with($category_id)
            ->once()
            ->andReturn($category);

        $this->productCategoryRepository
            ->shouldReceive('oneByProduct')
            ->with($product)
            ->once()
            ->andReturn($productCategory);

        $this->productRepository
            ->shouldReceive('save')
            ->with($product)
            ->once();

        $this->productCategoryRepository
            ->shouldReceive('save')
            ->with($productCategory)
            ->once();

        (new ProductUpdater(
            $this->productRepository,
            $this->productCategoryRepository,
            new CategoryFinder($this->categoryRepository)
        ))(
            $id,
            $product->getName(),
            $product->getDescription(),
            $category_id
        );
    }

    protected function setUp(): void
    {
        $this->productRepository = Mockery::mock(ProductRepositoryInterface::class);
        $this->categoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
        $this->productCategoryRepository = Mockery::mock(ProductCategoryRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
